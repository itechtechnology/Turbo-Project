<?php

/**
 * Description of Produto
 *
 * @author LÍVIA CORREIA
 */
class Produto {

    private $nome;
//    private static $id=0;
    function __construct($nome) {
        $this->nome = $nome;
//        self::$id++;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
//    public static function getId(){
//        return self::$id;
//    }

}

?>
