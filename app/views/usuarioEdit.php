<?php

    require '../../conf/lock.php';

	
	$usuario = new UsuariosRecord();
	$habilidade = new HabilidadeRecord();
	$endereco_ = new EnderecosRecord();
	
	if (!$usuario->verificaLogin()) {
    	echo "<script type='text/javascript'>alert('Voce precisa estar logado');
        location.href='../../web'</script>";
	}	
	

    //$status = new StatusProjeto();

	//$lib = new Lib();
	
	
		
	if (isset($_SESSION["edita_usuario"])){// Verifico se a sessão já foi criada 
		$dados = unserialize($_SESSION["edita_usuario"]);
		$status = $dados["status"]; //Status atual do cadastro
		$email = $dados["email"];
		$senha = $dados["senha"];
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
		//$pergunta = $dados["pergunta"];
		//$resposta = $dados["resposta"];
		$erros = $dados["erros"]; 	
	}
	else{
		
		$cd_usuario = $usuario->verificaLogin();
		$user = $usuario->retornaDados($cd_usuario);
		
		$endereco = $endereco_->retornaDados($user['FK_CD_ENDERECO'][1]);
		
		
		$status = $dados["status"] = 1;  //Variável sessão iniciada
 		$email = $dados["email"] = $user['EMAIL'][1];
		$senha = $dados["senha"] = $user['SENHA'][1];
		$dados["cd_endereco"] = $user['FK_CD_ENDERECO'][1];
		$dados["cd_usuario"] = $user['CD_USUARIO'][1];
		$telefone_fixo = $dados["telefone_fixo"] = $endereco['TEL_FIXO'][1];
		$telefone_celular = $dados["telefone_celular"] = $endereco['TEL_CELULAR'][1];
		$rua = $dados["rua"]  = $endereco['RUA'][1];
		$numero = $dados["numero"] = $endereco['NUMERO'][1];
		$complemento = $dados["complemento"] = $endereco['COMPLEMENTO'][1];
		$bairro = $dados["bairro"] = $endereco['BAIRRO'][1];
		$cidade = $dados["cidade"] = $endereco['CIDADE'][1];
		$cep = $dados["cep"] = $endereco['CEP'][1];
		$estado = $dados["estado"] = $endereco['ESTADO'][1];
		$pais = $dados["pais"] = $endereco['PAIS'][1];
		//$pergunta = $dados["pergunta"]= NULL;
		//$resposta = $dados["resposta"]= NULL;
		$erros = $dados["erros"] = NULL; 		
 		$_SESSION["edita_usuario"] = serialize($dados);
	}

	
	
	$tpl = new sistTemplate(APPTPLDIR.'/usuarioEdit.tpl.html');

    $tpl->addFile('TOPO', APPTPLDIR.'/topo.tpl.html');

    $tpl->addFile('MENULATERAL', APPTPLDIR.'/menuLateral.tpl.html');

    $tpl->addFile('RODAPE', APPTPLDIR.'/rodape.tpl.html');
	
	$tpl->IMAGEDIR = APPIMAGEDIR;
	$tpl->JSDIR = APPJSDIR;
	$tpl->CSSDIR = APPCSSDIR;
	
	
	
	switch ($status){
		
		case 1:
			$tpl->TITULO_1 = "Editar dados";
			$tpl->TITULO_2 = "Editar dados do usuário";
			
			

			$tpl->EMAIL = $email;
			

			$tpl->TELEFONE_FIXO =  $telefone_fixo;
			$tpl->TELEFONE_CELULAR = $telefone_celular;
			
			$tpl->RUA = $rua;
			$tpl->NUMERO = $numero;
			$tpl->COMPLEMENTO = $complemento;
			$tpl->BAIRRO = $bairro;
			$tpl->CIDADE = $cidade;
			$tpl->CEP = $cep;
			$tpl->ESTADO = $estado;
			$tpl->PAIS = $pais;
			
			//$tpl->PERGUNTA = $usuario->getPergunta($pergunta);
			//$tpl->RESPOSTA = $resposta;
			//$tpl->HABILIDADE = $habilidade->getHabilidade($habilidade1);

			$tpl->block("BLOCK_DADOS");
		
		break;
		
		case 2:
			$tpl->TITULO_1 = "Editar dados";
			$tpl->TITULO_2 = "Alterar e-mail";
			$tpl->EMAIL = $email;
		
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_EMAIL");
		
		break;
		
		case 3:
			$tpl->TITULO_1 = "Editar dados";
			$tpl->TITULO_2 = "Alterar senha";
	
			
		
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_SENHA");
		
		break;
		
		case 4:
		
			
			
			$tpl->TITULO_1 = "Editar dados";
			$tpl->TITULO_2 = "Alterar telefones";
			$tpl->TELEFONE_FIXO =  $telefone_fixo;
			$tpl->TELEFONE_CELULAR = $telefone_celular;
	
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_TELEFONE");
		
		break;
		
		case 5:
			
			$tpl->TITULO_1 = "Editar dados";
			$tpl->TITULO_2 = "Alterar endereco";
			
					
			$tpl->RUA = $rua;
			$tpl->NUMERO = $numero;
			$tpl->COMPLEMENTO = $complemento;
			$tpl->BAIRRO = $bairro;
			$tpl->CIDADE = $cidade;
			$tpl->CEP = $cep;
			$tpl->ESTADO = $estado;
			$tpl->PAIS = $pais;
			
		

			$tpl->block("BLOCK_ENDERECO");
		
		break;
		
		case 6:
			
			$tpl->TITULO_1 = "Cadastro Usuario";
			$tpl->TITULO_2 = "Parabéns $nome, seu cadastro foi realizado com sucesso!";
			
		
		
			

			$tpl->block("BLOCK_MSG");
		
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