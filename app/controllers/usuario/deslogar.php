<?php
/*
Nome: Deslogar 1.1
Autor: Marcos Rosa
Criado em: 05/05/11
Modificado por: Marcos Rosa - Data 08/06/11
Descrição: Remove a sessão do usuário
*/ 
//include_once '../../models/usuario/Sessao.class.php'; //Verifica se a sessão está ativa

include_once '../../../conf/lock.php';

	
	$usuario = new UsuarioRecord();
	$usuario->logout();
	
	
	
	
?> 
