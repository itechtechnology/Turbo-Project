<?php

/**
 * @package pagepackage
 */
/**
 * Controlador RecursoFisico
 */
include_once '../../conf/lock.php';

$recurso = new RecursoFisicosRecord();
//$auditoria = new AuditoriasRecord();

$acao = $_GET['acao'];

switch ($acao) {
    case "salvar": {
            $dados['nome_recurso'] = $_POST['nome_recurso'];
            $dados['custo'] = $_POST['custo'];
            $dados['ds_recurso'] = $_POST['ds_recurso'];
            $dados['fk_cd_statusrecurso'] = 1;


            if ($recurso->cadastrarRecurso($dados)) {
//                AuditoriasRecord::geraAuditoria();
//                $data['fk_cd_usuario'] = $_SESSION['login'];
                //            $auditoria->salvar($data);
                $_SESSION['str_erro'] = "<p>Criado com sucesso</p>";
                header("Location: ../views/recursoFisicoList.php");
                return true;
            }else
                header("Location: ../views/recursoFisicoList.php");
                return false;

            break;
        }
    case "edit": {
            break;
        }
    default:
        break;
}
?>
