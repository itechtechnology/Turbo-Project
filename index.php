<?php
/*
Nome: Página inicial 1.2
Autor: Marcos Rosa
Criado em: 01/05/11
Modificado por: Marcos Rosa - Data 05/05/11, Marcos Rosa - Data 06/05/11 
Descrição: Página inicial
*/

include_once 'sessao.php'; //Inclui ao Script PHP a classe Funcionário	
	$usuario = verifica_sessao();

	if($usuario == FALSE){ //Se a sessão não existir
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro Funcionário</title>
<link href="estilos/style.css" type="text/css" rel="stylesheet"> <!-- Aqui nós importaremos o estilo.css para a página-->
</head>

<body>

<div id="apDiv2">
	<img src="imagens/logo.jpg" width="919" height="144" />
</div>


<div id="apDiv1">
  <form action="modulos/usuario/login.php" method="POST">
		E-mail : <br> <input name="email" type="text" size="30"><br>
		Senha: <br> <input name="senha" type="password" size="30"> <br>
	  <input name="Enviar" type="submit" id="enviar" value="Enviar"> 
    </form>
	<p><a href="modulos/usuario/recuperar_senha.php">Esqueci a senha</a></p>
</div>

<div id="apDiv3">Desenvolvido por: iTech Technology Innovation</div>
</body>
</html>
<?php 
	}
	else Header("Location: modulos/usuario/pg_usuario.php"); //Redireciona para pg_usuario se o login já foi feito anteriomente
?>
