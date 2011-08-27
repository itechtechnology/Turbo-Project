<?php

/**
 * Página logout
 * Remove a sessão atual do usuário
 * 
 * @package app
 * @subpackage controllers
 * @author Marcos Rosa
 * @since 12/05/11
 */
require '../../conf/lock.php';

$usuario = new UsuariosRecord();
if ($usuario->verificaLogin()) {//Se a sessão existir
    $usuario->logout(); //Passo o login e a senha criptografada
    Header("Location: ../../index.php"); //Redireciona para index 
    exit;
} else {//A sessão está ativa
    echo "Não existe nenhum usuário logado no sistema!";
}
?>