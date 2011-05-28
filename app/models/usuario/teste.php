<?php
//Só um teste
include_once 'Conexao.class.php'; 	
include 'Endereco.class.php';
include 'Habilidade.class.php';
include 'Usuario.class.php';
include 'Mensagem.class.php';
include 'Sessao.class.php';
include '../../controllers/usuario/converte_data.func.php';



$d = "2011-05-13 15:19:51";
$a = converte_data($d);
echo "$a";


//$sessao = new Sessao();
//$sessao->cria_sessao("marcooosss", md5("123456"));


//if ($sessao->verifica_sessao())echo "foi";


/*
$endereco = new Endereco(NULL, "Rua a", "12", "não tem", "Centro", "Santos", "99999000", "Brasil", "(75) 0000 0000", "(75) 1111 1111", "São Paulo");

$endereco->insert();
//echo $endereco->getId();
*/

/*
$usuario1 = new Usuario(10, "Marcos Rosa", "marcooosss", "marcooosss@hotmail.com", md5("123456"), 'M', "03329007566", "06/09/1988", NULL, "(75) 3634 2070", "(75) 9153 86", NULL, NULL);

$usuario2 = new Usuario(14, "Marcos Rosa", "marcooosss", "marcooosss@hotmail.com", md5("123456"), 'M', "03329007566", "06/09/1988", NULL, "(75) 3634 2070", "(75) 9153 86", NULL, NULL);

*/

//$mensagem = new Mensagem(NULL, 7, 14, "Hoje teremos uma reunião", NULL, 1, "Reunião hoje");
//$mensagem->insert();




//$usuario->insert();


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