<?php
    $time = microtime();

    require '../../conf/lock.php';

    $projeto = new ProjetosRecord();
    $status = new StatusProjeto();
    /*
     * @TODO preciso que marcos implemente o metodo listarColaboradoresAtivos
     * para que eu possa listar os usuarios a serem selecionados
     */

	$lib = new Lib();
	
	$tpl = new sistTemplate(APPTPLDIR.'/projeto.tpl.html');
    $tpl->addFile('TOPO', APPTPLDIR.'/topo.tpl.html');
    $tpl->addFile('MENULATERAL', APPTPLDIR.'/menuLateral.tpl.html');
    $tpl->addFile('RODAPE', APPTPLDIR.'/rodape.tpl.html');
    $tpl->IMAGEDIR = APPIMAGEDIR;
    $tpl->CSSDIR = APPCSSDIR;
    $tpl->JSDIR = APPJSDIR;
    $tpl->WEBROOT = APPWEBROOT;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
    $tpl->MEMORYUSAGE = number_format(intval(memory_get_usage()/1000), 0, ',', '.');
    $tpl->MEMORYPICK = number_format(intval(memory_get_peak_usage()/1000),0,',','.');
	$tpl->CONTROLLER = '../controllers/projeto.php?acao=add';
        $projeto = new ProjetosRecord();

       	/*
         * mostra mensagens de erro
         */
        if (isset($_SESSION['str_erro']))
        {
            $tpl->ERROS = $_SESSION['str_erro'];
            $tpl->block("BLOCK_SCRIPT");
        }

       //inicializo sessão para recuperar valores
        if (isset($_SESSION['nome_projeto']))
            $tpl->NOME_PROJETO = $_SESSION['nome_projeto'];
        if (isset($_SESSION['ds_projeto']))
            $tpl->DS_PROJETO = $_SESSION['ds_projeto'];
        if (isset($_SESSION['dt_previsao_termino_proj']))
            $tpl->DT_PREVISAO_TERMINO_PROJ = $_SESSION['dt_previsao_termino_proj'];

        //aki limpo as variaveis de sessão
        @session_unregister('nome_projeto');
        @session_unregister('ds_projeto');
        @session_unregister('dt_previsao_termino_proj');
        @session_unregister('str_erro');

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
	
	$tpl->DICA = "123456";
    $tpl->TIME = number_format((microtime() - $time),3,',','.');
    $tpl->show();
?>