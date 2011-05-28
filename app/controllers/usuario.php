<?php

	include_once '../../conf/lock.php';
	
	session_start(); //Inicio a sessALo			
	if (isset($_SESSION["cadastro_usuario"])){// Verifico se a sessão existe
			$dados = unserialize($_SESSION["cadastro_usuario"]);
			$status = $dados["status"]; //Status atual do cadastro
			$login = $dados["login"];
 			$email = $dados["email"];
			$senha = $dados["senha"];
			$erros = $dados["erros"]; 	
	}
	else{
		 echo "Erro ao iniciar a sessão!!!";
		 exit;
	}

	

	$lib = new Lib(); 
	
	

	//$projeto = new ProjetosRecord();

	

	$acao = $_GET['acao'];
	
	

	$erros = NULL; 

	switch($acao){

		case "add1":
					
			$email = $_REQUEST['email'];
			$login = $_REQUEST['login'];
			$senha1 = $_REQUEST['senha1'];
			$senha2 = $_REQUEST['senha2'];
			
			
			if($login == ''){
				$erros .= "ERRO! - Você não preencheu o campo login <br>";
			}
			if($email == ''){
				$erros .= "ERRO! - Você não preencheu o campo E-mail <br>";
			}
			else if(!($lib->validaEmail($email))){
				$erros .= "ERRO! - Seu E-mail é inválido, por favor, digite um E-mail válido <br>";
			}
			if ( $senha1 == "" ){
	  			$erros .= "ERRO! - Você não preencheu o campo senha <br>";

			}
			if ( $senha2 == "" ){
	  			$erros .= "ERRO! - Você não confirmou a senha <br>";

			}  
			else if ( $senha1 != $senha2 ){
	  			$erros .= "ERRO! - As senhas digitadas não coincidem <br>";
			} 
			else $senha = md5($senha1); // Faz a criptografia da senha com o algoritmo md5
			
			if ($erros == NULL) $status = 2; //Passo para o próximo passo do cadastro
		
		break;
		
		
		

		case "edit":
		break;
	

		case "delete":
		break;


	}
	
	$dados["status"] = $status;  //VariAAvel sessALo iniciada
 	$dados["login"] = $login ;
	$dados["email"] = $email;
	$dados["senha"] = $senha;
	$dados["erros"] = $erros;
 	//gravo a sessao por padrao o php hj ja passa o serialize automaticamente nao precisa mais passar ela
 	$_SESSION["cadastro_usuario"] = serialize($dados);
			
	Header("Location: http://www.itech10.com/app/views/usuarioAdd.php");

?>