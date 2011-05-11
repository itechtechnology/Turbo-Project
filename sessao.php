<?php
/*
Nome: Cria, verifica e remove sessões 1.1
Autor: Marcos Rosa
Criado em: 05/05/11
Modificado por: Marcos Rosa - Data 06/05/11
Descrição: 3 funções para criar, verificar e remover a sessão de login
*/


//==============================================================================================================
function cria_sessao ($user){ //Irá criar uma nova sessão- Recebe um objeto usuário 
	
		if ($_SESSION['sessao'] == TRUE){//Se a sessão foi criada anteriomente
			Header("Location: modulos/usuario/pg_usuario.php"); //Se o usuário já estiver logado, redireciono para página do usuáio
		}		
		else{//Se o usuário ainda não fez login
			session_start(); //Inicio a sessão
			$_SESSION['usuario'] = $user;  
			$_SESSION['sessao'] = TRUE;			
			return FALSE;		
		}
}
//================================================================================================================
function verifica_sessao(){ //Verifico se a sessão está ativa
		
		session_start(); //Inicio a sessão			
		if ($_SESSION['sessao']){// Verifico se a sessão está ativada - se $_SESSION['sessao'] == TRUE		
			return $_SESSION['usuario']; //Retorna um objeto usuário	
		}
		else return FALSE;	
}
//================================================================================================================
function destroi_sessao(){ //Remove a sessão
	
	session_unset(); //Destroi as variáveis
	session_destroy(); //Destroi a sessão

	Header("Location: index.php"); //Redireciona para index 
}
//================================================================================================================
?>