<?php
/*
Nome: Página seguranca
Autor: Marcos Rosa
Criado em: 12/05/11
Modificado por: 
Descrição: Deve ser add no cabeçalho de todas as páginas - Vai fazer a segurança do login
*/
//Obs:. Futuramente vão ser add outras coisas a essa página
include_once '../../models/usuario/Sessao.class.php'; 

	
	$sessao = new Sessao();	
	$user = $sessao->verifica_sessao();
	
	if($user == FALSE){
		 Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
		exit;
	}
?>