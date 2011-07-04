<?php
/*
Nome: Página cadastro
Autor: Marcos Rosa
Criado em: 12/05/11
Modificado por: 
Descrição: Faz o cadastro de um novo usuário no sistem
*/
//include_once 'http://www.itech10.com/app/controllers/usuario/segurenca.php'; 
require ("../../models/Template.class.php");
include_once "../../models/usuario/Conexao.class.php";


$tpl = new Template("../../common/tpl/usuario/cadastro.tpl.html");


	$sql = "SELECT * FROM opcoesperguntas;"; 
	$minhaConexao = new Conexao();
	$result = $minhaConexao->envia_sql($sql);
	
	while($row = pg_fetch_array($result)){
					
		$tpl->V_REP = $row[0]; //id da habilidade 
		$tpl->N_REP = $row[1]; //nome da habilidadae
		$tpl->block("BLOCK_REP");					
	}




$tpl->show(); 



?>