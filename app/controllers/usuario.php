<?php

/**
 * Controlador Usuario
 * 
 * @package app
 * @subpackage controllers
 * @author Marcos Rosa
 */

include_once '../../conf/lock.php';

$lib = new Lib();

$usuario = new UsuariosRecord();


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
    $pergunta = $dados["pergunta"];
    $resposta = $dados["resposta"];
    $habilidade1 = $dados["habilidade1"];
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
        } else if ($usuario->loginExiste($login)) {
            $erros .= "ERRO! - Esse login já é cadastrado, por favor, escolha um login diferente <br>";
        }
        if ($email == '') {
            $erros .= "ERRO! - Você não preencheu o campo E-mail <br>";
        } else if (!($lib->validaEmail($email))) {
            $erros .= "ERRO! - Seu E-mail é inválido, por favor, digite um E-mail válido <br>";
        } else if ($usuario->emailExiste($email)) {
            $erros .= "ERRO! - Esse email já é cadastrado, por favor, escolha um email diferente <br>";
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
        } else if ($usuario->cpfExiste($cpf)) {
            $erros .= "ERRO! - Esse CPF já é cadastrado, por favor, escolha um CPF diferente <br>";
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

        $pergunta = $_REQUEST['pergunta'];
        $resposta = $_REQUEST['resposta'];
        $habilidade1 = $_REQUEST['habilidade1'];



        if ($resposta == '') {
            $erros .= "ERRO! - Você não respondeu a pergunta secreta <br>";
        }


        if ($erros == NULL)
            $status = 5; //Validação final
        break;




    case "v1": //Volta para etapa 1 do cadastro
        $status = 1;
        break;

    case "v2": //Volta para etapa 2 do cadastro
        $status = 2;
        break;

    case "v3": //Volta para etapa 3 do cadastro
        $status = 3;
        break;

    case "v4": //Volta para etapa 4 do cadastro
        $status = 4;
        break;

    case"valida": //Validar e enviar dados para o banco de dados
        //Fazes a validação completa
        //$endereco['cd_endereco'] = '';
        $endereco['rua'] = $rua;
        $endereco['numero'] = $numero;
        $endereco['complemento'] = $complemento;
        $endereco['bairro'] = $bairro;
        $endereco['cidade'] = $cidade;
        $endereco['cep'] = $cep;
        $endereco['pais'] = $pais;
        $endereco['tel_celular'] = $telefone_celular;
        $endereco['tel_fixo'] = $telefone_fixo;
        $endereco['estado'] = $estado;

        $user['nome'] = $nome;
        $user['login'] = $login;
        $user['senha'] = $senha;
        $user['email'] = $email;
        $user['sexo'] = $sexo;
        $user['cpf'] = $cpf;
        $user['dt_nascimento'] = ($data_nascimento);



        $cd_usuario = $usuario->cadastrarUsuario($endereco, $user);



        $resp['fk_cd_usuario'] = $cd_usuario;
        $resp['fk_cd_perguntas'] = $pergunta;
        $resp['resposta'] = $resposta;

        $resposta_ = new RespostaPerguntasRecord();
        $resposta_->cadastrarResposta($resp);


        $habi['fk_cd_usuario'] = $cd_usuario;
        $habi['fk_cd_habilidade'] = $habilidade1;

        $habilidade_ = new UsuarioHabilidadesRecord();
        $habilidade_->cadastrarHabilidade($habi);


        $status = 6; //Status de conclusão



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
$dados["pergunta"] = $pergunta;
$dados["resposta"] = $resposta;
$dados["habilidade1"] = $habilidade1;
$dados["erros"] = $erros;

$_SESSION["cadastro_usuario"] = serialize($dados);

header("Location: ../views/usuarioAdd.php");
?>