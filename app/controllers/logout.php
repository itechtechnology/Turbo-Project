<?php
/*
Nome: Página logout
Autor: Marcos Rosa
Criado em: 12/05/11
Modificado por: 03/06/11
Descrição: Remove a sessão atual do usuário
*/

require '../../conf/lock.php';



	$usuario = new UsuariosRecord();

	
	if($usuario->verificaLogin()){//Se a sessão existir
		 
		$usuario->logout();//Passo o login e a senha criptografada
		Header("Location: ../../index.php"); //Redireciona para index 
		exit;
	
	}
	else{//A sessão está ativa
		echo "Não existe nenhum usuário logado no sistema!";
	}

?>