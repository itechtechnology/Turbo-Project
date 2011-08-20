<?php

require_once '../../jqgrid/jq-config.php';
// include the jqGrid Class
require_once ABSPATH . "php/jqGrid.php";
// include the driver class
require_once ABSPATH . "php/jqGridPdo.php";
require_once ABSPATH . "php/jqAutocomplete.php";

/**
 * Description of RelatorioFactory
 *
 * @author liviacorreia
 */
class RelatorioFactory {

    private $conn;
    private $grid;

    public function __construct() {
        $this->conn = new PDO('pgsql:host=localhost dbname=itechcom_turbo user=itechcom password=itechuesc123');
// Create the jqGrid instance
        $this->grid = new jqGridRender($this->conn);
// Write the SQL Query
// set the ouput format to json
        $this->grid->dataType = 'json';
    }

    public function gerarRelatorio($relatorio) {
        switch ($relatorio) {
            case 'recurso': {
                    $this->grid->SelectCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
                    $this->grid->ExportCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
//            $export = $_POST['oper'];
//            if ($export == 'excel') {
//                // let set summary field
////                $grid->exportToPdf(array('recurso' => 'nome_recurso'));
//                $grid->exportToExcel(array('recurso' => 'nome_recurso'));
//            } else {
//                $grid->queryGrid();
                    $export = $_POST['oper'];

                    if ($export == 'pdf')
                    // let set summary field
                        $this->grid->exportToPdf(array('recurso' => 'nome_recurso'));
                    else
                        $this->grid->queryGrid();
//            }
                    break;
                }
            case 'usuarioshabilidades': {
                    $this->grid->SelectCommand = 'SELECT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario';
//            $grid->setAutocomplete("usuario", false, "SELECT DISTINCT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario WHERE usuario.nome LIKE ? ORDER BY usuario.nome", null, false, true);
                    $this->grid->queryGrid();
                    break;
                }
            case 'usuarios': {
                    $this->grid->SelectCommand = 'SELECT cd_usuario, nome, login FROM usuario';
                    $oper = $_POST['oper'];
                    if ($oper == 'edit') {
                        $this->grid->table = 'usuario';
                        $this->grid->setPrimaryKeyId('cd_usuario');
                        $data = $_POST;
                        $this->grid->update($data);
                    } else {
                        $this->grid->queryGrid();
                    }
                    break;
                }
        }
    }

}

?>
