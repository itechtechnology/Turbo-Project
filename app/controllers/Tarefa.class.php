<?php

/**
 * Description of Tarefa
 *
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

include_once '../../conf/lock.php';

$tarefa = new TarefasRecord();
$lib = new Lib();

$acao = $_GET['acao'];

switch ($acao) {
    case "add": {
            $dados["fk_cd_projeto"] = $_POST["cd_projeto"];
            $dados["ds_tarefa"] = $_POST["ds_tarefa"];
            $dados["dt_incio"] = $lib->converterDataToUs($_POST['dt_incio']);
            $dados["dt_previsao"] = $lib->converterDataToUs($_POST["dt_previsao"]);
            $dados["nome_tarefa"] = $_POST["nome_tarefa"];
            $dados["fk_cd_status"] = 1;
            if ($tarefa->cadastrarTarefa($dados)) {
                $id = $tarefa->ultimoId("tarefa_cd_tarefa_seq");
                header("location: ../views/tarefa?tarefa=" . $id);
//                header("location: http://www.google.com");
                return true;
            } else {
                header("location: http://www.gmail.com");
                return false;
            }
            break;
        }
}
?>
