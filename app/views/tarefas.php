<?php

/**
 * Esta pagina renderiza uma tela para visualizar tarefas
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
    $tarefa = new TarefasRecord();
    $lib = new Lib();

    $tpl = new sistTemplate(APPTPLDIR . '/tarefasList.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $tpl->CONTROLLER = $_SERVER["PHP_SELF"];
    $tpl->TITULOLISTAGEM = 'Tarefas';
    $tpl->TITULOPROCURAR = 'LOCALIZAR';
    $tpl->DICA = 'DICA';
    $u = new UsuariosRecord();
    $uNome = $u->getNome($_SESSION['login']);
    $tpl->USUARIO_LOGADO = $uNome;

    if (isset($_SESSION['str_erro'])) {
        $tpl->ERROS = $_SESSION['str_erro'];
        $tpl->block("BLOCK_SCRIPT");
        session_unregister('str_erro');
    }
    if (isset($_GET['orderBy']) and isset($_GET['sort'])) {
        $ordCampo = $_GET['orderBy'];
        switch ($ordCampo) {
            case 'nome_projeto': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'nome_tarefa': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'ds_tarefa': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'dt_incio': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'dt_previsao': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'dt_conclusao': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->IMGORDEM7 = '';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
            case 'nome_status': {
                    if ($_GET['sort'] == 'ASC') {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
                        $tpl->SORT = 'DESC';
                    } else {
                        $tpl->IMGORDEM1 = '';
                        $tpl->IMGORDEM2 = '';
                        $tpl->IMGORDEM3 = '';
                        $tpl->IMGORDEM4 = '';
                        $tpl->IMGORDEM5 = '';
                        $tpl->IMGORDEM6 = '';
                        $tpl->IMGORDEM7 = '<img src="' . APPIMAGEDIR . '/up.gif" />';
                        $tpl->SORT = 'ASC';
                    }
                    break;
                }
        }
    } else {
        $ordCampo = 'nome_projeto';


        $tpl->IMGORDEM1 = '<img src="' . APPIMAGEDIR . '/down.gif" />';
        $tpl->IMGORDEM2 = '';
        $tpl->IMGORDEM3 = '';
        $tpl->IMGORDEM4 = '';
        $tpl->IMGORDEM5 = '';
        $tpl->IMGORDEM6 = '';
        $tpl->IMGORDEM7 = '';
        $tpl->SORT = 'DESC';
    }

    if (empty($_GET['pesquisa'])) {
        $tarefas = $tarefa->getTarefas('', $ordCampo, $tpl->SORT);
    } else {
        $texto = $lib->formatarString($_GET['pesquisa']);
        $tarefas = $tarefa->getTarefas($texto, $ordCampo, $tpl->SORT);
    }
    $totaltarefas = count($tarefas['CD_TAREFA']);
    if ($totaltarefas == 0)
        $tpl->TOTAL = 0;
    $tpl->TOTAL = $totaltarefas;

    if ($totaltarefas > 0) {
        $tpl->LEGENDA = ' recursos encontrados.';
    } else {
        $tpl->LEGENDA = ' recurso encontrado.';
    }

    for ($i = 1; $i <= $totaltarefas; $i++) {
        if ($i % 2 != 0) {
            $tpl->CLASS = '';
        } else {
            $tpl->CLASS = 'class="odd"';
        }

        $tpl->NOME_PROJETO = utf8_decode($tarefas['NOME_PROJETO'][$i]);
        $tpl->NOME_TAREFA = utf8_decode($tarefas['NOME_TAREFA'][$i]);
        $tpl->DS_TAREFA = $tarefas['DS_TAREFA'][$i];
        $tpl->DT_INICIO = $tarefas['DT_INCIO'][$i];
        $tpl->DT_PREVISAO = $tarefas['DT_PREVISAO'][$i];
        $tpl->DT_CONCLUSAO = $tarefas['DT_CONCLUSAO'][$i];
        $tpl->NOME_STATUS = $tarefas['NOME_STATUS'][$i];
        $tpl->VISUALIZAR = 'tarefa.php?tarefa=' . $tarefas['CD_TAREFA'][$i];
        $tpl->block('BLOCK_LISTAGEM');
    }
    $tpl->show();
}
?>
