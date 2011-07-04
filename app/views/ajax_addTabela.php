<?php  
        include_once '../../conf/lock.php';
       
        $DB = new DBManager();
       
        $tabelas = $DB->listarTabelas();
?>
        <label>
                Tabela:
                <select id="tabela" name="tabela" onchange="executaAjax(this.value,'ajax_listarCampos.php?filtro='+this.value,'boxColunas');">
                        <option value="selecione">Tabela</option>
<?php
                        $totalTabelas = count($tabelas['TABELA']);
                       
                        for($x=1;$x<=$totalTabelas;$x++)
                        {
                                $tabela = $tabelas['ESQUEMA'][$x].'.'.$tabelas['TABELA'][$x];
?>
                                <option value="<?php echo $tabela;?>"><?php echo strtoupper($tabela);?></option>
<?php
                        }
?>
                </select>
        </label><br />
        <span id="boxColunas">
        </span>

