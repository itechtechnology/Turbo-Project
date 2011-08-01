<?php

require_once '../../jqgrid/jq-config.php';
// include the jqGrid Class
require_once ABSPATH . "php/jqGrid.php";
// include the driver class
require_once ABSPATH . "php/jqGridPdo.php";
require_once ABSPATH . "php/jqAutocomplete.php";
// Connection to the server
$conn = new PDO('pgsql:host=localhost dbname=itechcom_turbo user=itechcom password=itechuesc123');
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// set the ouput format to json
$grid->dataType = 'json';
switch ($_GET['relatorio']) {
    case 'recurso': {
            $grid->SelectCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
//            $grid->ExportCommand = 'SELECT cd_recurso, nome_recurso, ds_recurso, custo, nome_statusrecurso FROM vrecursostatus';
//            $export = $_POST['oper'];

//            if ($export == 'excel') {
//                // let set summary field
////                $grid->exportToPdf(array('recurso' => 'nome_recurso'));
//                $grid->exportToExcel(array('recurso' => 'nome_recurso'));
//            } else {
//                $grid->queryGrid();
            $grid->queryGrid();
//            }
            break;
        }
    case 'usuarioshabilidades': {
            $grid->SelectCommand = 'SELECT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario';
//            $grid->setAutocomplete("usuario", false, "SELECT DISTINCT usuario.nome as usuario, habilidade.nome as habilidade FROM habilidade JOIN  usuariohabilidade ON habilidade.cd_habilidade = usuariohabilidade.fk_cd_habilidade JOIN usuario ON usuariohabilidade.fk_cd_usuario = usuario.cd_usuario WHERE usuario.nome LIKE ? ORDER BY usuario.nome", null, false, true);
            $grid->queryGrid();
            break;
        }
    case 'usuarios': {
            $grid->SelectCommand = 'SELECT cd_usuario, nome, login FROM usuario';
            $oper = $_POST['oper'];
            if ($oper == 'edit') {
                $grid->table = 'usuario';
                $grid->setPrimaryKeyId('cd_usuario');
                $data = $_POST;
                $grid->update($data);
            } else {
                $grid->queryGrid();
            }
            break;
        }
}
?>
