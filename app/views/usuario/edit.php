<?php
/*
Nome: Edita dados
Autor: Marcos Rosa
Criado em: 15/05/11
Modificado por: 
Descrição: Edita os dados do usuário
*/
include_once ("../../controllers/usuario/seguranca.php"); 
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Usuario.class.php");
include_once ("../../models/usuario/Sessao.class.php");  
require ("../../models/Template.class.php");

	
	$sessao = new Sessao();
	$user = $sessao->verifica_sessao();
	if($user == FALSE){
		 Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
		 exit;
	}
	$u = $user->getId(); //Código do usuário
	$ender = $user->getEndereco(); //Código do endereço
	
	$tpl = new Template("../../common/tpl/usuario/edit.tpl.html");
	

//================================================== < Tela menu principal> ====================================================	
	if(($_POST["id"])== NULL){//Se receber nenhum indentificador
		
		$tpl->TITULO_1 = "Editar dados"; //Título da página
		$tpl->TITULO_2 = "Editar dados"; //Título do bloco
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Senha";
		$tpl->T_BOT = "Alterar sua senha";
		$tpl->block("BLOCK_BOT");
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "E-mail";
		$tpl->T_BOT = "Alterar e-mail";
		$tpl->block("BLOCK_BOT");
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Endereço";
		$tpl->T_BOT = "Alterar endereço";
		$tpl->block("BLOCK_BOT");
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Telefones";
		$tpl->T_BOT = "Alterar telefones";
		$tpl->block("BLOCK_BOT");	
		
		
		$tpl->LINK_1 = "http://itech10.com/app/views/usuario/pg_usuario.php";
		$tpl->BOT_1 = "Voltar";
		$tpl->LINK_2 = NULL;
		$tpl->BOT_2 = NULL;
		
		$tpl->block("BLOCK_ID1");
	}
	

	else{
		switch ($_POST["id"]){
			
//=================================================== < Tela alterar senha > ===================================================
			case "Senha":
				
				$tpl->TITULO_1 = "Alterar senha"; //Título da página
				$tpl->TITULO_2 = "Alterar senha"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar senha";
				$tpl->T_BOT = "Alterar senha";
				$tpl->MAX = 32; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID2");
			break;
			
//=================================================== < Valida a senha > ===================================================			
			case "Alterar senha":
				
				$senha_atual = $_POST["senha1"];
				$nova_senha1 = $_POST["senha2"];
				$nova_senha2 = $_POST["senha3"];
				
				if(($senha_atual == '')or($nova_senha1 == '')or($nova_senha2 == '')){//Algum campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Erro ao alterar a senha"; //Título do bloco
					$tpl->{TXT} = "Você não preencheu todos os campos! É necessário que todos os itens sejam adicionados.";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}
				
				else if($nova_senha1 != $nova_senha2){//As senhas são diferentes
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Erro ao alterar a senha"; //Título do bloco
					$tpl->{TXT} = "As senhas digitadas são diferentes, por favor, digite duas senhas iguais.";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");	
				}
				
				else{
					$senha = md5($senha_atual); //Faz a criptografia da senha
									
					$sql = "SELECT senha FROM usuario WHERE cd_usuario = '$u' AND senha = '$senha';";
				
					$minhaConexao = new Conexao();
					$result = $minhaConexao->envia_sql($sql);
					$row = pg_fetch_array($result);
								
					if($row[0] == NULL){//A senha atual não existe
				
						$tpl->TITULO_1 = "Erro"; //Título da página
						$tpl->TITULO_2 = "Erro ao alterar a senha"; //Título do bloco
						$tpl->{TXT} = "A senha atual está incorreta!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
					}
				
					else{//Nenhum erro foi encontrado, alterar a senha
				
						$nova_senha =  md5($nova_senha1); //Faz a criptografia da senha
						$sql =  "UPDATE usuario SET senha = '$nova_senha' WHERE cd_usuario = '$u';";
					
						$minhaConexao->envia_sql($sql);
					
						$tpl->TITULO_1 = "Senha alterada com sucesso"; //Título da página
						$tpl->TITULO_2 = "Senha alterada com sucesso"; //Título do bloco
						$tpl->{TXT} = "Sua senha foi alterada com sucesso!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
					}
				}
			break;
			
//================================================== < Tela altera email > ======================================================
			case "E-mail":
				
				
				$sql = "SELECT email FROM usuario WHERE cd_usuario ='$u';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar E-mail"; //Título da página
				$tpl->TITULO_2 = "Alterar E-mail"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar E-mail";
				$tpl->ATUAL = "E-mail atual: $row[0]";//Valor atual
				$tpl->N_CASE = "email"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o seu E-mail";
				$tpl->NOME_L = "Novo E-mail";
				
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//=================================================== < Validae-mail> ===================================================			
			case "Alterar E-mail":
				
				$novo_email = $_POST["email"];
				
				if($novo_email == ''){//Algum campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Erro ao alterar o E-mail"; //Título do bloco
					$tpl->{TXT} = "Você não preencheu o E-mail!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}
				else{
					include_once "../../controllers/usuario/valida_email.func.php";
					
					if(!valida_email($novo_email)){//Se e-mail for inválido
					
						$tpl->TITULO_1 = "Erro"; //Título da página
						$tpl->TITULO_2 = "Erro ao alterar o E-mail"; //Título do bloco
						$tpl->{TXT} = "O E-mail digitado é inválido, por favor, digite um E-mail válido!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
					}
					else{
						$sql =  "UPDATE usuario SET email = '$novo_email' WHERE cd_usuario = '$u';";
						
						$minhaConexao = new Conexao();
						$minhaConexao->envia_sql($sql);
					
						$tpl->TITULO_1 = "E-mail alterado com sucesso"; //Título da página
						$tpl->TITULO_2 = "E-mail alterado com sucesso"; //Título do bloco
						$tpl->{TXT} = "Seu E-mail foi alterado com sucesso!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
					}					
				}
			break;	
//================================================= < Tela altera endereço > ===================================================					
			case "Endereço":
			
				$tpl->TITULO_1 = "Editar dados"; //Título da página
				$tpl->TITULO_2 = "Editar endereço"; //Título do bloco
		
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Rua";
				$tpl->T_BOT = "Alterar o nome da rua";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Número";
				$tpl->T_BOT = "Alterar o número da sua casa";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Complemento";
				$tpl->T_BOT = "Alterar o complemento da casa";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Bairro";
				$tpl->T_BOT = "Alterar o seu bairro";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Cidade";
				$tpl->T_BOT = "Alterar a sua cidade";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Estado";
				$tpl->T_BOT = "Alterar o seu estado";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "País";
				$tpl->T_BOT = "Alterar o seu país";
				$tpl->block("BLOCK_BOT");
		
		
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
		
				$tpl->block("BLOCK_ID1");				
			break;			
//=================================================== < Tela altera rua > =====================================================
			case "Rua":
				
				
				$sql = "SELECT rua FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Rua"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar rua";
				$tpl->ATUAL = "Rua atual: $row[0]";//Valor atual
				$tpl->N_CASE = "rua"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome da rua";
				$tpl->NOME_L = "Nova rua";
				
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//==================================================== < Validar rua > ========================================================			
			case "Alterar rua":
				
				$nova_rua = $_POST["rua"];
				
				if($nova_rua == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome da nova rua!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{
					
					$sql =  "UPDATE endereco SET rua = '$nova_rua' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Rua alterada"; //Título do bloco
					$tpl->{TXT} = "O nome da sua rua foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;	
		
//=================================================== < Tela altera número > =====================================================
			case "Número":
				
				$sql = "SELECT numero FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Número"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar numero";
				$tpl->ATUAL = "Número atual: $row[0]";//Valor atual
				$tpl->N_CASE = "numero"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o número da casa";
				$tpl->NOME_L = "Novo número";
				
				$tpl->MAX = 5; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//==================================================== < Validar número > ========================================================			
			case "Alterar numero":
				
				$novo_numero = $_POST["numero"];
				
				if($novo_numero == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o novo número da casa!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{
					
					$sql =  "UPDATE endereco SET numero = '$novo_numero' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Número alterado"; //Título do bloco
					$tpl->{TXT} = "O número da sua casa foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;	
			
//================================================= < Tela altera complemento > ==================================================
			case "Complemento":
				
				
				$sql = "SELECT complemento FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Complemento"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar complemento";
				$tpl->ATUAL = "Complemento atual: $row[0]";//Valor atual
				$tpl->N_CASE = "complemento"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome do complemento";
				$tpl->NOME_L = "Novo complemento";
				
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//=================================================== < Validar complemento > ====================================================			
			case "Alterar complemento":
				
				$novo_complemento  = $_POST["complemento"];
				
				if($novo_complemento == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome do novo complemento!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{
					
					
					$sql =  "UPDATE endereco SET complemento = '$novo_complemento' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Complemento alterado"; //Título do bloco
					$tpl->{TXT} = "O nome do seu complemento foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================= < Tela altera bairro > ======================================================
			case "Bairro":
				
				
				$sql = "SELECT bairro FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Bairro"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar bairro";
				$tpl->ATUAL = "Bairro atual: $row[0]";//Valor atual
				$tpl->N_CASE = "bairro"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome do bairro";
				$tpl->NOME_L = "Novo bairro";
				
				$tpl->MAX = 30; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//===================================================== < Validar bairro> =======================================================			
			case "Alterar bairro":
				
				$novo_bairro  = $_POST["bairro"];
				
				if($novo_bairro == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome do novo bairro!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{
					
					$sql =  "UPDATE endereco SET bairro = '$novo_bairro' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Bairro alterado"; //Título do bloco
					$tpl->{TXT} = "O nome do seu bairro foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================== < Tela altera cidade > ======================================================
			case "Cidade":
				
				
				$sql = "SELECT cidade FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Cidade"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar cidade";
				$tpl->ATUAL = "Cidade atual: $row[0]";//Valor atual
				$tpl->N_CASE = "cidade"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome da cidade";
				$tpl->NOME_L = "Nova cidade";
				
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//===================================================== < Validar cidade> ========================================================			
			case "Alterar cidade":
				
				$nova_cidade  = $_POST["cidade"];
				
				if($nova_cidade == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome da nova cidade!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{
					
					$sql =  "UPDATE endereco SET cidade = '$nova_cidade' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Cidade alterada"; //Título do bloco
					$tpl->{TXT} = "O nome da sua cidadde foi alterada com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================= < Tela altera estao > ======================================================
			case "Estado":
				
				
				$sql = "SELECT estado FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Estado"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar estado";
				$tpl->ATUAL = "Estado atual: $row[0]";//Valor atual
				$tpl->N_CASE = "pais"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome do estado";
				$tpl->NOME_L = "Novo estado";
				
				$tpl->MAX = 40; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ESTADO");
				
			break;
			
//===================================================== < Validar estado> =======================================================			
			case "Alterar estado":
				
				$novo_estado  = $_POST["estado"];
				
				if($novo_estado == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome do novo estado!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{					
					$sql =  "UPDATE endereco SET estado = '$novo_estado' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Estado alterado"; //Título do bloco
					$tpl->{TXT} = "O nome do seu estado foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================= < Tela altera pais > ======================================================
			case "País":
				
				
				$sql = "SELECT pais FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar País"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar país";
				$tpl->ATUAL = "País atual: $row[0]";//Valor atual
				$tpl->N_CASE = "pais"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o nome do país";
				$tpl->NOME_L = "Novo país";
				
				$tpl->MAX = 35; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//===================================================== < Validar país> =======================================================			
			case "Alterar país":
				
				$novo_pais  = $_POST["pais"];
				
				if($novo_pais == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o nome do novo país!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{					
					$sql =  "UPDATE endereco SET pais = '$novo_pais' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "País alterado"; //Título do bloco
					$tpl->{TXT} = "O nome do seu país foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================= < Tela altera telefones > ===================================================					
			case "Telefones":
			
				$tpl->TITULO_1 = "Editar dados"; //Título da página
				$tpl->TITULO_2 = "Editar telefones"; //Título do bloco
		
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Tel fixo";
				$tpl->T_BOT = "Alterar o telefone residencial";
				$tpl->block("BLOCK_BOT");
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Tel cel";
				$tpl->T_BOT = "Alterar o número do telefone celular";
				$tpl->block("BLOCK_BOT");
		
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
		
				$tpl->block("BLOCK_ID1");				
			break;
			
//================================================= < Tela altera tel fixo > =====================================================
			case "Tel fixo":
				
				
				$sql = "SELECT tel_fixo FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Telefone Fixo"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar telefone fixo";
				$tpl->ATUAL = "Telefone atual: $row[0]";//Valor atual
				$tpl->N_CASE = "tele_fixo"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o número do telefone";
				$tpl->NOME_L = "Novo telefone";
				
				$tpl->MAX = 16; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//================================================== < Validar telefone fixo> ====================================================			
			case "Alterar telefone fixo":
				
				$novo_telefone_fixo  = $_POST["tele_fixo"];
				
				if($novo_telefone_fixo == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o número do telefone residencial!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{					
					$sql =  "UPDATE endereco SET tel_fixo = '$novo_telefone_fixo' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Telefone  alterado"; //Título do bloco
					$tpl->{TXT} = "O número do seu telefone fixo foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;
			
//================================================= < Tela altera tel cel > =====================================================
			case "Tel cel":
				
				
				$sql = "SELECT tel_celular FROM endereco WHERE cd_endereco='$ender';";
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				$row = pg_fetch_array($result);
				
				$tpl->TITULO_1 = "Alterar dados"; //Título da página
				$tpl->TITULO_2 = "Alterar Telefone Celular"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar telefone celular";
				$tpl->ATUAL = "Telefone atual: $row[0]";//Valor atual
				$tpl->N_CASE = "tele_celular"; //Nove da variável que vai guardar a informação 
				$tpl->TXT = "Alterar o número do telefone";
				$tpl->NOME_L = "Novo telefone";
				
				$tpl->MAX = 16; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
//================================================== < Validar telefone fixo> ====================================================			
			case "Alterar telefone celular":
				
				$novo_telefone_cel  = $_POST["tele_celular"];
				
				if($novo_telefone_cel == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou o número do telefone celular!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}

				else{					
					$sql =  "UPDATE endereco SET tel_celular = '$novo_telefone_cel' WHERE cd_endereco = '$ender';";
						
					$minhaConexao = new Conexao();
					$minhaConexao->envia_sql($sql);
					
					$tpl->TITULO_1 = "Alterar dados"; //Título da página
					$tpl->TITULO_2 = "Telefone  alterado"; //Título do bloco
					$tpl->{TXT} = "O número do seu telefone celular foi alterado com sucesso!";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");
										
				}
			break;			
					
		}
	}

	$tpl->show();


?>