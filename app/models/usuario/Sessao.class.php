<?php
/*
Nome: Cria, verifica e remove sessões 1.1
Autor: Marcos Rosa
Criado em: 05/05/11
Modificado por: Marcos Rosa - Data 06/05/11
Descrição: 3 funções para criar, verificar e remover a sessão de login
*/

Class Sessao{
	
	
	function __construct(){
		
		} //método construtor
	
//============================================================================================================================
	function cria_sessao ($login, $senha){ //Irá criar uma nova sessão, recebe o login e uma senha criptografada 
	
		
			if($this->verifica_sessao() == FALSE){//Verifico se a sessão foi criada anteriomente
				include_once 'Conexao.class.php';
				include_once 'Usuario.class.php';
		
				//Vejo no banco se os dados estão corretos
				$sql = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha';";
		
				$minhaConexao = new Conexao(); //Crio uma conexão
				$result = $minhaConexao->envia_sql($sql);	//Envio a SQL

				$row = pg_fetch_array($result);
			
				if ($row == NULL) return FALSE; //Falha ao criar sessão
				else{
					
					date_default_timezone_set('America/Sao_Paulo');
					$data_hora =  date("Y-m-d H:i:s");	
					
					$sql =  "UPDATE usuario SET dt_ultimoacesso = '$data_hora' WHERE login = '$login';";
					$result = $minhaConexao->envia_sql($sql);	//Envio a SQL
					
					$user_ = new Usuario($row[0], $row[2], $row[3], $row[7], $row[6], $row[8], $row[9], $row[11], $row[10], $row[1], NULL); //Crio o objeto usuáio
			
					$dados["sessao_"] = TRUE;  //Variável sessão iniciada
 					$dados["usuario_"] = $user_;
 					//gravo a sessao por padrao o php hj ja passa o serialize automaticamente nao precisa mais passar ela
 					$_SESSION["dados"] = serialize($dados);		
						
					return TRUE; //Sessão criada com sucesso			
				}
			}
			else return TRUE;//Verdadeiro se a sessão já existir
	
	}
//============================================================================================================================
	function verifica_sessao(){ //Verifico se a sessão está ativa
		
		
			session_start(); //Inicio a sessão			
			if (isset($_SESSION["dados"])){// Verifico se a sessão está ativada 
				$dados = unserialize($_SESSION["dados"]);
				$user_ = $dados["usuario_"];
 				$s = $dados["sessao_"];
				return $user_; //Retorna um objeto usuário	
			}
			else return FALSE;	
	}
//============================================================================================================================
	function destroi_sessao(){ //Remove a sessão
	
		session_unset(); //Destroi as variáveis
		session_destroy(); //Destroi a sessão
	}
//============================================================================================================================
}
?>