<?php
/**
 * Esta pagina renderiza uma tela para editar um projeto
 * 
 * @package app
 * @subpackage views
 * @author Anderson Rodrigues
 */

$time = microtime();

require '../../conf/lock.php';


$projeto = new ProjetosRecord();
/*
 * @TODO preciso que marcos implemente o metodo listarColaboradoresAtivos
 * para que eu possa listar os usuarios a serem selecionados
 */

$lib = new Lib();

$tpl = new sistTemplate(APPTPLDIR . '/projeto.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->CSSDIR = APPCSSDIR;
$tpl->JSDIR = APPJSDIR;
$tpl->WEBROOT = APPWEBROOT;
$tpl->SITETITLE = SITETITLE;
$tpl->FAVICON = FAVICON;
$tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');
$tpl->CONTROLLER = '../controllers/projeto.php?acao=edit';
$projeto1 = $projeto->dadosProjeto($lib->antiInjection($_REQUEST['cd_projeto']));


$tpl->CD_PROJETO = $projeto1['CD_PROJETO'][0];
$tpl->NOME_PROJETO = $projeto1['NOME_PROJETO'][0];
$tpl->DS_PROJETO = $projeto1['DS_PROJETO'][0];
$tpl->DT_PREVISAO_TERMINO_PROJ = $projeto1['DT_PREVISAO_TERMINO_PROJ'][0];

$tpl->block("BLOCK_CONTROLE");


$tpl->DICA = 'SEM DICA';

$tpl->TIME = number_format((microtime() - $time), 3, ',', '.');
$tpl->show();
?>