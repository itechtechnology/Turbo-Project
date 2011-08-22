<?php

include_once '../../conf/lock.php';

$recursoHumano = new TarefaAlocaRecursoHumanosRecord();
$lib = new Lib();
$acao = $_GET['acao'];

switch ($acao) {
    case "add": {
            $dados['fk_cd_tarefa'] = $_POST['cd_tarefa'];
            $dados['fk_cd_usuario'] = $_POST['cd_usuario'];
            $dados['dt_alocacao'] = $lib->converterDataToUs($_POST['dt_alocacao']);
            $dados['dt_inicio_alocacao'] = $lib->converterDataToUs($_POST['dt_inicio_alocacao']);
            $dados['fk_cd_tipocargo'] = (int) $_POST['cd_tipo_cargo'];
            $dados['valor_hora'] = $_POST['valor_hora02'];

            if ($recursoHumano->cadastrarRecursoHumano($dados)) {
                $_SESSION['str_erro'] = "<p>Alocado com sucesso</p>";
                header("Location: ../views/tarefa.php?tarefa=" . $_POST['cd_tarefa']);
                return true;
            } else {

                $_SESSION['str_erro'] = "<p>Falha ao alocar</p>" . $_POST['cd_tarefa'] . $dados['fk_cd_usuario'] . $dados['fk_cd_tipocargo'] .
                        "<p>" . $dados['dt_inicio_alocacao'] . "</p>" .
                        "<p>" . $dados['dt_alocacao'] . "</p>" .
                        "<p>" . $dados['valor_hora'] . "</p>";
                header("Location: ../views/tarefas.php");
                return false;
            }

            break;
        }
    default:
        break;
}
?>
