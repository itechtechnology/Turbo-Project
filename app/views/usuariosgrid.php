<?php

require_once '../../jqgrid/jq-config.php';
// include the jqGrid Class
require_once ABSPATH . "php/jqGrid.php";
// include the driver class
require_once ABSPATH . "php/jqGridPdo.php";
// Connection to the server
$conn = new PDO('pgsql:host=localhost dbname=itechcom_turbo user=itechcom password=itechuesc123');
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT cd_usuario, nome, login FROM usuario';
// set the ouput format to json
$grid->dataType = 'json';
$oper = $_POST['oper'];
if ($oper == 'edit') {
    $grid->table = 'usuario';
    $grid->setPrimaryKeyId('cd_usuario');
    $data = $_POST;
    $grid->update($data);
} else {
    $grid->queryGrid();
}
?>
