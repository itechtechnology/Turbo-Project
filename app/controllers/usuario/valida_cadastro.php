<?php
/*
Nome: Página valida login 1.0
Autor: Marcos Rosa
Criado em: 08/05/11
Modificado por: 
Descrição: Valida os dados do formulário cadastra_usuario.php e envia a informações para o banco
*/

include_once '../../controllers/usuario/valida_email.func.php';
include_once '../../controllers/usuario/valida_data.func.php';
include_once '../../models/usuario/Usuario.class.php'; 
include_once '../../models/usuario/Conexao.class.php';
include_once '../../models/usuario/Endereco.class.php';
include_once '../../models/Template.class.php';



$nome = $_REQUEST['nome'];
$email = $_REQUEST['email'];
$login = $_REQUEST['login'];
$senha1 = $_REQUEST['senha1'];
$senha2 = $_REQUEST['senha2'];
$sexo = $_REQUEST['sexo'];
$data_nascimento = $_REQUEST['data_nascimento'];
$estado = $_REQUEST['estado'];
$rua = $_REQUEST['rua'];
$numero = $_REQUEST['numero'];
$bairro = $_REQUEST['bairro'];
$cidade = $_REQUEST['cidade'];
$cep = $_REQUEST['cep'];
$cpf = $_REQUEST['cpf'];
$complemento = $_REQUEST['complemento'];
$pais = $_REQUEST['pais'];
$telefone_fixo = $_REQUEST['telefone_fixo'];
$telefone_celular = $_REQUEST['telefone_celular'];
$pergunta = $_REQUEST['pergunta'];
$resposta = $_REQUEST['resposta'];

date_default_timezone_set('America/Sao_Paulo');
$data_cadastro =  date("d/m/Y");

$erros = FALSE;


$tpl = new Template("../../common/tpl/usuario/valida_cadastro.tpl.html");

if ( $nome == "" ){ 
	$tpl->block("BLOCK_01"); //confere se o campo nome não ficou vazio
	$erros = TRUE;
}
if ( $email == "" ){
	 $tpl->block("BLOCK_02"); //confere se o campo login não ficou vazio
	$erros = TRUE;
}  
else if(!valida_email($email)){
	 $tpl->block("BLOCK_03"); //Verrifica se o e-mail é válido
	$erros = TRUE;
}		
if ( $login == "" ){
	  $tpl->block("BLOCK_04"); //confere se o campo login não ficou vazio
	$erros = TRUE;
}
if ( $senha1 == "" ){
	  $tpl->block("BLOCK_05"); //confere se o campo senha não ficou vazio
	$erros = TRUE;
} 
if ( $senha1 != $senha2 ){
	  $tpl->block("BLOCK_06"); //adiciona o erro caso o usuário digitou 2 senhas diferentes
	$erros = TRUE;
} 
else $senha1 = md5($senha1); // Faz a criptografia da senha com o algoritmo md5

if ( $data_nascimento == "" ){
	  $tpl->block("BLOCK_07"); //confere se o campo login não ficou vazio
	$erros = TRUE;
 } 
else if(!valida_data($data_nascimento)){
	  $tpl->block("BLOCK_08"); //Verrifica se a data é válida
	$erros = TRUE;
}	
if ( $rua == "" ){
	  $tpl->block("BLOCK_09");
	$erros = TRUE;
}  
if ( $numero == "" ){
	  $tpl->block("BLOCK_10");
	$erros = TRUE;
}  
if ( $cidade == "" ){
	  $tpl->block("BLOCK_11");
	$erros = TRUE;
}  
if ( $cep == "" ){
	  $tpl->block("BLOCK_12");
	$erros = TRUE;
}  
if ( $cpf == "" ){
	  $tpl->block("BLOCK_13");
	$erros = TRUE;
}
if ( $resposta == "" ){
	  $tpl->block("BLOCK_15");
	$erros = TRUE;
}

//============================================================================================================================
if (!$erros){//Caso não exista erros
	
	$sql = "SELECT cd_usuario FROM usuario WHERE login = '$login';";
	$minhaConexao = new Conexao(); //Crio uma conexão
	$result = $minhaConexao->envia_sql($sql);
	$row = pg_fetch_array($result);
	
	if($row != FALSE){
		 $tpl->block("BLOCK_14");//O login já existe
		 $tpl->LOGIN = $login;
	}
	
	else{
		$endereco = new Endereco(NULL, $rua, $numero, $complemento, $bairro, $cidade, $cep, $pais, $telefone_celular, $telefone_fixo, $estado);
		$endereco->insert();
	
		$usuario = new Usuario(NULL, $nome, $login, $email, $senha1, $sexo, $cpf, $data_nascimento , NULL, $endereco, NULL);
		$usuario->insert(); 
		$u = $usuario->getId();
		$resposta = md5($resposta);
		
		$sql = "INSERT INTO respostapergunta VALUES (nextval('opcoesperguntas_cd_pergunta_seq'::regclass), '$u', '$pergunta', '$resposta');";
		$minhaConexao->envia_sql($sql);

		
		
		$tpl->block("BLOCK_OK");//Cadastro efetuado com sucesso
		$tpl->NOME = $nome;
	}
		
}
//============================================================================================================================

$tpl->show(); 
  

	
?>
