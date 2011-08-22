<?php

/**
 * @package pagepackage
 */
/**
 * Controlador RecursoFisico
 */
include_once '../../conf/lock.php';

$recurso = new RecursoFisicosRecord();
$tarefaAlocaRecurso = new TarefaAlocaRecursoFisicosRecord();
$lib = new Lib();

//$auditoria = new AuditoriasRecord();

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar": {
            $dados['nome_recurso'] = $_POST['nome_recurso'];
            $dados['custo'] = $_POST['custo'];
            $dados['ds_recurso'] = $_POST['ds_recurso'];
            $dados['fk_cd_statusrecurso'] = 1;


            if ($recurso->cadastrarRecurso($dados)) {
//                AuditoriasRecord::geraAuditoria();
//                $data['fk_cd_usuario'] = $_SESSION['login'];
                //            $auditoria->salvar($data);
                $_SESSION['str_erro'] = "<p>Criado com sucesso</p>";
                header("Location: ../views/recursoFisicoList.php");
                return true;
            }else
                header("Location: ../views/recursoFisicoList.php");
            return false;

            break;
        }
    case "edit": {
            break;
        }
    case "alocar": {
            $dados['fk_cd_tarefa'] = $_POST['cd_tarefa'];
            $dados['fk_cd_recurso'] = $_POST['cd_recurso'];
            $dados['dt_aloca_recurso'] = $lib->converterDataToUs($_POST['dt_alocacao_recurso']);
            $dados['dt_devolucao_recurso'] = $lib->converterDataToUs($_POST['dt_devolucao_recurso']);
            if ($tarefaAlocaRecurso->alocarRecurso($dados)) {
                $_SESSION['str_erro'] = "<p>Alocado com sucesso</p>";
                $recurso->atualizarStatus($_POST['cd_recurso']);
                header("Location: ../views/tarefa.php?tarefa=" . $_POST['cd_tarefa']);
                return true;
            } else {
                $_SESSION['str_erro'] = "<p>Falha</p>";
                header("Location: ../views/tarefa.php?tarefa=" . $_POST['cd_tarefa']);
                return false;
            }
            break;
        }
    default:
        break;
}
?>
