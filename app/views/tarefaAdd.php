<?php

/**
 * Esta pagina renderiza uma tela para adicionar tarefas
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
    $projetos = $projeto->listarProjetosIniciados();
    $tarefa = new TarefasRecord();
    $tarefas = $tarefa->getTarefasIniciadas();

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
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
//$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
//$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');

    $tpl->CONTROLLER = '../controllers/Tarefa.class.php?acao=add';
    $tpl->CD_TAREFA = '';
    $tpl->NOME_TAREFA = '';
    $tpl->DS_TAREFA = '';
    $tpl->DT_INCIO = '';
    $tpl->DT_PREVISAO = '';

    if (isset($_SESSION['str_erro'])) {
        $tpl->ERROS = $_SESSION['str_erro'];
        $tpl->block("BLOCK_SCRIPT");
        session_unregister('str_erro');
    }

    //carregar combo projetos
    $totalProjetos = count($projetos["CD_PROJETO"]);
//    $tpl->TOTAL = $totalProjetos;
    for ($i = 1; $i <= $totalProjetos; $i++) {
        $tpl->CD_PROJETO = $projetos['CD_PROJETO'][$i];
        $tpl->PROJETO = $lib->formatarNome($projetos['NOME_PROJETO'][$i]);
        $tpl->PROJETOATUAL = '';
        $tpl->block("BLOCK_PROJETO");
    }

    $totalTarefas = count($tarefas['CD_TAREFA']);
//    $tpl->TOTAL = $totalTarefas;
    for ($i = 0; $i <= $totalTarefas; $i++) {
//        if ($i == 0) {
//            $tpl->CD_TAREFA_SUB = "";
//        } else {
        $tpl->CD_TAREFA_SUB = $tarefas['CD_TAREFA'][$i];
        $tpl->TAREFA = $lib->formatarNome($tarefas['NOME_TAREFA'][$i]);
        $tpl->TAREFAATUAL = '';
        $tpl->block("BLOCK_TAREFA");
//        }
    }
    $usuarios = $u->getUsuarios();
    $totalUsuarios = count($usuarios['CD_USUARIO']);

    for ($i = 1; $i <= $totalUsuarios; $i++) {
        $tpl->CD_USUARIO = $usuarios['CD_USUARIO'][$i];
        $tpl->USUARIO = $lib->formatarNome($usuarios['NOME'][$i]);
        $tpl->USUARIOATUAL = '';
        $tpl->block("BLOCK_USUARIO");
    }

    $tpl->show();
}
?>