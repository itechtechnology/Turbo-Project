<?php
//Só um teste
include_once 'conexao.class.php'; 	
include 'Endereco.class.php';
include 'Habilidade.class.php';
include 'Usuario.class.php';


$endereco = new Endereco(NULL, "Rua a", "12", "não tem", "Centro", "Santos", "99999000", "Brasil", "(75) 0000 0000", "(75) 1111 1111", "São Paulo");

$endereco->insert();
//echo $endereco->getId();

$usuario = new Usuario(NULL, "Marcos Rosa", "marcooosss", "marcooosss@hotmail.com", md5("123456"), 'M', "03329007566", "06/09/1988", NULL, "(75) 3634 2070", "(75) 9153 86", $endereco, NULL);

$usuario->insert();


//$sql = "SELECT MAX(cd_endereco) FROM endereco;";
/*
$minhaConexao = new Conexao(); //Crio uma conexão
$result = $minhaConexao->envia_sql($sql);	//Envio a SQL

$sql = "SELECT last_value FROM endereco_cd_endereco_seq;";
$row = pg_fetch_array( $result );
echo $row[0];
*/


/*
$habilidade = new Habilidade(NULL, "Honda", "Faz porra nenhuma");
$habilidade->insert(); 
*/

?>