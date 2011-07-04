<?php
/*
Nome: Edita dados
Autor: Marcos Rosa
Criado em: 15/05/11
Modificado por: 
Descrição: Edita os dados do usuário
*/
include_once ("../../controllers/usuario/seguranca.php"); 
include_once ("../../models/usuario/Conexao.class.php");
include_once ("../../models/usuario/Usuario.class.php");
include_once ("../../models/usuario/Sessao.class.php");  
require ("../../models/Template.class.php");

	
	$sessao = new Sessao();
	$user = $sessao->verifica_sessao();
	if($user == FALSE){
		 Header("Location: http://www.itech10.com"); //Redireciona para index se não existir nenhuma sessão
		 exit;
	}
	$u = $user->getId(); //Código do usuário
	
	
	$tpl = new Template("../../common/tpl/usuario/edit_habilidades.tpl.html");
	

//================================================== < Tela menu principal> ====================================================	
	if(($_POST["id"])== NULL){//Se receber nenhum indentificador
		
		$tpl->TITULO_1 = "Habilidade"; //Título da página
		$tpl->TITULO_2 = "Escolha a opção"; //Título do bloco
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/habilidades.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Adicionar";
		$tpl->T_BOT = "Adicionar uma nova habilidade";
		$tpl->block("BLOCK_BOT");
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/habilidades.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Listar";
		$tpl->T_BOT = "Listar sua habilidades";
		$tpl->block("BLOCK_BOT");
		
		$tpl->ACTION = "http://itech10.com/app/views/usuario/habilidades.php";
		$tpl->NOME_BOT = "id"; //Nome da variável 
		$tpl->VALUE = "Cadastrar";
		$tpl->T_BOT = "Cadastrar uma nova habilidade no sistema";
		$tpl->block("BLOCK_BOT");
		
		
		$tpl->LINK_1 = "http://itech10.com/app/views/usuario/pg_usuario.php";
		$tpl->BOT_1 = "Voltar";
		$tpl->LINK_2 = NULL;
		$tpl->BOT_2 = NULL;
		
		$tpl->block("BLOCK_ID1");
	}
	

	else{
		switch ($_POST["id"]){
			
//================================================= < Tela add habilidade > ======================================================
			case "Adicionar":
				
	
				
				$tpl->TITULO_1 = "Habilidades"; //Título da página
				$tpl->TITULO_2 = "Adicionar habilidade"; //Título do bloco
				
				$tpl->ACTION = "http://itech10.com/app/views/usuario/habilidades.php";
				$tpl->NOME_BOT = "id"; //Nome da variável 
				$tpl->VALUE = "Adicionar habilidade";
				$tpl->TXT = "Adicionar uma nova habilidade ao seu perfil";
				$tpl->NOME_L = "Nova habilidade";
				
				$sql = "SELECT cd_habilidade, nome FROM habilidade ORDER BY nome;"; //Seleciono todas as habilidades cadastradas
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				
				while($row = pg_fetch_array($result)){
					$tpl->V_REP = $row[0]; //id da habilidade 
					$tpl->N_REP = $row[1]; //nome da habilidadae
					$tpl->block("BLOCK_REP");					
				}
							
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/habilidades.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_HABI");
				
			break;
			
//==================================================== < Validar habilidade> ======================================================			
			case "Adicionar habilidade":
				
				$id_habilidade  = $_POST["habilidade"];
				
				if($id_habilidade == ''){//campo vazio
					
					$tpl->TITULO_1 = "Erro"; //Título da página
					$tpl->TITULO_2 = "Campo vazio"; //Título do bloco
					$tpl->{TXT} = "Você não informou qual é a habilidade";
					
					$tpl->LINK_1 = "http://itech10.com/app/views/usuario/habilidades.php";
					$tpl->BOT_1 = "Voltar";
					$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
					$tpl->BOT_2 = "Página do usuário";
				
					$tpl->block("BLOCK_OP");					
				}
				
				else{//Vejo se a habilidade já foi cadastrada anteriomente
					
					$sql = "SELECT * FROM usuariohabilidade WHERE fk_cd_usuario = '$u' AND fk_cd_habilidade = '$id_habilidade';";
					$minhaConexao = new Conexao();
					$result = $minhaConexao->envia_sql($sql);
					
					if(pg_fetch_array($result)){
						
						$tpl->TITULO_1 = "Erro"; //Título da página
						$tpl->TITULO_2 = "Erro ao cadastrar habilidade"; //Título do bloco
						$tpl->{TXT} = "Essa habilidade já foi cadastrada anteriomente!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/habilidades.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
						
					}
					
					else{// Se não existir erros
															
						$sql = "INSERT INTO usuariohabilidade VALUES ('$u', '$id_habilidade');";
						
						$minhaConexao = new Conexao();
						$minhaConexao->envia_sql($sql);
					
						$tpl->TITULO_1 = "Adicionar habilidade"; //Título da página
						$tpl->TITULO_2 = "Habilidade adicionada"; //Título do bloco
						$tpl->{TXT} = "A habilidade foi adicionada com sucesso ao seu perfil!";
					
						$tpl->LINK_1 = "http://itech10.com/app/views/usuario/habilidades.php";
						$tpl->BOT_1 = "Voltar";
						$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
						$tpl->BOT_2 = "Página do usuário";
				
						$tpl->block("BLOCK_OP");
					}
				}
			break;
			
//================================================= < Tela lista habilidade > ======================================================
			case "Listar":
				
				
				$tpl->TITULO_1 = "Habilidades"; //Título da página
				$tpl->TITULO_2 = "Suas habilidades"; //Título do bloco
				
	
				$tpl->TXT = "Nome e descrição de suas habilidades cadastradas:";

				
				$sql = "SELECT fk_cd_habilidade FROM usuariohabilidade  WHERE fk_cd_usuario = '$u';"; 
				$minhaConexao = new Conexao();
				$result = $minhaConexao->envia_sql($sql);
				
				$minhaConexao->open();
				while($row = pg_fetch_array($result)){
					
					$sql = "SELECT nome, descricao FROM habilidade WHERE cd_habilidade = '$row[0]';";
					$r = $minhaConexao->envia_sql2($sql);
					$row2 = pg_fetch_array($r);
					
					$tpl->LI_NOME = $row2[0]; //id da habilidade 
					$tpl->LI_DESC = $row2[1]; //nome da habilidadae
					$tpl->block("BLOCK_LIST");					
				}
				$minhaConexao->close();
							
				$tpl->LINK_1 = "http://itech10.com/app/views/usuario/habilidades.php";
				$tpl->BOT_1 = "Voltar";
				$tpl->LINK_2 = "http://itech10.com/app/views/usuario/pg_usuario.php";
				$tpl->BOT_2 = "Página do usuário";
				
				$tpl->block("BLOCK_LISTA");
				
			break;			
			
			
			
			
			case "Cadastrar":
				 Header("Location: cadastro_habilidade.php");
			break;
		
		
		
		
		
		
		
		
		}
	}
	

	$tpl->show();	
	
?>	