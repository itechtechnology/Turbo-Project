<?php
/*
Nome: Edita dados
Autor: Marcos Rosa
Criado em: 15/05/11
Modificado por: 
Descrição: Edita os dados do usuário
*/
//include_once '../../controllers/usuario/seguranca.php'; 
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Usuario.class.php");
include_once ("../../models/usuario/Sessao.class.php");  
require ("../../models/Template.class.php");

	
	$sessao = new Sessao();
	$user = $sessao->verifica_sessao();
	if($user == FALSE) Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
	$u = $user->getId();
	
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
			
//================================================== < Tela alterar e-mail > ===================================================			
			case "E-mail":
			
				$tpl->TITULO_1 = "Alterar E-mail"; //Título da página
				$tpl->TITULO_2 = "Alterar E-mail"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Alterar E-mail";
				$tpl->T_BOT = "Alterar senha";
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID3");
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
				
				$ender = $user->getEndereco();
				
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
				$tpl->TXT = "Alterar o nome da rua";
				$tpl->NOME_L = "Nova rua:";
				
				$tpl->MAX = 50; //Número máximo de caracteres do formulário
				
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/edit.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_ID4");
				
			break;
			
			
			
			
			
			
			
			
			case "Número":
			break;
			case "Complemento":
			break;
			case "Bairro":
			break;
			case "Cidade":
			break;
			case "Estado":
			break;
			case "Pais":
			break;
			
			
			
			
			
			
			case "Telefones":
			break;
		}
	}





















	$tpl->show();





?>