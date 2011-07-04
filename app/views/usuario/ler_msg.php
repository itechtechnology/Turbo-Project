<?php
/*
Nome: Ler mensagem
Autor: Marcos Rosa
Criado em: 14/05/11
Modificado por: 
Descrição: Recebe um cd_mensagem e exibe a mensagem para o usuáio
*/



include_once '../../models/usuario/Conexao.class.php';
require ("../../models/Template.class.php");




$id = $_REQUEST['MSG'];
if($id == '') Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão

$sql = "SELECT * FROM mensagem WHERE cd_mensagem = '$id';";


$con = new Conexao();
$result = $con->envia_sql($sql);

$row = pg_fetch_array($result);

	$tpl = new Template("../../common/tpl/usuario/msg.tpl.html");
	$tpl->TITULO_1 = "Mensagens";	
	$tpl->TITULO_2 = $row[6];
	$tpl->MSG_TXT = $row[3];
	
	$sql =  "UPDATE mensagem SET status = '1' WHERE cd_mensagem = '$id';"; //Marca no bd mensagem como lida
	$con->envia_sql($sql);	//Envio a SQL
	
	$tpl->block("BLOCK_LER");
	$tpl->show();
?>
