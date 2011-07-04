<?php
/*
Nome: Lista mensagens
Autor: Marcos Rosa
Criado em: 13/05/11
Modificado por: 
Descrição: Lista as mensagens de um usuáio
*/
//include_once '../../controllers/usuario/seguranca.php'; 
include_once '../../models/usuario/Mensagem.class.php';
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Usuario.class.php");
include_once ("../../models/usuario/Sessao.class.php");  
require ("../../models/Template.class.php");
include_once '../../controllers/usuario/converte_data.func.php';

	$sessao = new Sessao();
	$user = $sessao->verifica_sessao();
	if($user == FALSE) Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
	
	if($_POST["destinatario"]){//Se receber uma mensagem
		$destinatario = $_POST["destinatario"];
		$titulo = $_POST["titulo"];
		$msg = $_POST["msg"];
		
		$tpl = new Template("../../common/tpl/usuario/msg.tpl.html");
		
		if(($titulo == '')or($msg == '')){
			
			$tpl->TITULO_1 = "Mensagens";	
			if ($titulo == '') $tpl->TITULO_2 = "Você não digitou o título";
			if ($msg == '') $tpl->TITULO_2 = "Você não digitou o conteúdo da mensagem";
			$tpl->block("BLOCK_ERRO_TITULO");
		
		}
		
		else{
		
		
			$sql = "SELECT cd_usuario, nome FROM usuario WHERE login = '$destinatario';";
			$minhaConexao = new Conexao(); //Crio uma conexão
			$result = $minhaConexao->envia_sql($sql);
			$row = pg_fetch_array($result);
		
		
			$tpl->TITULO_1 = "Mensagens";	
			$tpl->TITULO_2 = "Erro de destino";
		
			if($row == FALSE){//O destinatário não existe
		 		$tpl->block("BLOCK_ERRO_LOGIN");
		 		$tpl->DESTINATARIO = $destinatario;
			}
			else{
				$mensagem = new Mensagem(NULL, $user, $row[0], $msg, NULL, 0, $titulo);
				$mensagem->insert();
				$tpl->TITULO_1 = "Mensagens";
				$tpl->TITULO_2 = "Mensagem enviada com sucesso";
				$tpl->block("BLOCK_MSG_OK");
				$tpl->NOME = $row[1];
			}
		}
		$tpl->show();
	}

	
	
	else{//Se não receber uma mensagem
			
		$tpl = new Template("../../common/tpl/usuario/msg.tpl.html");
	
		$tpl->TITULO_1 = "Mensagens";	
		$tpl->TITULO_2 = "Escrever nova mensagem";
		$tpl->block("BLOCK_ESCREVE");
		$tpl->show();		
	}
	
	
	
	
	
	
	
	








?>