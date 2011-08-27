<?php

/**
 * Recebi uma acao via GET e redireciona para o Controlador
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
include_once '../../conf/lock.php';

$acao = $_GET['acao'];
$recursoHumano = new RecursoHumano();

switch ($acao) {
    case "add": {
            $recursoHumano->salvar();

            break;
        }
    default:
        break;
}


/**
 * Classe controlador rrecursos humanos
 * 
 * @package app
 * @subpackage controllers
 * @author Paavo Soeiro
 */
class RecursoHumano {

    /**
     * Variavel de recursos humanos 
     * 
     * @var recursoHumano
     * @access private 
     */
    private $recursoHumano;

    /**
     * Utilizada para fazer conversoes...
     *
     * @var lib 
     * @access private
     */
    private $lib;

    /**
     * Contrutor da classe
     */
    function __construct() {
        $this->recursoHumano = new TarefaAlocaRecursoHumanosRecord();
        $this->lib = new Lib();
    }

    /**
     * Metodo utilizado para salvar um recurso no Banco de Dados
     *
     * @return boolean 
     */
    public function salvar() {
        $dados['fk_cd_tarefa'] = $_POST['cd_tarefa'];
        $dados['fk_cd_usuario'] = $_POST['cd_usuario'];
        $dados['dt_alocacao'] = $this->lib->converterDataToUs($_POST['dt_alocacao']);
        $dados['dt_inicio_alocacao'] = $this->lib->converterDataToUs($_POST['dt_inicio_alocacao']);
        $dados['fk_cd_tipocargo'] = (int) $_POST['cd_tipo_cargo'];
        $dados['valor_hora'] = $_POST['valor_hora02'];

        if ($this->recursoHumano->cadastrarRecursoHumano($dados)) {
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
    }

}

?>
