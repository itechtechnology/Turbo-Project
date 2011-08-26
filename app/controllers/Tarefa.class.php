<?php

/**
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
/*
 * "cd_tarefa"
 * "fk_cd_projeto"
 * "ds_tarefa"
 * "fk_cd_status"
 * "dt_conclusao"
 * "dt_incio"
 * "dt_previsao"
 * "dt_aprovacao"
 * "nome_tarefa"
 */
session_start();
include_once '../../conf/lock.php';

$tarefa = new TarefasRecord();
$tarref = new TarefaAlocaRecursoHumanosRecord();
$lib = new Lib();


$acao = $_GET['acao'];

switch ($acao) {
    case "add": {
//            session_unregister('str_erro');
            $dados["fk_cd_projeto"] = $_POST["cd_projeto"];
            $dados["ds_tarefa"] = $_POST["ds_tarefa"];
            $dados["dt_incio"] = $lib->converterDataToUs($_POST['dt_incio']);
            $dados["dt_previsao"] = $lib->converterDataToUs($_POST["dt_previsao"]);
            $dados["nome_tarefa"] = $_POST["nome_tarefa"];
            $dados["fk_cd_status"] = 1;
            $dados["responsavel"] = $_POST["cd_usuario"];

            if ($_POST["cd_tarefa_sub"] == "") {
                
            } else {
                $dados['fk_cd_tarefa'] = $_POST["cd_tarefa_sub"];
            }
            if ($tarefa->cadastrarTarefa($dados)) {
                $id = $tarefa->ultimoId("tarefa_cd_tarefa_seq");
                //alocar responsavel a tarefa com status de colaborador
//            $dadosRecHum['fk_cd_usuario'] = $_POST["cd_usuario"];
                $dadosRecHum['fk_cd_tarefa'] = $id;
                $dadosRecHum['fk_cd_usuario'] = $_POST['cd_usuario'];
                $dadosRecHum['dt_alocacao'] = date('Y-m-d');
                $dadosRecHum['dt_inicio_alocacao'] = date('Y-m-d');
                $dadosRecHum['fk_cd_tipocargo'] = 2;
                $dadosRecHum['valor_hora'] = 90;
                $tarref->cadastrarRecursoHumano($dadosRecHum);

                $_SESSION['str_erro'] = "<p>Adicionada com Sucesso</p>";
                header("location: ../views/tarefa?tarefa=" . $id);
//                header("location: http://www.google.com");
                return true;
            } else {
                $_SESSION['str_erro'] = "<p>Falha ao ao adicionar a tarefa</p>";
                header("location: http://www.gmail.com");
                return false;
            }

            break;
        }
    case 'concluir': {
//            $update['fk_cd_status'] = 6;
            $cd_tarefa = $_GET['tarefa'];
//            $update['dt_conclusao'] = date('Y-m-d');
//            $update['pcompleto'] = 100;
            if ($tarefa->concluirTarefa($cd_tarefa)) {
                header("location: ../views/tarefa.php?tarefa=" . $cd_tarefa);
            } else {
                header("location: ../views/tarefas.php");
            }
            session_unregister($_SESSION['cd_tarefa']);
            break;
        }
    case 'percentual': {
            $cd_tarefa = $_POST['cd_tarefa'];
            $dados['pcompleto'] = $_POST['porcento'];
            if($tarefa->atualizarTarefa($dados, $cd_tarefa)){
                header("location: ../views/tarefa.php?tarefa=" . $cd_tarefa);
            } else {
                header("location: ../views/tarefas.php");
            }
            break;
        }
}

class Tarefa {

    public static function validarTarefa() {
        return false;
    }

}

?>
