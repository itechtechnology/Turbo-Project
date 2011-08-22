<?php

session_start();
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
} else {
    $projeto = new ProjetosRecord();

    $lib = new Lib();
    $tpl = new sistTemplate(APPTPLDIR . '/graficos.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
////    include 'grid.php';
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
////$tpl->WEBROOT = APPWEBROOT;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $tpl->CONTROLLER = "graficogantt.php";
    
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
