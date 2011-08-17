<?php

    require '../../conf/lock.php';
	
	$usuario = new UsuariosRecord();
	
	if (!$usuario->verificaLogin()) {
    	echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
	}

	
	//$usuario = new UsuariosRecord();
	///$habilidade = new HabilidadeRecord();
	
	
    //$status = new StatusProjeto();

	//$lib = new Lib();
	
	
	//session_start(); //Inicio a sessão			
	if (isset($_SESSION["mensagemAdd"])){// Verifico se a sessão já foi criada 
		$dados = unserialize($_SESSION["mensagemAdd"]);
		$status = $dados["status"];  //Variável sessão iniciada
 		$remetente = $dados["remetente"];
		$destinatario = $dados["destinatario"];
		$titulo = $dados["titulo"];
		$mensagem = $dados["mensagem"];
		$erros= $dados["erros"];
		
		/*
		echo $titulo;
		echo "---";
		echo $destinatario;
		echo "---";
		echo $erros;
		exit;
		
		*/
	}
	
	else{
		$status = $dados["status"] = 1;  //Variável sessão iniciada
 		$remetente = $dados["remetente"] = NULL;
		$destinatario = $dados["destinatario"] = NULL;
		$titulo = $dados["titulo"] = NULL;
		$mensagem = $dados["mensagem"] = NULL;
		$erros = $dados["erros"] = NULL;		
 		$_SESSION["mensagemAdd"] = serialize($dados);
	}

	
	
	$tpl = new sistTemplate(APPTPLDIR.'/msg.tpl.html');

    $tpl->addFile('TOPO', APPTPLDIR.'/topo.tpl.html');

	$tpl->addFile('MENULATERAL', APPTPLDIR.'/menuLateral.tpl.html');

    $tpl->addFile('RODAPE', APPTPLDIR.'/rodape.tpl.html');
	
	$tpl->IMAGEDIR = APPIMAGEDIR;
	$tpl->JSDIR = APPJSDIR;
	$tpl->CSSDIR = APPCSSDIR;
	
	
	
	
	
	switch ($status){
		
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
	
    
	
	

    

    //$tpl->WEBROOT = APPWEBROOT;

    //$tpl->SITETITLE = SITETITLE;

    //$tpl->FAVICON = FAVICON;

    //$tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;

    //$tpl->MEMORYUSAGE = number_format(intval(memory_get_usage()/1000), 0, ',', '.');

    //$tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage()/1000),0,',','.');

	//$tpl->CONTROLLER = '../controllers/usuario.php?acao=add1'; 

        //$projeto = new ProjetosRecord();



        /*

         * PREENCHE COMBO GERENTE PROJETO

         * estou esperando o metodo de marcos rosa do modulo usuario

         

        $sql = "SELECT cd_usuario, nome FROM usuario ORDER BY nome";

	$gerentes = $projeto->executarPesquisa($sql);



        $totalGerentes = count($gerentes['NOME']);



	for($x = 1;$x <= $totalGerentes;$x++)

	{

		$tpl->CODGER = $gerentes['CD_USUARIO'][$x];

		$tpl->GERENTE = $gerentes['NOME'][$x];

		$tpl->GERENTEATUAL = '';

		$tpl->block("BLOCK_GERENTE_PROJETO");

	}

        */

        /*

         * PREENCHE COMBO STATUS

         */

        //$sql = "SELECT cd_status, nome_status FROM status ORDER BY nome_status";

	//$status = $projeto->executarPesquisa($sql);

        //$status = $status->listarStatus();

        //$totalStatus = count($status['NOME_STATUS']);


	/*
	for($x = 1;$x <= $totalStatus;$x++)

	{

		$tpl->CODSTA = $status['CD_STATUS'][$x];

		$tpl->STATUS = $status['NOME_STATUS'][$x];

		$tpl->STATUSATUAL = '';

		$tpl->block("BLOCK_STATUS");

	}
	*/



		

	/*

         * FORMA DE LISTAR EM UM COMBOBOX

         * lembre-se subistituir o nome objeto pelo nome da entidade





        $totalObjeto = count($Objetos['NOME']);

				

	for($x = 1;$x <= $totalObjeto;$x++)

	{

		$tpl->CODOBJ = $objetos['COD'][$x];

		$tpl->OBJETO = $objetos['NOME'][$x];

		$tpl->OBJETOATUAL = '';

		$tpl->block("BLOCK_OBJETOS");

	}





         */

	



    //$tpl->DICA = 'SEM DICA';



    //$tpl->TIME = number_format((microtime() - $time),3,',','.');

    $tpl->show();

?>