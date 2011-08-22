<?php

session_start();
require '../../conf/lock.php';
include_once '../../core/GoogChart.class.php';
require ('../../core/gChart.php');
if (!isset($_SESSION['login'])) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
//    header("location: ../../web/");
} else {
    $tarefa = new TarefasRecord();
    $usuario = new UsuariosRecord();
    $recurso = new RecursoFisicosRecord();

    $lib = new Lib();
    $tpl = new sistTemplate(APPTPLDIR . '/tarefarecursos.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;
//$tpl->WEBROOT = APPWEBROOT;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
//$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage() / 1000), 0, ',', '.');
//$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage() / 1000), 0, ',', '.');
    $tpl->CONTROLLERRECURSO = '../controllers/RecursoFisico.class.php?acao=alocar';
    $tpl->CONTROLLERCOLABORADOR = '../controllers/RecursoHumano.class.php?acao=add';
    if (isset($_SESSION['str_erro'])) {
        $tpl->ERROS = $_SESSION['str_erro'];
        $tpl->block("BLOCK_SCRIPT");
        session_unregister('str_erro');
    }
    $cd_tarefa = $_GET['tarefa'];
    $_SESSION['cd_tarefa'] = $cd_tarefa;
    $tar = $tarefa->getTarefaColaboradores($cd_tarefa);
    $task = $tarefa->getTarefaResponsavel($cd_tarefa);
    $tpl->CD_TAREFA = $cd_tarefa;
//    $tpl->TAM = count($task['NOME_TAREFA']);
//    $sql = "SELECT * FROM vtarefacolaboradores" . " and tarefaalocarecursohumano.fk_cd_tarefa = " . $cd_tarefa;
//    $tpl->TAM = $sql;
    $tpl->NOME_TAREFA = $task['NOME_TAREFA']['1'];
    $tpl->STATUS = $task['NOME_STATUS']['1'];
    $tpl->RESPONSAVEL = $task['RESPONSAVEL']['1'];
    $tpl->DT_INCIO = $lib->converterDataToBr($task['DT_INCIO']['1']);
    $tpl->DT_PREVISAO = $lib->converterDataToBr($task['DT_PREVISAO']['1']);
    $tpl->DT_CONCLUSAO = $lib->converterDataToBr($task['DT_CONCLUSAO']['1']);
    
    $tpl->DESCRICAO = $task['DS_TAREFA']['1'];
    

    for ($i = 1; $i <= count($tar['NOME_TAREFA']); $i++) {
        $tpl->ID = "class=\"linharow\" id=" . $tar['CD_USUARIO'][$i];
        $tpl->COLABORADOR = $tar['NOME'][$i];
        $tpl->CARGO = $tar['CARGO'][$i];
        $tpl->VALOR_HORA = $tar['VALOR_HORA'][$i];
        $tpl->block('BLOCK_LISTAGEM');
    }

    $usuarios = $usuario->getUsuariosNaoVinculadosATarefa($cd_tarefa);
    $totalUsuarios = count($usuarios['CD_USUARIO']);

    for ($i = 1; $i <= $totalUsuarios; $i++) {
        $tpl->CD_USUARIO = $usuarios['CD_USUARIO'][$i];
        $tpl->USUARIO = $lib->formatarNome($usuarios['NOME'][$i]);
        $tpl->USUARIOATUAL = '';
        $tpl->block("BLOCK_COLABORADOR");
    }

    $tpl->DT_ALOCACAO = '';
    $tpl->DT_INICIO_ALOCACAO = '';
    $tpl->DT_FIM_ALOCACAO = '';
    $tpl->VALOR_HORA02 = '';

    $cargos = $usuario->getCargos();
    $totalCargos = count($cargos['CD_TIPO_CARGO']);
    for ($i = 1; $i <= $totalCargos; $i++) {
        $tpl->CD_TIPO_CARGO = $cargos['CD_TIPO_CARGO'][$i];
        $tpl->CARGO = $lib->formatarNome($cargos['NOME_TIPO_CARGO'][$i]);
        $tpl->CARGOATUAL = '';
        $tpl->block("BLOCK_CARGO");
    }

    //gerar grafico percentual completo

    $completo = $task['PCOMPLETO']['1'];
    $piChart = new gPieChart();
    $piChart->addDataSet(array($completo, 100 - $completo));
    $piChart->setLegend(array("Completo", "Incompleto"));
    $piChart->setLabels(array("Completo", "Incompleto"));
    $piChart->setColors(array("023E88", "ffffde"));
    $piChart->setDimensions(200, 200);
    $piChart->addBackgroundFill('bg', "ffffff00");
//    $piChart->getUrl();
    $tpl->GRAFICO = $piChart->getUrl();

    $recursos = $recurso->getRecursosAlocados($cd_tarefa);
    for ($i = 1; $i <= count($recursos['CD_RECURSO']); $i++) {
        $tpl->ID_RECURSO = $recursos['CD_RECURSO'][$i];
        $tpl->RECURSO = $recursos['NOME_RECURSO'][$i];
        $tpl->CUSTO = $recursos['CUSTO'][$i];
        $tpl->DT_ALOCACAO_RECURSO_GRID = $lib->converterDataToUs($recursos['DT_ALOCA_RECURSO'][$i]);
        $tpl->DT_DEVOLUCAO_RECURSO = $lib->converterDataToUs($recursos['DT_DEVOLUCAO_RECURSO'][$i]);
        $tpl->block("BLOCK_LISTAGEM_RECURSO");
    }

    $rec = $recurso->getRecursosFisicosDisponiveis();
    //{CD_RECURSO}" {RECURSOOATUAL}>{RECURSO}
    for ($i = 1; $i <= count($rec['CD_RECURSO']); $i++) {
        $tpl->CD_RECURSO = $rec['CD_RECURSO'][$i];
        $tpl->RECURSO = $lib->formatarNome($rec['NOME_RECURSO'][$i]);
        $tpl->RECURSOATUAL = '';
        $tpl->block("BLOCK_RECURSO");
    }
    $tpl->DT_ALOCACAO_RECURSO = '';
    $tpl->DT_DEVOLUCAO_RECURSO = '';

//    $tpl->TOTAL = count($rec['CD_RECURSO']);
    $tpl->show();
}
?>
