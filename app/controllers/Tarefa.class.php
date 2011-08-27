<?php

/**
 * 
 * A pagina recebe uma requisicao via GET e redireciona para o Controlador
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */

session_start();
include_once '../../conf/lock.php';
$tarefa = new Tarefa();

$acao = $_GET['acao'];

switch ($acao) {
    case "add": {
            $tarefa->salvar();
            break;
        }
    case 'concluir': {
            $tarefa->concluir();
            break;
        }
    case 'percentual': {
            $tarefa->mudarPercentual();
            break;
        }
}

/**
 * Controlador para o modulo Tarefas
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 * 
 */
class Tarefa {

    /**
     * Variavel que representa uma tarefa
     * 
     * @var tarefa
     */
    var $tarefa;

    /**
     * Variavel que representa uma alocador de recursos humanos
     * 
     * @var tarefaAlocaRecursoHumano 
     */
    var $tarref;

    /**
     * Utilizada para fazer conversoes...
     *
     * @var lib 
     */
    var $lib;

    /**
     * Contrutor da classe
     */
    function __contruct() {
        $this->tarefa = new TarefasRecord();
        $this->tarref = new TarefaAlocaRecursoHumanosRecord();
        $this->lib = new Lib();
    }

    /**
     * Metodo para salvar uma Tarefa no Banco de Dados
     *
     * @return boolean 
     */
    public function salvar() {
        $dados["fk_cd_projeto"] = $_POST["cd_projeto"];
        $dados["ds_tarefa"] = $_POST["ds_tarefa"];
        $dados["dt_incio"] = $this->lib->converterDataToUs($_POST['dt_incio']);
        $dados["dt_previsao"] = $this->lib->converterDataToUs($_POST["dt_previsao"]);
        $dados["nome_tarefa"] = $_POST["nome_tarefa"];
        $dados["fk_cd_status"] = 1;
        $dados["responsavel"] = $_POST["cd_usuario"];

        if ($_POST["cd_tarefa_sub"] == "") {
            
        } else {
            $dados['fk_cd_tarefa'] = $_POST["cd_tarefa_sub"];
        }
        if ($this->tarefa->cadastrarTarefa($dados)) {
            $id = $this->tarefa->ultimoId("tarefa_cd_tarefa_seq");
            $dadosRecHum['fk_cd_usuario'] = $_POST["cd_usuario"];
            $dadosRecHum['fk_cd_tarefa'] = $id;
            $dadosRecHum['dt_alocacao'] = date('Y-m-d');
            $dadosRecHum['dt_inicio_alocacao'] = date('Y-m-d');
            $dadosRecHum['fk_cd_tipocargo'] = 2;
            $dadosRecHum['valor_hora'] = 90;
            $this->tarref->cadastrarRecursoHumano($dadosRecHum);

            $_SESSION['str_erro'] = "<p>Adicionada com Sucesso</p>";
            header("location: ../views/tarefa?tarefa=" . $id);
            return true;
        } else {
            $_SESSION['str_erro'] = "<p>Falha ao ao adicionar a tarefa</p>";
            header("location: ../views/tarefas.php");
            return false;
        }
    }

    /**
     * Metodo para concluir uma tarefa
     */
    public function concluir() {
        $cd_tarefa = $_GET['tarefa'];
        if ($this->tarefa->concluirTarefa($cd_tarefa)) {
            header("location: ../views/tarefa.php?tarefa=" . $cd_tarefa);
        } else {
            header("location: ../views/tarefas.php");
        }
        session_unregister($_SESSION['cd_tarefa']);
    }

    /**
     * Metodo para mudar o percentual completo de uma tarefa
     */
    public function mudarPercentual() {
        $cd_tarefa = $_POST['cd_tarefa'];
        $dados['pcompleto'] = $_POST['porcento'];
        if ($this->tarefa->atualizarTarefa($dados, $cd_tarefa)) {
            header("location: ../views/tarefa.php?tarefa=" . $cd_tarefa);
        } else {
            header("location: ../views/tarefas.php");
        }
    }

}

?>
