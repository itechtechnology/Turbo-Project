<?php

	include_once '../../conf/lock.php';
	
	$lib = new Lib();
	$usuario = new UsuariosRecord();
	$novaMensagem = new MensagemsRecord();
	
	
	
	$acao = $_GET['acao'];
	
	

	$erros = NULL; 

	switch($acao){

		case "add":
		
			//session_start(); //Inicio a sessALo			
			if (isset($_SESSION["mensagemAdd"])){// Verifico se a sessão já foi criada 
				$dados = unserialize($_SESSION["mensagemAdd"]);
				$status = $dados["status"];  //Variável sessão iniciada
 				$remetente = $dados["remetente"];
				$destinatario = $dados["destinatario"];
				$titulo = $dados["titulo"];
				$mensagem = $dados["mensagem"];
				$erros= $dados["erros"];	
			}
			else{
		 		echo "Erro ao iniciar a sessão!!!";
		 		exit;
			}					
			$destinatario = $_REQUEST['destinatario'];
			$titulo = $_REQUEST['titulo'];
			$mensagem = $_REQUEST['msg'];
			
		
			
			
			
			$erros = NULL;
			
			if($destinatario == ''){
				$erros .= "ERRO! - Você não preencheu o campo destinatário <br>";
			}
			else if(!(@ $usuario->getId($destinatario))){				
				$erros .= "ERRO! - Destinatário inexistente <br>";
			}
			if($titulo == ''){
				$erros .= "ERRO! - Você não preencheu o campo título <br>";
			}
			if($mensagem == ''){
				$erros .= "ERRO! - Você não digitou o corpo da mensagem <br>";
			}
			
			
			
			
			if ($erros == NULL){
				 @ $dados_['rementente'] = $usuario->verificaLogin();
				 $dados_['destinatario'] = $usuario->getId($destinatario);
				 $dados_['texto'] = $mensagem;

				 date_default_timezone_set('America/Sao_Paulo');
				 $data_hora =  date("Y-m-d H:i:s");
				 $dados_['hora'] = $data_hora;
				 
				 $dados_['status'] = 0;				 
				 $dados_['titulo'] = $titulo;
				 
				
				 @ $novaMensagem->salvar($dados_);
				 
				 $status = 2; //Mensagem enviada com sucesso
			}
			
			$dados["status"] = $status;  
 			$dados["remetente"] = $remetente;  
 			$dados["destinatario"] = $destinatario;
			$dados["titulo"] = $titulo;
			$dados["mensagem"] = $mensagem;
			$dados["erros"] = $erros;
	
 			$_SESSION["mensagemAdd"] = serialize($dados);
	

			
			Header("Location: ../views/mensagemAdd.php");
		
		break;
		
	case "del": //Deleta mensagem

		$cd_mensagem = $_REQUEST['MSG'];
		
				
		@ $novaMensagem->excluirMensagem($cd_mensagem);
		
					
		Header("Location: ../views/mensagemList.php");
		break;
	
	case "ler": //Deleta mensagem
		
		$cd_mensagem_ = $_REQUEST['MSG'];
		$result = $novaMensagem->getMensagem($cd_mensagem_);
		
		$texto = $result['TEXTO'][1];
		$titulo = $result['TITULO'][1];
		$login = $result['REMENTENTE'][1];
		$remetente = $usuario->getLogin($login);
		
		if(($result['STATUS'][1])==0){
			$status_msg['STATUS'] = 1;
			$novaMensagem->atualizarMensagem($status_msg, $cd_mensagem_);
		}
		
		
		//session_start(); //Inicio a sessão
		
		$dados["texto"] = $texto;
		$dados["titulo"] = $titulo;
		$dados["remetente"] = $remetente;
	
 		$_SESSION["mensagemList"] = serialize($dados);		
		

	
					
		Header("Location: ../views/mensagemList.php");
		break;
	

	}
	

	
	
?>