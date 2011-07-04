<?php

require '../../conf/lock.php';

//carregar usuarios
$usuario = new UsuariosRecord();
$usuarios = $usuario->listarUsuarios('nome', 'ASC');


$tpl = new sistTemplate(APPTPLDIR . '/auditoria.tpl.html');

$tpl->CONTROLLER = '../controllers/Auditoria.php?acao=salvar';
$tpl->NOME = '';
////$tpl->INFORMACAO = '';
////$tpl->ACAO = '';
//
////listar usuarios
//$totalUsuarios = count($usuarios);
//for ($i = 1; $i <= $totalUsuarios; $i++) {
//    $tpl->ID_USUARIO = $usuarios['CD_USUARIO'][$i];
//    $tpl->USUARIO = $usuarios['NOME'][$i];
//    $tpl->USUARIOATUAL = '';
//    $tpl->block("BLOCK_USUARIOS");
//}


$tpl->show();
?>
