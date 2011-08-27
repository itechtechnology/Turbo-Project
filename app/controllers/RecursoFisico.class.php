<?php

/**
 * Recebi uma acao via GET e redireciona para o Controlador
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
include_once '../../conf/lock.php';

$rec = new RecursoFisico();

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar": {
            $rec->salvar();
            break;
        }
    case "edit": {
            break;
        }
    case "alocar": {
            $rec->alocar();
        }
    default:
        break;
}

/**
 * Controlador RecursoFisico
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
class RecursoFisico {

    /**
     * Variavel de recurso
     *
     * @var recurso 
     */
    var $recurso;

    /**
     * Variavel responsavel por alocar um recurso fisico
     *
     * @var tarefaAlocaRecursoFisico 
     */
    var $tarefaAlocaRecurso;

    /**
     * Utilizada para fazer conversoes...
     *
     * @var lib 
     */
    var $lib;

    /**
     * Contrutor da classe
     */
    function __construct() {
        $this->recurso = new RecursoFisicosRecord();
        $this->tarefaAlocaRecurso = new TarefaAlocaRecursoFisicosRecord();
        $this->lib = new Lib();
    }

    /**
     * Metodo utilizado para salvar um recurso no Banco de Dados
     *
     * @return boolean 
     */
    public function salvar() {

        $dados['nome_recurso'] = $_POST['nome_recurso'];
        $dados['custo'] = $_POST['custo'];
        $dados['ds_recurso'] = $_POST['ds_recurso'];
        $dados['fk_cd_statusrecurso'] = 1;

        if ($this->recurso->cadastrarRecurso($dados)) {
            $_SESSION['str_erro'] = "<p>Criado com sucesso</p>";
            header("Location: ../views/recursoFisicoList.php");
            return true;
        }else
            header("Location: ../views/recursoFisicoList.php");
        return false;
    }

    /**
     * Metodo para alocar um recurso fisico numa tarefa
     * 
     * @return boolean 
     */
    public function alocar() {
        $dados['fk_cd_tarefa'] = $_POST['cd_tarefa'];
        $dados['fk_cd_recurso'] = $_POST['cd_recurso'];
        $dados['dt_aloca_recurso'] = $this->lib->converterDataToUs($_POST['dt_alocacao_recurso']);
        $dados['dt_devolucao_recurso'] = $this->lib->converterDataToUs($_POST['dt_devolucao_recurso']);
        if ($this->tarefaAlocaRecurso->alocarRecurso($dados)) {
            $_SESSION['str_erro'] = "<p>Alocado com sucesso</p>";
            $this->recurso->atualizarStatus($_POST['cd_recurso']);
            header("Location: ../views/tarefa.php?tarefa=" . $_POST['cd_tarefa']);
            return true;
        } else {
            $_SESSION['str_erro'] = "<p>Falha</p>";
            header("Location: ../views/tarefa.php?tarefa=" . $_POST['cd_tarefa']);
            return false;
        }
        break;
    }

}

?>
