<?php
/*
Nome: Deslogar 1.1
Autor: Marcos Rosa
Criado em: 05/05/11
Modificado por: Marcos Rosa - Data 06/05/11
Descrição: Remove a sessão do usuário
*/ 
include_once '../../models/usuario/Sessao.class.php'; //Verifica se a sessão está ativa

	
	$sessao = new Sessao();
	
	$user = $sessao->verifica_sessao();
	
	if($user == FALSE) echo "Não existe nenhuma sessão ativa no momento!";
	else{
		$sessao->destroi_sessao();
		Header("Location: http://www.itech10.com"); //Redireciona para index 		
	}
	
	
	
?> 
