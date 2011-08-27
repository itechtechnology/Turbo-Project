<?php
/**
 * Esta pagina renderiza uma tela para adicionar recursos
 * 
 * @package app
 * @subpackage views
 * @author Paavo Soeiro
 * 
 * 
 */
session_start();
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
} else {
    $tpl = new sistTemplate(APPTPLDIR . '/recurso.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
    
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    
    $tpl->CONTROLLER = '../controllers/RecursoFisico.class.php?acao=salvar';
    $tpl->NOME_RECURSO = '';
    $tpl->CUSTO = '0';
    $tpl->DS_RECURSO = '';
    
    $tpl->show();
}
?>
