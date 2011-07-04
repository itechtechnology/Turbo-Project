<?php 

    //require("http://www.itech10.com/app/models/Template.class.php"); 
	//require("http://www.itech10.com/app/models/usuario/Sessao.class.php");
	include_once ("app/models/usuario/Sessao.class.php");
	include_once ("app/models/usuario/Usuario.class.php");
	require ("app/models/Template.class.php");
	
	$sessao = new Sessao();
	$tpl = new Template("app/common/tpl/index.tpl.html"); 
	
	
	$user = $sessao->verifica_sessao();// Verifico a sessão e se estiver ativa, retorno um objeto usuário
	if($user == FALSE){
		$tpl->block("BLOCK_OFF");
	}
	else {
		 $tpl->block("BLOCK_ON");
		 $tpl->NOME = $user->getNome(); 
		}
	
	$tpl->show(); 
	

 
     
?>