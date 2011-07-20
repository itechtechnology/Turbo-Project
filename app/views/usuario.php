<?php

include_once '../../conf/lock.php';

session_start(); //Inicio a sessALo			
if (isset($_SESSION["cadastro_usuario"])) {// Verifico se a sessão existe
    $dados = unserialize($_SESSION["cadastro_usuario"]);

    $status = $dados["status"]; //Status atual do cadastro
    $login = $dados["login"];
    $email = $dados["email"];
    $senha = $dados["senha"];
    $nome = $dados["nome"];
    $cpf = $dados["cpf"];
    $sexo = $dados["sexo"];
    $data_nascimento = $dados["data_nascimento"];
    $telefone_fixo = $dados["telefone_fixo"];
    $telefone_celular = $dados["telefone_celular"];
    $rua = $dados["rua"];
    $numero = $dados["numero"];
    $complemento = $dados["complemento"];
    $bairro = $dados["bairro"];
    $cidade = $dados["cidade"];
    $cep = $dados["cep"];
    $estado = $dados["estado"];
    $pais = $dados["pais"];
    $erros = $dados["erros"];
} else {
    echo "Erro ao iniciar a sessão!!!";
    exit;
}




$lib = new Lib();





$acao = $_GET['acao'];



$erros = NULL;

switch ($acao) {

    case "add1":

        $email = $_REQUEST['email'];
        $login = $_REQUEST['login'];
        $senha1 = $_REQUEST['senha1'];
        $senha2 = $_REQUEST['senha2'];


        if ($login == '') {
            $erros .= "ERRO! - Você não preencheu o campo login <br>";
        }
        if ($email == '') {
            $erros .= "ERRO! - Você não preencheu o campo E-mail <br>";
        } else if (!($lib->validaEmail($email))) {
            $erros .= "ERRO! - Seu E-mail é inválido, por favor, digite um E-mail válido <br>";
        }
        if ($senha1 == "") {
            $erros .= "ERRO! - Você não preencheu o campo senha <br>";
        }
        if ($senha2 == "") {
            $erros .= "ERRO! - Você não confirmou a senha <br>";
        } else if ($senha1 != $senha2) {
            $erros .= "ERRO! - As senhas digitadas não coincidem <br>";
        }
        else
            $senha = md5($senha1); // Faz a criptografia da senha com o algoritmo md5

        if ($erros == NULL)
            $status = 2; //Passo para o próximo passo do cadastro

        break;




    case "add2":

        $nome = $_REQUEST['nome'];
        $cpf = $_REQUEST['cpf'];
        $sexo = $_REQUEST['sexo'];
        $data_nascimento = $_REQUEST['data_nascimento'];
        $telefone_fixo = $_REQUEST['telefone_fixo'];
        $telefone_celular = $_REQUEST['telefone_celular'];


        if ($nome == '') {
            $erros .= "ERRO! - Você não preencheu o campo nome <br>";
        }
        if ($cpf == '') {
            $erros .= "ERRO! - Você não preencheu o campo CPF <br>";
        }
        if ($sexo == '') {
            $erros .= "ERRO! - Você não informou qual o seu sexo <br>";
        }
        if ($data_nascimento == '') {
            $erros .= "ERRO! - Você não informou qual a sua dara de nascimento <br>";
        } else if (!($lib->valida_data($data_nascimento))) {
            $erros .= "ERRO! - Sua data de nascimento é inválida, por favor, digite uma data válida <br>";
        }

        if ($erros == NULL)
            $status = 3; //Passo para o próximo passo do cadastro
        break;

    case "add3":

        $rua = $_REQUEST['rua'];
        $numero = $_REQUEST['numero'];
        $complemento = $_REQUEST['complemento'];
        $bairro = $_REQUEST['bairro'];
        $cidade = $_REQUEST['cidade'];
        $cep = $_REQUEST['cep'];
        $estado = $_REQUEST['estado'];
        $pais = $_REQUEST['pais'];


        if ($rua == '') {
            $erros .= "ERRO! - Você não preencheu o campo endereço <br>";
        }
        if ($numero == '') {
            $erros .= "ERRO! - Você não preencheu o campo número <br>";
        }
        if ($bairro == '') {
            $erros .= "ERRO! - Você não preencheu o campo bairro <br>";
        }
        if ($cidade == '') {
            $erros .= "ERRO! - Você não preencheu o campo cidade <br>";
        }
        if ($cep == '') {
            $erros .= "ERRO! - Você não preencheu o campo CEP <br>";
        }
        if ($estado == '') {
            $erros .= "ERRO! - Você não preencheu o campo estado <br>";
        }
        if ($pais == '') {
            $erros .= "ERRO! - Você não preencheu o campo país <br>";
        }


        if ($erros == NULL)
            $status = 4; //Passo para o próximo passo do cadastro
        break;


    case "add4":

        $pqegunta = $_REQUEST['pergunta'];
        $resposta = $_REQUEST['resposta'];
        $complemento = $_REQUEST['habilidade'];



        if ($resposta == '') {
            $erros .= "ERRO! - Você não respondeu a pergunta secreta <br>";
        }


        if ($erros == NULL)
            $status = 5; //Validação final
        break;


    case "valida1":
        $status = 1;
        break;
}









$dados["status"] = $status;
$dados["login"] = $login;
$dados["email"] = $email;
$dados["senha"] = $senha;
$dados["nome"] = $nome;
$dados["cpf"] = $cpf;
$dados["sexo"] = $sexo;
$dados["data_nascimento"] = $data_nascimento;
$dados["telefone_fixo"] = $telefone_fixo;
$dados["telefone_celular"] = $telefone_celular;
$dados["rua"] = $rua;
$dados["numero"] = $numero;
$dados["complemento"] = $complemento;
$dados["bairro"] = $bairro;
$dados["cidade"] = $cidade;
$dados["cep"] = $cep;
$dados["estado"] = $estado;
$dados["pais"] = $pais;
$dados["erros"] = $erros;

$_SESSION["cadastro_usuario"] = serialize($dados);

Header("Location: http://www.itech10.com/app/views/usuarioAdd.php");
?>