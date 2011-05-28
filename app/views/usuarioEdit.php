<?php
    $time = microtime();

    require '../../conf/lock.php';

    $departamento = new sistDepartamentosRecord();
        $perfil = new sistPerfisRecord();
        $status = new sistStatusUsuarioRecord();
        $usuario = new sistUsuariosRecord();
        $lib = new Lib();
        
        $codUsuario = $_GET['codUsuario'];
        
        $dadosUsuario = $usuario->dadosUsuario($codUsuario); 
        
        //SELECIONANDO OS DEPARTAMENTOS
        $departamentos = $departamento->listarDepartamentos();
        
        //SELECIONANDO OS PERFIS
        $perfis = $perfil->listarPerfis();
        
        //SELECIONANDO OS STATUS DOS USUÁRIOS
        $listaStatus = $status->listarStatusUsuario();
        
        $tpl = new sistTemplate(APPTPLDIR.'/usuario.tpl.html');
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
        $tpl->CONTROLLER = '../controllers/usuario.php?acao=edit';
        $tpl->NOME = $lib->formatarNome($dadosUsuario['NOME']['0']);
        $tpl->LOGIN = $dadosUsuario['LOGIN']['0'];
        $tpl->SENHA = '';
        $tpl->EMAIL = $dadosUsuario['EMAIL']['0'];
        $tpl->RAMAL = $dadosUsuario['RAMAL']['0'];
        $tpl->CODUSUARIO = $codUsuario;
        $tpl->PERFILANTIGO = $dadosUsuario['PERFIL']['0'];
        $tpl->STATUSANTIGO = $dadosUsuario['SITUACAO']['0'];
        
        if($dadosUsuario['DURACAO']['0'] == '1')
        {
                $tpl->SENHAEXPIRA = 'checked';
        } else
        {
                $tpl->SENHAEXPIRA = '';
        }
        
        if($dadosUsuario['ADMINISTRADOR']['0'] == '1')
        {
                $tpl->ADMINISTRADOR = 'checked';
        } else
        {
                $tpl->ADMINISTRADOR = '';
        }
        
        
        $totalDepartamento = count($departamentos['NOME']);
                                
        for($x = 1;$x <= $totalDepartamento;$x++)
        {
                $tpl->CODDEPT = $departamentos['COD'][$x];
                $tpl->DEPARTAMENTO = $lib->formatarNome($departamentos['NOME'][$x]);
                
                if($dadosUsuario['DEPARTAMENTO']['0'] == $departamentos['COD'][$x])
                {
                        $tpl->DEPARTAMENTOATUAL = 'selected';
                } else
                {
                        $tpl->DEPARTAMENTOATUAL = '';
                }
                
                $tpl->block("BLOCK_DEPARTAMENTOS");
        }
        
        $totalPerfis = count($perfis['NOME']);
                                
        for($x = 1;$x <= $totalPerfis;$x++)
        {
                $tpl->CODPERF = $perfis['COD'][$x];
                $tpl->PERFIL = $lib->formatarNome($perfis['NOME'][$x]);
                
                if($dadosUsuario['PERFIL']['0'] == $perfis['COD'][$x])
                {
                        $tpl->PERFILATUAL = 'selected';
                } else
                {
                        $tpl->PERFILATUAL = '';
                }
                
                $tpl->block("BLOCK_PERFIS");
        }
        
        $totalStatus = count($listaStatus['NOME']);
                                
        for($x = 1;$x <= $totalStatus;$x++)
        {
                $tpl->CODSTATUS = $listaStatus['COD'][$x];
                $tpl->STATUS = $lib->formatarNome($listaStatus['NOME'][$x]);
                
                if($dadosUsuario['SITUACAO']['0'] == $listaStatus['COD'][$x])
                {
                        $tpl->STATUSATUAL = 'selected';
                } else
                {
                        $tpl->STATUSATUAL = '';
                }
                
                $tpl->block("BLOCK_STATUS");
        }

    $tpl->DICA = 'Lorem ipsum dolor sit amet, consectetur
        adipiscing elit. Duis sollicitudin ultrices
        erat vitae sodales. Duis pretium mollis
        risus, sed pellentesque diam accumsan
        et. Vivamus sapien lorem, ullamcorper
        n auctor non, lacinia et arcu.
        Maecenas condimentum tincidunt
        massa.';    

    $tpl->TIME = number_format((microtime() - $time),3,',','.');
    $tpl->show();
?>