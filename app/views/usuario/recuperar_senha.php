<?php
/*
Nome: Recupera senha
Autor: Marcos Rosa
Criado em: 17/05/11
Modificado por: 
Descrição: Recupera a senha de um usuário
*/
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Usuario.class.php"); 
require ("../../models/Template.class.php");

	
	
	
	$tpl = new Template("../../common/tpl/usuario/recuperar_senha.tpl.html");
	

//===================================================== < Tela principal> ============================================================	
	if(($_POST["login"])== NULL){//Se receber nenhum indentificador
		
		$tpl->TITULO_1 = "Recuperar senha"; //Título da página
		$tpl->TITULO_2 = "Recuperar senha"; //Título do bloco
		
		$sql = "SELECT * FROM opcoesperguntas;"; 
		$minhaConexao = new Conexao();
		$result = $minhaConexao->envia_sql($sql);
	
		while($row = pg_fetch_array($result)){
					
			$tpl->V_REP = $row[0]; //id da habilidade 
			$tpl->N_REP = $row[1]; //nome da habilidadae
			$tpl->block("BLOCK_REP");					
		}
	
		
		$tpl->block("BLOCK_ID1");
	}
	
	else{
		
		$cpf = $_POST["cpf"];
		$dt_nascimento = $_POST["dt_nascimento"];
		$login = $_POST["login"];
		$pergunta = $_POST["pergunta"];
		$resposta = $_POST["resposta"];
				
		if(($cpf == '')or($dt_nascimento == '')or($login == '')or($resposta == '')){//Algum campo vazio
					
				$tpl->TITULO_1 = "Erro"; //Título da página
				$tpl->TITULO_2 = "Erro ao recuperar senha"; //Título do bloco
					$tpl->{TXT} = "Você não preencheu todos os campos! É necessário que todos os itens sejam adicionados.";
					
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/recuperar_senha.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_OP");					
		}
		else{
			$sql = "SELECT cd_usuario, cpf, dt_nascimento  FROM usuario WHERE login = '$login';"; 
			$minhaConexao = new Conexao();
			$result = $minhaConexao->envia_sql($sql);
			$row = pg_fetch_array($result);
			
			if($row[0] == NULL){//Nào existe o login
				$tpl->TITULO_1 = "Erro"; //Título da página
				$tpl->TITULO_2 = "Erro ao recuperar senha"; //Título do bloco
				$tpl->{TXT} = "O login digitado não foi encontrado";
					
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/recuperar_senha.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_OP");
			}
			
			else if($row[1] != $cpf){//cpf não coincide
				$tpl->TITULO_1 = "Erro"; //Título da página
				$tpl->TITULO_2 = "Erro ao recuperar senha"; //Título do bloco
				$tpl->{TXT} = "O CPF digitado não coincide com o CPF de nosso sistema";
					
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/recuperar_senha.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_OP");
			}
			
			else if($row[2] != $dt_nascimento){//cpf não coincide
				$tpl->TITULO_1 = "Erro"; //Título da página
				$tpl->TITULO_2 = "Erro ao recuperar senha"; //Título do bloco
				$tpl->{TXT} = "O dara de nascimeto não coincide com a data de nosso sistema";
					
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/recuperar_senha.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_OP");
			}
			
			else {
				
				
				
			}
			
		}
				
			
	}
	

	
	$tpl->show();


?>