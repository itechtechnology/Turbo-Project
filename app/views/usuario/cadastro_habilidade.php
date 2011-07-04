<?php
/*
Nome: Cadastra Habilidade
Autor: Marcos Rosa
Criado em: 15/05/11
Modificado por: 
Descrição: Cadastra uma nova habilidade no sistema
*/
//include_once '../../controllers/usuario/seguranca.php'; 
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Sessao.class.php");
include_once ("../../models/usuario/Habilidade.class.php");    
require ("../../models/Template.class.php");


	$sessao = new Sessao();
	$user = $sessao->verifica_sessao();
	if($user == FALSE) Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
	
	$tpl = new Template("../../common/tpl/usuario/habilidade.tpl.html");
	
	if($_POST["descricao"]){//Se receber uma habilidade
		$titulo = $_POST["titulo"];
		$descricao = $_POST["descricao"];
		
		
		if(($titulo == '')or($descricao == '')){
			
			$tpl->TITULO_1 = "Habilidade";	
			if ($titulo == '') $tpl->TITULO_2 = "Você não digitou o título";
			if ($descricao == '') $tpl->TITULO_2 = "Você não digitou a descricao";
			$tpl->block("BLOCK_ERRO_TITULO");
		
		}
		
		else{
			
			$sql = "SELECT cd_habilidade FROM habilidade WHERE nome = '$titulo';";
			$minhaConexao = new Conexao(); //Crio uma conexão
			$result = $minhaConexao->envia_sql($sql);
			$row = pg_fetch_array($result);
			
			if($row[0] != NULL) {
				$tpl->TITULO_1 = "Habilidade";	
				$tpl->TITULO_2 = "Esse título já existe!";
				$tpl->block("BLOCK_ERRO_TITULO");
			}
			else{
				date_default_timezone_set('America/Sao_Paulo');
				$data_cadastro =  date("d/m/Y");

				$habilidade = new Habilidade(NULL, $titulo, $descricao, NULL);
				$habilidade->insert(); //Envio para o bd
			
				$tpl->block("BLOCK_HABILIDADE_OK");
				$tpl->TITULO_2 = "Habilidade cadastrada com sucesso!";
				$tpl->NOME = $titulo;
			}
		}
	}

	
	else{//Se não receber uma habilidade
	
		$tpl->TITULO_1 = "Mensagens";	
		$tpl->TITULO_2 = "Cadastrar nova habilidade";
		$tpl->block("BLOCK_ESCREVE");		
	}
	
	$tpl->show();
	
	
	

	
	
	
	








?>