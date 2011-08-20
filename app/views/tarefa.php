<?php

session_start();
require '../../conf/lock.php';
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
//    header("location: ../../web/");
} else {
    $tarefa = new TarefasRecord();
    $usuario = new UsuariosRecord();
    $tpl = new sistTemplate(APPTPLDIR . '/tarefarecursos.tpl.html');
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
//    $tpl->CONTROLLERRECURSO = '../controllers/Tarefa.class.php?acao=add';
//    $tpl->CONTROLLECOLABORADOR = '../controllers/Tarefa.class.php?acao=add';
    $tar = $tarefa->getTarefaColaboradores($_GET['tarefa']);
    $tpl->TAM = count($tar['NOME_TAREFA']);
//    $sql = "SELECT * FROM vtarefacolaboradores" . " and tarefaalocarecursohumano.fk_cd_tarefa = " . $_GET['tarefa'];
//    $tpl->TAM = $sql;
    $tpl->NOME_TAREFA = $tar['NOME_TAREFA']['2'];
    
    for ($i = 1; $i <= count($tar['NOME_TAREFA']); $i++) {
        $tpl->COLABORADOR = $tar['NOME'][$i];
        $tpl->CARGO = $tar['CARGO'][$i];
        $tpl->VALOR_HORA = $tar['VALOR_HORA'][$i];
        $tpl->block('BLOCK_LISTAGEM');
    }
    
//    $usuarios = $usuario->getUsuarios();


    $tpl->show();
}
?>
