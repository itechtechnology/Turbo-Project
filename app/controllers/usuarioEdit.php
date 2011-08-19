<?php

	include_once '../../conf/lock.php';
	
	$lib = new Lib();
	
	$usuario = new UsuariosRecord();
	$endereco = new EnderecosRecord();
	
	
	
	
	
	
		
	if (isset($_SESSION["edita_usuario"])){// Verifico se a sessão existe
		$dados = unserialize($_SESSION["edita_usuario"]);
		
		$status = $dados["status"]; //Status atual do cadastro
		
 		$email = $dados["email"];
		$senha = $dados["senha"];
		
		
		$cd_usuario = $dados["cd_usuario"];
		$cd_endereco = $dados["cd_endereco"];

		$telefone_fixo = $dados["telefone_fixo"];
		$telefone_celular = $dados["telefone_celular"];
		$rua = $dados["rua"];
		$numero = $dados["numero"];
		$complemento = $dados["complemento"];
		$bairro = $dados["bairro"];
		$cidade = $dados["cidade"];
		$cep = $dados["cep"];
		$estado = $dados["estado"];
		$pais = $dados["pais"];
		//$pergunta = $dados["pergunta"];
		//$resposta = $dados["resposta"];
		//$habilidade1 = $dados["habilidade1"];		
		$erros = $dados["erros"]; 
			
	}
	else{
		 echo "Erro ao iniciar a sessão!!!";
		 exit;
	}
	
	
	

	$lib = new Lib(); 
	
	

	

	$acao = $_GET['acao'];
	
	

	$erros = NULL; 

	switch($acao){

		case "edit_email":
		
			$email = $_REQUEST['email'];
			
			if($email == ''){
				$erros .= "ERRO! - Você não preencheu o campo E-mail <br>";
			}
			else if(!($lib->validaEmail($email))){
				$erros .= "ERRO! - Seu E-mail é inválido, por favor, digite um E-mail válido <br>";
			}
			else if($usuario->emailExiste($email)){
				$erros .= "ERRO! - Esse email já é cadastrado, por favor, escolha um email diferente <br>";
			}
			
			if ($erros == NULL){
				 $status = 1; //Passo para o próximo passo do cadastro				 
				 $dados["email"] = $email;
				 $_SESSION["edita_usuario"] = serialize($dados);
				 
				 $dados_['EMAIL'] =  $email;
				 $usuario->atualizarUsuario($dados_, $cd_usuario);
			}
				
		break;
		
		case "edit_senha":
		
			$senha1 = $_REQUEST['senha1'];
			$senha2 = $_REQUEST['senha2'];
			$senha3 = $_REQUEST['senha3'];
			
			if($senha1 == ''){
				$erros .= "ERRO! - Você não preencheu o campo senha atual <br>";
			}
			else if($senha != md5($senha1)){
				$erros .= "ERRO! - A senha atual está incorreta <br>";
			}
			if($senha2 == ''){
				$erros .= "ERRO! - Você não preencheu o campo nova senha <br>";
			}
			else if($senha3 == ''){
				$erros .= "ERRO! - Você não preencheu o campo confirmar senha <br>";
			}
			else if($senha2 != $senha3){
				$erros .= "ERRO! - As senhas não coincidem <br>";
			}

						
			if ($erros == NULL){
				 $status = 1; //Passo para o próximo passo do cadastro				 
				 $dados["senha"] = md5($senha2);
				 $_SESSION["edita_usuario"] = serialize($dados);
				 
				 $dados_['SENHA'] =  md5($senha2);
				 $usuario->atualizarUsuario($dados_, $cd_usuario);
			}
				
		break;
		
		case "edit_telefone":
		
			$telefone_fixo = $_REQUEST['telefone_fixo'];
			$telefone_celular = $_REQUEST['telefone_celular'];
		
			
			if($telefone_fixo == ''){
				$erros .= "ERRO! - Você não preencheu o campo telefone fixo <br>";
			}
		
			if($telefone_celular == ''){
				$erros .= "ERRO! - Você não preencheu o campo telefone celular <br>";
			}
			
						
			if ($erros == NULL){
				 $status = 1; //Passo para o próximo passo do cadastro				 
				 $dados["telefone_fixo"] = $telefone_fixo;
				 $dados["telefone_celular"] = $telefone_celular;
				 $_SESSION["edita_usuario"] = serialize($dados);
				 
				 $dados_['TEL_FIXO'] =  $telefone_fixo;
				 $dados_['TEL_CELULAR'] =  $telefone_celular;
				 $endereco->atualizarEndereco($dados_, $cd_endereco);
				
			}
				
		break;
		
		
		case "edit_endereco":
		
			$rua = $_REQUEST['rua'];
			$numero = $_REQUEST['numero'];
			$complemento = $_REQUEST['complemento'];
			$bairro = $_REQUEST['bairro'];
			$cidade = $_REQUEST['cidade'];
			$cep = $_REQUEST['cep'];
			$estado = $_REQUEST['estado'];
			$pais = $_REQUEST['pais'];
			
			
			if($rua == ''){
				$erros .= "ERRO! - Você não preencheu o campo endereço <br>";
			}
			if($numero == ''){
				$erros .= "ERRO! - Você não preencheu o campo número <br>";
			}
			if($bairro == ''){
				$erros .= "ERRO! - Você não preencheu o campo bairro <br>";
			}
			if($cidade == ''){
				$erros .= "ERRO! - Você não preencheu o campo cidade <br>";
			}
			if($cep == ''){
				$erros .= "ERRO! - Você não preencheu o campo CEP <br>";
			}
			if($estado == ''){
				$erros .= "ERRO! - Você não preencheu o campo estado <br>";
			}
			if($pais == ''){
				$erros .= "ERRO! - Você não preencheu o campo país <br>";
			}
			
						
			if ($erros == NULL){
				 $status = 1; //Passo para o próximo passo do cadastro				 
				 $dados["rua"] = $rua;
				 $dados["numero"] = $numero;
				 $dados["complemento"] = $complemento;
				 $dados["bairro"] = $bairro; 
				 $dados["cidade"] = $cidade;
				 $dados["cep"] = $cep; 
				 $dados["estado"] = $estado;
				 $dados["pais"] = $pais;
				 $_SESSION["edita_usuario"] = serialize($dados);
				 
				 $dados_['RUA'] = $rua;
				 $dados_['NUMERO'] = $numero;
				 $dados_['COMPLEMENTO'] = $complemento;
				 $dados_['BAIRRO'] = $bairro;
			     $dados_['CIDADE'] = $cidade;
				 $dados_['CEP'] = $cep;
				 $dados_['PAIS'] = $pais;
				 $dados_['ESTADO'] = $estado;
				 
	
				 $endereco->atualizarEndereco($dados_, $cd_endereco);
				
			}
				
		break;
		
	
		
		case "cancelar": 
			$status = 1;			
		break;
		case "email": 
			$status = 2;			
		break;
		case "senha": 
			$status = 3;			
		break;
		case "telefone": 
			$status = 4;			
		break;
		case "endereco": 
			$status = 5;			
		break;
		
		
			
		
		break;
	
	

	}
	
	
	

	
	$dados["erros"] = $erros;
	$dados["status"] = $status;
 	$_SESSION["edita_usuario"] = serialize($dados);
			
	Header("Location: ../views/usuarioEdit.php");

?>