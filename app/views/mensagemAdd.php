<?php

require '../../conf/lock.php';

$usuario = new UsuariosRecord();

if (!$usuario->verificaLogin()) {
    echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
}

//session_start(); //Inicio a sessão			
if (isset($_SESSION["mensagemAdd"])) {// Verifico se a sessão já foi criada 
    $dados = unserialize($_SESSION["mensagemAdd"]);
    $status = $dados["status"];  //Variável sessão iniciada
    $remetente = $dados["remetente"];
    $destinatario = $dados["destinatario"];
    $titulo = $dados["titulo"];
    $mensagem = $dados["mensagem"];
    $erros = $dados["erros"];

    /*
      echo $titulo;
      echo "---";
      echo $destinatario;
      echo "---";
      echo $erros;
      exit;

     */
} else {
    $status = $dados["status"] = 1;  //Variável sessão iniciada
    $remetente = $dados["remetente"] = NULL;
    $destinatario = $dados["destinatario"] = NULL;
    $titulo = $dados["titulo"] = NULL;
    $mensagem = $dados["mensagem"] = NULL;
    $erros = $dados["erros"] = NULL;
    $_SESSION["mensagemAdd"] = serialize($dados);
}



$tpl = new sistTemplate(APPTPLDIR . '/msg.tpl.html');
$tpl->addFile('TOPO', APPTPLDIR . '/topo.tpl.html');
$tpl->addFile('MENULATERAL', APPTPLDIR . '/menuLateral.tpl.html');
$tpl->addFile('RODAPE', APPTPLDIR . '/rodape.tpl.html');
$tpl->IMAGEDIR = APPIMAGEDIR;
$tpl->JSDIR = APPJSDIR;
$tpl->CSSDIR = APPCSSDIR;

switch ($status) {

    case 1:

        $tpl->TITULO_1 = "Mensagem";
        $tpl->TITULO_2 = "Enviar mensagem";
        $tpl->DESTINATARIO = $destinatario;
        $tpl->TITULO_M = $titulo;
        $tpl->MENSAGEM = $mensagem;
        $tpl->ERROS = $erros;
        $tpl->block("BLOCK_ADD");

        break;

    case 2:


        $tpl->TITULO_1 = "Mensagem";
        $tpl->TITULO_2 = "Enviar mensagem";
        $tpl->ERROS = "Sua mensagem para $destinatario foi enviada com sucesso!";
        $tpl->block("BLOCK_ADD");

        $status = $dados["status"] = 1;  //Variável sessão iniciada
        $remetente = $dados["remetente"] = NULL;
        $destinatario = $dados["destinatario"] = NULL;
        $titulo = $dados["titulo"] = NULL;
        $mensagem = $dados["mensagem"] = NULL;
        $erros = $dados["erros"] = NULL;
        $_SESSION["mensagemAdd"] = serialize($dados);


        break;
}

$tpl->show();
?>