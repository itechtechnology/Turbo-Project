<?php

include_once '../../conf/lock.php';

$recurso = new RecursoFisicosRecord();
//$auditoria = new AuditoriasRecord();

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar": {
            $dados['nome_recurso'] = $_POST['nome_recurso'];
            $dados['custo'] = $_POST['custo'];
            $dados['ds_recurso'] = $_POST['ds_recurso'];
            header("Location: ../views/recursoAdd.php");

            if ($recurso->cadastrarRecurso($dados)) {
//                $data['fk_cd_usuario'] = $_SESSION['login'];
                //            $auditoria->salvar($data);
                return true;
            }else
                return false;
        }
        break;

    default:
        break;
}
?>
