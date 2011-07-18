<?php

include_once '../../conf/lock.php';

$recurso = new RecursosRecord;

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar": {
            $dados['nome'] = $_POST['nome'];
            $dados['custo'] = $_POST['custo'];
            $dados['descricao'] = $_POST['descricao'];
            header("Location: ../views/recursoSalvar.php");
            
            return $recurso->cadastrarRecurso($dados);
        }
        break;

    default:
        break;
}
?>
