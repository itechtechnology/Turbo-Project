<?php

require_once '../../jqgrid/tabs.php';
require '../../conf/lock.php';
$tpl = new sistTemplate(APPTPLDIR . '/relatorios.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
////$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->CSSDIR = APPCSSDIR;
$tpl->JSDIR = APPJSDIR;
$tpl->TITULO = SITETITLE;
$tpl->GRID = 'usuariosgrid.js';
$tpl->show();
//require_once dirname(__FILE__).'/tabs.php';
?>

