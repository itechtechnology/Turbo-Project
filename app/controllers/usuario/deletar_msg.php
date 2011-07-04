<?php
/*
Nome: Deleta mensagem
Autor: Marcos Rosa
Criado em: 14/05/11
Modificado por: 
Descrição: Deleta uma mensagem 
*/



include_once '../../models/usuario/Conexao.class.php';




$id = $_REQUEST['MSG'];
if($id == '') Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão

$sql = "DELETE FROM mensagem WHERE cd_mensagem = '$id';";

$con = new Conexao();
$con->envia_sql($sql);


Header("Location: ../../views/usuario/lista_msg.php");
	
?>
