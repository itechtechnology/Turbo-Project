<?php

/**
 * Controlador de auditoria
 * 
 * @package app
 * @subpackage controllers
 * @author Anderson Rodrigues
 */
include_once '../../conf/lock.php';

$auditoria = new AuditoriasRecord;

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar":
        $dados['nome'] = $_POST['nome'];
        $dados['usuario'] = $_POST['usuario'];
        break;
    case "gerar":
        $dados['nome'] = $_POST['nome'];
        $dados['usuario'] = $_POST['usuario'];
        $dados['modulo'] = $_POST['modulo'];
        break;

    default:
        break;
}
?>
