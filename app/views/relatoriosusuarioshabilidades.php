<?php

/**
 * Esta pagina renderiza uma tela para visualizar o relatorio de usuarios e suas habilidades
 * 
 * @package app
 * @subpackage views
 * @author Paavo Soeiro
 * 
 * 
 */
session_start();
require_once '../../jqgrid/tabs.php';
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
} else {
    $tpl = new sistTemplate(APPTPLDIR . '/relatorios.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
    $tpl->GRID = 'usuarioshabilidadesgrid.js';
    $tpl->show();
}
?>
