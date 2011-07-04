<?php
/*
Nome: Página login
Autor: Marcos Rosa
Criado em: 12/05/11
Modificado por: 03/06/11
Descrição: Recebe um e-mail e uma senha e faz o login do usuário no sistema
*/

require '../../conf/lock.php';


	//Recebo email e senha pelo método post
	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$usuario = new UsuarioRecord();

	
	if(!$usuario->verificaLogin()){//Se a sessão não existir
		 
		@ $resposta = $usuario->login($login, md5($senha));//Passo o login e a senha criptografada
		
		if($resposta){//Login criado com uscesso
			echo "O login foi efetuado com sucesso";
			?>
            <p>Página do usuário: <a href="../views/pg_usuario.html">pg_usuario</a></p>
            <p>Sair: <a href="logout.php">logout</a></p>
            <?php
		}
		else {//Login ou senha incorreta
			echo "Login ou senha incorreta";
			?>
            <p><a href="http://itech10.com">Voltar</a></p>
            <?php
		}
	
	}
	else{//A sessão está ativa
		echo "Login efetuado anteriomente";
		?>
         <p>Página do usuário: <a href="../views/pg_usuario.html">pg_usuario</a></p>
         <p>Sair: <a href="logout.php">logout</a></p>
        <?php
	}

	
	
?>
