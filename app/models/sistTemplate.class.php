<?php
/**
 * Mecanismo de Template para PHP5
 *
 * Mecanismos de Template permitem manter o c�digo HTML em arquivos externos
 * que ficam completamente livres de código PHP. Dessa forma, consegue-se manter
 * a l�gica de programa��o (PHP) separada da estrutura visual (HTML ou XML, CSS, etc).
 *
 * Se voc� j� � familiar ao uso de mecanismos de template PHP, esta classe inclui
 * algumas melhorias: suporte à objetos, automaticamente detecta blocos, mant�m uma
 * lista interna das vari�veis que existem, limpa automaticamente blocos "filhos",
 * avisando quando tentamos chamar blocos ou vari�veis que s�o existem, avisando quando
 * criamos blocos "mal formados", e outras pequenas ajudas.
 *
 * @author Rael G.C. (rael.gc@gmail.com)
 * @version 1.9
 */
class sistTemplate {

        /**
         * A list of existent document variables.
         *
         * @var       array
         */
        private $vars = array();

        /**
         * A hash with vars and values setted by the user.
         *
         * @var       array
         */
        private $values = array();

        /**
         * A hash of existent object properties variables in the document.
         *
         * @var       array
         */
        private $properties = array();

        /**
         * A hash of the object instances setted by the user.
         *
         * @var       array
         */
        private $instances = array();

        /**
         * A list of all automatic recognized blocks.
         *
         * @var       array
         */
        private $blocks = array();

        /**
         * A list of all blocks that contains at least a "child" block.
         *
         * @var       array
         */
        private $parents = array();

        /**
         * Describes the replace method for blocks. See the Template::setFile()
         * method for more details.
         *
         * @var       boolean
         */
        private $accurate;

        /**
         * Regular expression to find var and block names.
         * Only alfa-numeric chars and the underscore char are allowed.
         *
         * @var         string
         */
        private static $REG_NAME = "([[:alnum:]]|_)+";

        /**
         * Cria um novo template, usando $filename como arquivo principal
         *
         * Quando o par�metro $accurate � true, a substitui��o dos blocos no arquivo
         * final ser� perfeitamente fiel ao arquivo original, isto �, todas as tabula��es
         * ser�o removidas. Isso vai ter um pequeno preju�zo na performance, que pode variar
         * de acordo com a vers�o do PHP em uso. Mas � �til quando estamos usando tags HTML
         * como &lt;pre&gt; ou &lt;code&gt;. Em outros casos, ou melhor, quase sempre,
         * nunca se mexe no valor de $accurate.
         *
         * @param     string $filename          caminho do arquivo que ser� lido
         * @param     booelan $accurate         true para fazer substitui��o fiel das tabula��es
         */
        public function __construct($filename, $accurate = false){
                $this->accurate = $accurate;
                $this->loadfile(".", $filename);

        }

        /**
         * Adiciona o conte�do do arquivo identificado por $filename na vari�vel de template
         * identificada por $varname
         *
         * @param     string $varname           uma vari�vel de template existente
         * @param     string $filename          arquivo a ser carregado
         */
        public function addFile($varname, $filename){
                if(!$this->exists($varname)) throw new InvalidArgumentException("addFile: var $varname n�o existe");
                $this->loadfile($varname, $filename);
        }

        /**
         * N�o use este m�todo, ele serve apenas para podemos acessar as vari�veis
         * de template diretamente.
         *
         * @param       string  $varname        template var name
         * @param       mixed   $value          template var value
         */
        public function __set($varname, $value){
                if(!$this->exists($varname)) throw new RuntimeException("var $varname n�o existe");
                $stringValue = $value;
                if(is_object($value)){
                        $this->instances[$varname] = $value;
                        if(!array_key_exists($varname, $this->properties)) $this->properties[$varname] = array();
                        if(method_exists($value, "__toString")) $stringValue = $value->__toString();
                        else $stringValue = "Object";
                }
                $this->setValue($varname, $stringValue);
                return $value;
        }

        /**
         * N�o use este m�todo, ele serve apenas para podemos acessar as vari�veis
         * de template diretamente.
         *
         * @param       string  $varname        template var name
         */
        public function __get($varname){
                if (isset($this->values["{".$varname."}"])) return $this->values["{".$varname."}"];
                throw new RuntimeException("var $varname n�o existe");
        }

        /**
         * Verifica se uma vari�vel de template existe.
         *
         * Retorna true se a vari�vel existe. Caso contr�rio, retorna false.
         *
         * @param       string  $varname        template var name
         */
        public function exists($varname){
                return in_array($varname, $this->vars);
        }

        /**
         * Loads a file identified by $filename.
         *
         * The file will be loaded and the file's contents will be assigned as the
         * variable's value.
         * Additionally, this method call Template::recognize() that identifies
         * all blocks and variables automatically.
         *
         * @param     string $varname           contains the name of a variable to load
         * @param     string $filename          file name to be loaded
         *
         * @return    void
         */
        private function loadfile($varname, $filename) {
                if (!file_exists($filename)) throw new InvalidArgumentException("arquivo $filename n�o existe");
                // Reading file and hiding comments
                $str = preg_replace("/<!---.*?--->/smi", "", file_get_contents($filename));
                $blocks = $this->recognize($str, $varname);
                if (empty($str)) throw new InvalidArgumentException("arquivo $filename est� vazio");
                $this->setValue($varname, $str);
                $this->createBlocks($blocks);
        }

        /**
         * Identify all blocks and variables automatically and return them.
         *
         * All variables and blocks are already identified at the moment when
         * user calls Template::setFile(). This method calls Template::identifyVars()
         * and Template::identifyBlocks() methods to do the job.
         *
         * @param     string    $content                file content
         * @param     string    $varname                contains the variable name of the file
         *
         * @return    array             an array where the key is the block name and the value is an
         *                                              array with the children block names.
         */
        private function recognize(&$content, $varname){
                $blocks = array();
                $queued_blocks = array();
                foreach (explode("\n", $content) as $line) {
                        if (strpos($line, "{")!==false) $this->identifyVars($line);
                        if (strpos($line, "<!--")!==false) $this->identifyBlocks($line, $varname, $queued_blocks, $blocks);
                }
                return $blocks;
        }

        /**
         * Identify all user defined blocks automatically.
         *
         * @param     string $line                              contains one line of the content file
         * @param     string $varname                   contains the filename variable identifier
         * @param     string $queued_blocks             contains a list of the current queued blocks
         * @param     string $blocks                    contains a list of all identified blocks in the current file
         *
         * @return    void
         */
        private function identifyBlocks(&$line, $varname, &$queued_blocks, &$blocks){
                $reg = "/<!--\s*BEGIN\s+(".self::$REG_NAME.")\s*-->/sm";
                preg_match($reg, $line, $m);
                if (1==preg_match($reg, $line, $m)){
                        if (0==sizeof($queued_blocks)) $parent = $varname;
                        else $parent = end($queued_blocks);
                        if (!isset($blocks[$parent])){
                                $blocks[$parent] = array();
                        }
                        $blocks[$parent][] = $m[1];
                        $queued_blocks[] = $m[1];
                }
                $reg = "/<!--\s*END\s+(".self::$REG_NAME.")\s*-->/sm";
                if (1==preg_match($reg, $line)) array_pop($queued_blocks);
        }

        /**
         * Identifies all variables defined in the document.
         *
         * @param     string $line                              contains one line of the content file
         */
        private function identifyVars(&$line){
                $r = preg_match_all("/{(".self::$REG_NAME.")((\-\>(".self::$REG_NAME."))*)?}/", $line, $m);
                if ($r){
                        for($i=0; $i<$r; $i++){
                                // Object var detected
                                if($m[3][$i] && (!array_key_exists($m[1][$i], $this->properties) || !in_array($m[3][$i], $this->properties[$m[1][$i]]))){
                                        $this->properties[$m[1][$i]][] = $m[3][$i];
                                }
                                if(!in_array($m[1][$i], $this->vars)) $this->vars[] = $m[1][$i];
                        }
                }
        }

        /**
         * Create all identified blocks given by Template::identifyBlocks().
         *
         * @param     array $blocks             contains all identified block names
         * @return    void
         */
        private function createBlocks(&$blocks) {
                $this->parents = array_merge($this->parents, $blocks);
                foreach($blocks as $parent => $block){
                        foreach($block as $chield){
                                if(in_array($chield, $this->blocks)) throw new UnexpectedValueException("bloco duplicado: $chield");
                                $this->blocks[] = $chield;
                                $this->setBlock($parent, $chield);
                        }
                }
        }

        /**
         * A variable $parent may contain a variable block defined by:
         * &lt;!-- BEGIN $varname --&gt; content &lt;!-- END $varname --&gt;.
         *
         * This method removes that block from $parent and replaces it with a variable
         * reference named $block. The block is inserted into the varKeys and varValues
         * hashes.
         * Blocks may be nested.
         *
         * @param     string $parent    contains the name of the parent variable
         * @param     string $block             contains the name of the block to be replaced
         * @return    void
         */
        private function setBlock($parent, $block) {
                $name = "B_".$block;
                $str = $this->getVar($parent);
                if($this->accurate){
                        $str = str_replace("\r\n", "\n", $str);
                        $reg = "/\t*<!--\s*BEGIN\s+$block\s+-->\n*(\s*.*?\n?)\t*<!--\s+END\s+$block\s*-->\n?/sm";
                }
                else $reg = "/<!--\s*BEGIN\s+$block\s+-->\s*(\s*.*?\s*)<!--\s+END\s+$block\s*-->\s*/sm";
                if(1!==preg_match($reg, $str, $m)) throw new UnexpectedValueException("bloco $block est� mal formado");
                $this->setValue($name, '');
                $this->setValue($block, $m[1]);
                $this->setValue($parent, preg_replace($reg, "{".$name."}", $str));
        }

        /**
         * Internal setValue() method.
         *
         * The main difference between this and Template::__set() method is this
         * method cannot be called by the user, and can be called using variables or
         * blocks as parameters.
         *
         * @param     string $varname           constains a varname
         * @param     string $value        constains the new value for the variable
         * @return    void
         */
        private function setValue($varname, $value) {
                $this->values["{".$varname."}"] = $value;
        }

        /**
         * Returns the value of the variable identified by $varname.
         *
         * @param     string    $varname        the name of the variable to get the value of
         * @return    string    the value of the variable passed as argument
         */
        private function getVar($varname) {
                return $this->values['{'.$varname.'}'];
        }

        /**
         * Limpa o valor de uma vari�vel
         *
         * O mesmo que $this->setValue($varname, "");
         *
         * @param     string $varname   nome da vari�vel
         */
        public function clear($varname) {
                $this->setValue($varname, "");
        }

        /**
         * Fill in all the variables contained within the variable named
         * $varname. The resulting value is returned as the function result and the
         * original value of the variable varname is not changed. The resulting string
         * is not "finished", that is, the unresolved variable name policy has not been
         * applied yet.
         *
         * @param     string    $varname      the name of the variable within which variables are to be substituted
         * @return    string    the value of the variable $varname with all variables substituted.
         */
        private function subst($varname) {
                $s = $this->getVar($varname);
                // Common variables replacement
                $s = str_replace(array_keys($this->values), $this->values, $s);
                // Object variables replacement
                foreach($this->instances as $var => $instance){
                        foreach($this->properties[$var] as $properties){
                                if(false!==strpos($s, "{".$var.$properties."}")){
                                        $pointer = $instance;
                                        $property = explode("->", $properties);
                                        for($i = 1; $i < sizeof($property); $i++){
                                                $obj = str_replace('_', '', $property[$i]);
                                                // Non boolean accessor
                                                if(method_exists($pointer, "get$obj")){
                                                        $pointer = $pointer->{"get$obj"}();
                                                }
                                                // Boolean accessor
                                                elseif(method_exists($pointer, "is$obj")){
                                                        $pointer = $pointer->{"is$obj"}();
                                                }
                                                // Magic __get accessor
                                                elseif(method_exists($pointer, "__get")){
                                                        $pointer = $pointer->__get($property[$i]);
                                                }
                                                // Accessor dot not exists: throw Exception
                                                else {
                                                        $className = $property[$i-1] ? $property[$i-1] : get_class($instance);
                                                        $class = is_null($pointer) ? "NULL" : get_class($pointer);
                                                        throw new BadMethodCallException("n�o existe m�todo na classe ".$class." para acessar ".$className."->".$property[$i]);
                                                }
                                        }
                                        // Checking if final value is an object
                                        if(is_object($pointer)){
                                                if(method_exists($pointer, "__toString")){
                                                        $pointer = $pointer->__toString();
                                                } else {
                                                        $pointer = "Object";
                                                }
                                        }
                                        // Replace
                                        $s = str_replace("{".$var.$properties."}", $pointer, $s);
                                }
                        }
                }
                return $s;
        }

        /**
         * Clear all child blocks of a given block.
         *
         * @param     string $block     a block with chield blocks.
         */
        private function clearBlocks($block) {
                if (isset($this->parents[$block])){
                        $chields = $this->parents[$block];
                        foreach($chields as $chield){
                                $this->clear("B_".$chield);
                        }
                }
        }

        /**
         * Mostra um bloco.
         *
         * Esse m�todo deve ser chamado quando um bloco deve ser mostrado.
         * Sem isso, o bloco n�o ir� aparecer no conte�do final.
         *
         * Se o par�metro $append for true, o conte�do do bloco ser�
         * adicionado ao conte�do que j� existia antes. Ou seja, use true
         * quando quiser que o bloco seja duplicado.
         *
         * @param     string $block             nome do bloco que deve ser mostrado
         * @param     boolean $append           true se o conte�do anterior deve ser mantido (ou seja, para duplicar o bloco)
         */
        public function block($block, $append = true) {
                if(!in_array($block, $this->blocks)) throw new InvalidArgumentException("bloco $block n�o existe");
                if ($append) $this->setValue("B_".$block, $this->getVar("B_".$block) . $this->subst($block));
                else $this->setValue("B_".$block, $this->subst($block));
                $this->clearBlocks($block);
        }

        /**
        * Retorna o conte�do final, sem mostr�-lo na tela.
        * Se voc� quer mostr�-lo na tela, use o m�todo Template::show().
        *
        * @return    string
        */
        public function parse() {
                // After subst, remove empty vars
                return preg_replace("/{(".self::$REG_NAME.")((\-\>(".self::$REG_NAME."))*)?}/", "", $this->subst("."));
        }

        /**
         * Mostra na tela o conte�do final.
         */
        public function show() {
                echo $this->parse();
        }

}
?>
