<?php

/**
 * Recebe um e-mail e uma senha e faz o login do usuário no sistema
 * 
 * @package app
 * @subpackage controllers
 * @author Marcos Rosa
 * @since 12/05/11
 *
 */
@ require '../../conf/lock.php';


//Recebo email e senha pelo método post
$login = $_POST['login'];
$senha = $_POST['senha'];


$usuario = new UsuariosRecord();

if (!$usuario->verificaLogin()) {//Se a sessão não existir
    @ $resposta = $usuario->login($login, md5($senha)); //Passo o login e a senha criptografada


    if ($resposta) {//Login criado com uscesso
        header("location: ../views");
    } else {//Login ou senha incorreta
//			echo "Login ou senha incorreta";
//			
        echo "<script type='text/javascript'>alert('Login ou senha incorretos');
        location.href='../../web'</script>";
    }
} else {//A sessão está ativa
//		echo "Login efetuado anteriomente";
//		
    header("location: ../views");
}
?>
