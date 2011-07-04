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
	
	$destinatario = $user->getId();//Seleciono as mensagens do usuário logado,  ordenando por data e hora 
	$sql = "SELECT * FROM mensagem WHERE destinatario = '$destinatario' ORDER BY hora DESC;";
		
	$minhaConexao = new Conexao(); //Crio uma conexão
	$result = $minhaConexao->envia_sql($sql); //Envio a SQL
	
	
	$tpl = new Template("../../common/tpl/usuario/msg.tpl.html");
	$tpl->TITULO_1 = "Mensagens";	
	$tpl->TITULO_2 = "Suas mensagens";
	
	
	$n_lida=0;
	$total=0;
	$minhaConexao->open();	
	while ($row = pg_fetch_array($result)){
		
			
		
		$tpl->DATA = converte_data($row[4]);
		$tpl->ID_MSG = $row[0];
		$tpl->TITULO_3 = $row[6];
		
		$remetente = $row[1];
		
		$sql = "SELECT nome FROM usuario WHERE cd_usuario = '$remetente';";
		$r = $minhaConexao->envia_sql2($sql); //Envio a SQL
		$r2 = pg_fetch_array($r);
		
		$tpl->REMETENTE = $r2[0];
		
		$total++; //Total de mensagens
		if($row[5] == 1)$tpl->STATUS = "msg_on";
		if($row[5] == 0){
			$tpl->STATUS = "msg_off";
			$n_lida++; //Mensagens não lidas
		}
		
		$tpl->block("BLOCK_LIST");
		
	}
	$tpl->TOTAL = $total;
	$tpl->N_LIDAS = $n_lida;
	$minhaConexao->close();

	$tpl->block("BLOCK_LISTA");



	$tpl->show();





?>