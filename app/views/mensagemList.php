<?php

    require '../../conf/lock.php';

	
	$usuario = new UsuariosRecord();
	$mensagem = new MensagemsRecord();
	$lib = new Lib();
	
	if (!$usuario->verificaLogin()) {
    	echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
	}
	
	
	$tpl = new sistTemplate(APPTPLDIR.'/msg.tpl.html');

    $tpl->addFile('TOPO',APPTPLDIR.'/topo.tpl.html');


	$tpl->addFile('MENULATERAL', APPTPLDIR.'/menuLateral.tpl.html');

    $tpl->addFile('RODAPE',APPTPLDIR.'/rodape.tpl.html');
	
	$tpl->IMAGEDIR = APPIMAGEDIR;
	$tpl->JSDIR = APPJSDIR;
	$tpl->CSSDIR = APPCSSDIR;
	
	//$usuario = new UsuariosRecord();
	///$habilidade = new HabilidadeRecord();
	
	
    //$status = new StatusProjeto();

	
	
	//session_start(); //Inicio a sessão			
	if (isset($_SESSION["mensagemList"])){// Verifico se a sessão já foi criada 
		$dados = unserialize($_SESSION["mensagemList"]);
 		$texto = $dados["texto"];
		$remetente = $dados["remetente"];
		$titulo = $dados["titulo"];
		
		$tpl->TITULO_MSG = "Mensagem enviada por $remetente - Título: $titulo";
		
		$tpl->MSG = $texto;
		
	}
	
	else{
		$texto = $dados["texto"] = NULL;
 		$remetente = $dados["remetente"] = NULL;
		$titulo = $dados["titulo"] = NULL;
 		$_SESSION["mensagemList"] = serialize($dados);
		
		}
	
	
	
	
	
	
	$tpl->TITULO_1 = "Mensagens";
	$tpl->TITULO_2 = "Suas mensagens";	
	
	
	
	
	$destinatario = $usuario->verificaLogin();
	
	$result = $mensagem->listaMensagens($destinatario);
	
	
			

	$i = 1;
	$n_lida = 0;

	while (@ $result['CD_MENSAGEM'][$i]){
		
		
		$tpl->DATA = ($lib->converteData($result['HORA'][$i]));
		$tpl->ID_MSG = $result['CD_MENSAGEM'][$i];
		$tpl->TITULO_3 = $result['TITULO'][$i];
		
		$remetente = $result['REMENTENTE'][$i];
				
		$tpl->REMETENTE = $usuario->getLogin($remetente);
		
		
		if($result['STATUS'][$i] == 1) $tpl->STATUS = "msg_on";
		else{
			$tpl->STATUS = "msg_off";
			$n_lida++; //Mensagens não lidas
		}
		$i++; //Total de mensagens
		
		$tpl->block("BLOCK_LIST");
		
		
	}
	
	
	$tpl->TOTAL = $i - 1;
	$tpl->N_LIDAS = $n_lida;
	

	$tpl->block("BLOCK_LISTA");
	
    
	
 	$_SESSION["mensagemList"] = NULL;	
	

    

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