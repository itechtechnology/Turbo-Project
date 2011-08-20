<?php

session_start();
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
//    header("location: ../../web/");
} else {
    $projeto = new ProjetosRecord();
//    $projetos = $projeto->listarProjetos();
//    $projetos = $projeto->getProjetos();
    $projetos = $projeto->listarProjetosIniciados();
    $lib = new Lib();
    
    $tpl = new sistTemplate(APPTPLDIR . '/tarefa.tpl.html');
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
    $tpl->CONTROLLER = '../controllers/Tarefa.class.php?acao=add';
    $tpl->CD_TAREFA = '';
    $tpl->NOME_TAREFA = '';
    $tpl->DS_TAREFA = '';
    $tpl->DT_INCIO = '';
    $tpl->DT_PREVISAO = '';

    //carregar combo projetos
    $totalProjetos = count($projetos["CD_PROJETO"]);
//    $tpl->TOTAL = $totalProjetos;
    for ($i = 1; $i <= $totalProjetos; $i++) {
        $tpl->CD_PROJETO = $projetos['CD_PROJETO'][$i];
        $tpl->PROJETO = $lib->formatarNome($projetos['NOME_PROJETO'][$i]);
        $tpl->PROJETOATUAL = '';
        $tpl->block("BLOCK_PROJETO");
    }
    //carregar combo usuarios
    
    //carregar recursos

    $tpl->show();
}
?>