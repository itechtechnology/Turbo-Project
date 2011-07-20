<?php

session_start();
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
//    header("location: ../../web/");
} else {
    $recurso = new RecursoFisicosRecord();
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
    $tpl->CONTROLLER = '../controllers/RecursoFisico.class.php?acao=edit';
    $recursos = $recurso->dadosRecurso($_GET['cd_recurso']);
    $tpl->CD_RECURSO = $recursos['CD_RECURSO']['0'];
    $tpl->NOME_RECURSO = $recursos['NOME_RECURSO']['0'];
    $tpl->CUSTO = $recursos['CUSTO']['0'];
    $tpl->DS_RECURSO = $recursos['DS_RECURSO']['0'];;
    $tpl->show();
}
?>
?>
