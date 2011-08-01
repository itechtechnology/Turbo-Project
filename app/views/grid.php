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
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum" => 5,
    "sortname" => "cd_usuario",
    "rowList" => array(5, 10, 50),
));
// Change some property of the field(s)
$grid->setColProperty("cd_usuario", array('editable'=>false, "label" => "ID", "width" => 60));
//$grid->setColProperty("OrderDate", array(
//    "formatter"=>"date",
//    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
//    )
//);
$grid->navigator = true;
// Enable search 
$grid->setNavOptions('navigator', array("excel" => false, "add" => false, "edit" => true, "del" => false, "view" => false));

$grid->setNavOptions('search', array("multipleSearch" => false));
// Enjoy
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$conn = null;
?>
