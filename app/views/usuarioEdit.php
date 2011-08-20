<?php

    require '../../conf/lock.php';

	
	$usuario = new UsuariosRecord();
	$habilidade = new HabilidadeRecord();
	
	

    //$status = new StatusProjeto();

	//$lib = new Lib();
	
	
	session_start(); //Inicio a sessão			
	if (isset($_SESSION["edita_usuario"])){// Verifico se a sessão já foi criada 
		$dados = unserialize($_SESSION["edita_usuario"]);
		$status = $dados["status"]; //Status atual do cadastro
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
		$pergunta = $dados["pergunta"];
		$resposta = $dados["resposta"];
		$erros = $dados["erros"]; 	
	}
	else{
		
		$sql = "select * FROM projeto WHERE cd_projeto=".$_REQUEST['cd_projeto'];
        $projeto1 = $projeto->executarPesquisa($sql);
		
		$status = $dados["status"] = 1;  //Variável sessão iniciada
 		$senha = $dados["senha"] = NULL;
		$telefone_fixo = $dados["telefone_fixo"] = NULL;
		$telefone_celular = $dados["telefone_celular"] = NULL;
		$rua = $dados["rua"] = NULL;
		$numero = $dados["numero"] = NULL;
		$complemento = $dados["complemento"] = "nenhum";
		$bairro = $dados["bairro"] = NULL;
		$cidade = $dados["cidade"] = NULL;
		$cep = $dados["cep"] = NULL;
		$estado = $dados["estado"] = NULL;
		$pais = $dados["pais"] = NULL;
		$pergunta = $dados["pergunta"]= NULL;
		$resposta = $dados["resposta"]= NULL;
		$erros = $dados["erros"] = NULL; 		
 		$_SESSION["edita_usuario"] = serialize($dados);
	}

	
	
	$tpl = new sistTemplate(APPTPLDIR.'/usuarioEdit.tpl.html');

    $tpl->addFile('TOPO', APPTPLDIR.'/topo.tpl.html');

    //tpl->addFile('MENULATERAL', APPTPLDIR.'/menuLateral.tpl.html');

    $tpl->addFile('RODAPE', APPTPLDIR.'/rodape.tpl.html');
	
	$tpl->IMAGEDIR = APPIMAGEDIR;
	$tpl->JSDIR = APPJSDIR;
	$tpl->CSSDIR = APPCSSDIR;
	
	
	
	switch ($status){
		
		case 1:
			$tpl->TITULO_1 = "Edita Dados";
			$tpl->TITULO_2 = "Escolha a opção que deseja editar";
			
			
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
			
			$tpl->PERGUNTA = $usuario->getPergunta($pergunta);
			$tpl->RESPOSTA = $resposta;
			$tpl->HABILIDADE = $habilidade->getHabilidade($habilidade1);

			$tpl->block("BLOCK_VALIDA");
		
		break;
		
		case 2:
			$tpl->TITULO_1 = "Cadastro Usuário - Passo II";
			$tpl->TITULO_2 = "Cadastro de Usuário";
			$tpl->NOME = $nome;
			$tpl->CPF = $cpf;
			$tpl->DATA_NASCIMENTO = $data_nascimento;
			$tpl->TELEFONE_FIXO = $telefone_fixo;
			$tpl->TELEFONE_CELULAR = $telefone_celular;
			if($sexo == 'M') $tpl->SEL_M = "selected";
			else $tpl->SEL_F = "selected";	
		
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_ADD2");
		
		break;
		
		case 3:
			$tpl->TITULO_1 = "Cadastro Usuário - Passo III";
			$tpl->TITULO_2 = "Cadastro de Usuário";
			$tpl->RUA = $rua;
			$tpl->NUMERO = $numero;
			$tpl->COMPLEMENTO = $complemento;
			$tpl->BAIRRO = $bairro;
			$tpl->CIDADE = $cidade;
			$tpl->CEP = $cep;
			$tpl->PAIS = $pais;
			
		
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_ADD3");
		
		break;
		
		case 4:
		
			
			
			$tpl->TITULO_1 = "Cadastro Usuário - Passo IV";
			$tpl->TITULO_2 = "Cadastro de Usuário";
			
			
			$result = $usuario->listaPerguntas();
			
			$i = 1;
			while($result['CD_PERGUNTAS'][$i]){
					
				$tpl->V_REP = $result['CD_PERGUNTAS'][$i]; //id da pergunta
				$tpl->N_REP = $result['PERGUNTA'][$i]; //nome da pergunta
				$tpl->block("BLOCK_REP");
				$i++;					
			}
			
			$result = $habilidade->listaHabilidades();
			
			$i = 1;
			while($result['CD_HABILIDADE'][$i]){
					
				$tpl->V_REP2 = $result['CD_HABILIDADE'][$i]; //id da habilidade 
				$tpl->N_REP2 = $result['NOME'][$i]; //nome da habilidadae
				$tpl->block("BLOCK_REP2");
				$i++;					
			}
			
			
		
			
			$tpl->ERROS = $erros;
			$tpl->block("BLOCK_ADD4");
		
		break;
		
		case 5:
			
			$tpl->TITULO_1 = "Cadastro Usuario";
			$tpl->TITULO_2 = "Cadastro de Usuario - Confirmação";
			
			
			$tpl->LOGIN = $login;
			$tpl->EMAIL = $email;
			
			$tpl->NOME = $nome;
			$tpl->CPF = $cpf;
			$tpl->DATA_NASCIMENTO = $data_nascimento;
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
			
			$tpl->PERGUNTA = $usuario->getPergunta($pergunta);
			$tpl->RESPOSTA = $resposta;
			$tpl->HABILIDADE = $habilidade->getHabilidade($habilidade1);

			$tpl->block("BLOCK_VALIDA");
		
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