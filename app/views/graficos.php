<?php

/**
 * Esta pagina renderiza uma tela para selecionar um projeto
 * para gerar o grafico de Gantt.
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
    $projeto = new ProjetosRecord();
    
    $tpl = new sistTemplate(APPTPLDIR . '/graficos.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $tpl->CONTROLLER = "graficogantt.php";
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
    $lib = new Lib();
    $projetos = $projeto->listarProjetos();
    $totalprojetos = count($projetos['CD_PROJETO']);
    for ($i = 1; $i <= $totalprojetos; $i++) {
        $tpl->CD_PROJETO = $projetos['CD_PROJETO'][$i];
        $tpl->PROJETO = $projetos['NOME_PROJETO'][$i];
        $tpl->PROJETOATUAL = '';
        $tpl->block('BLOCK_PROJETOS');
    }
    $tpl->show();
}
?>
