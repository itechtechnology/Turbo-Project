<?php
    $time = microtime();

    require '../../conf/lock.php';
    

    $projeto = new ProjetosRecord();
    /*
     * @TODO preciso que marcos implemente o metodo listarColaboradoresAtivos
     * para que eu possa listar os usuarios a serem selecionados
     */

	$lib = new Lib();
	
	$tpl = new sistTemplate(APPTPLDIR.'/projetoCrono.tpl.html');
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
	$tpl->CONTROLLER = '../controllers/projeto.php?acao=editCrono';
        $projeto1 = $projeto->getProjetoCompletoByID($lib->antiInjection($_REQUEST['cd_projeto']));
                
        $tpl->CD_PROJETO = $projeto1['CD_PROJETO'][1];
        $tpl->NOME_PROJETO = $projeto1['NOME_PROJETO'][1];
        $tpl->DT_INICIO_PROJ = $lib->converteData($projeto1['DT_INICIO_PROJ'][1]);
        $tpl->DT_TERMINO_PROJ = $lib->converteData($projeto1['DT_TERMINO_PROJ'][1]);
        $tpl->DT_PREVISAO_TERMINO_PROJ = $lib->converteData($projeto1['DT_PREVISAO_TERMINO_PROJ'][1]);
        $tpl->NOME_STATUS = $projeto1['NOME_STATUS'][1];
        

    $tpl->DICA = 'SEM DICA';

    $tpl->TIME = number_format((microtime() - $time),3,',','.');
    $tpl->show();
?>