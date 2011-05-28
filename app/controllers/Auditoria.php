<?php

include_once '../../conf/lock.php';

$auditoria = new AuditoriasRecord;

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar":
            $dados['nome'] = $_POST['nome'];
            $dados['usuario'] = $_POST['usuario'];
        break;

    default:
        break;
}
?>
