<?php

require '../../conf/lock.php';

$tpl = new sistTemplate(APPTPLDIR . '/recurso.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->CSSDIR = APPCSSDIR;
$tpl->JSDIR = APPJSDIR;
//$tpl->WEBROOT = APPWEBROOT;
$tpl->SITETITLE = SITETITLE;
$tpl->FAVICON = FAVICON;
$tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
//$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
//$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');
$tpl->CONTROLLER = '../controllers/RecursoFisico.php?acao=salvar';
$tpl->NOME_RECURSO = '';
$tpl->CUSTO = '0';
$tpl->DS_RECURSO = '';
$tpl->show();
?>
