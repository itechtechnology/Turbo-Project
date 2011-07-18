<?php
/*
Nome: Classe Usuário 1.1
Autor: Marcos Rosa
Criado em: 01/05/11
Modificado por: Marcos Rosa - Data 01/06/11
Descrição: Classe do usuário
*/

 
class UsuarioRecord extends ManipulaBanco{ 
	
    //Variáveis que compõem o objeto
	private $id;
	private $nome;	
	private $login;
	private $email;
	private $senha; 
	private $sexo;
	private $cpf;
	private $dtNascimento;
	private $dtCadastro;
	private $endereco;
	private $habilidades;
			
	
	function __construct(){
		session_start(); //Inicio a sessão
		}
	
	function construtor($id, $nome, $login, $email, $senha, $sexo, $cpf, $data_nascimento, $data_cadastro, $endereco, $habilidade){
		
        $this->id = $id;
		$this->nome = $nome;
		$this->login = $login;
        $this->email = $email;
        $this->senha = $senha;
		$this->sexo = $sexo;
		$this->cpf = $cpf;
        $this->dtNascimento = $data_nascimento;
		$this->dtCadastro = $data_cadastro;
		$this->endereco = $endereco;
		$this->habilidade = $habilidade;
    }
	
	function listaPerguntas(){//Retorna as id e as opções de perguntas secretas
		
		$sql = "SELECT * FROM opcoesperguntas;"; 
		$result = $this->executarPesquisa($sql);
		return $result;
	}
	
	//Varifica a autenticação dos dados do usuário e a senha no banco de dados
	function autentica($dado, $senha){ //$dado = login ou e-mail ou cpf
			
		//Vejo no banco se os dados estão corretos
		$sql = "SELECT cd_usuario FROM usuario WHERE (login = '$dado' OR email = '$dado' OR cpf = '$dado') AND senha = '$senha';";
		$result = $this->executarPesquisa($sql);
			
		if($result) return $result['CD_USUARIO'] [1];
		else return FALSE;
	}
	
	
	function login($dado, $senha){ 
	
		if($this->verificaLogin() == FALSE){//Verifico se a sessão foi criada anteriomente
			$user =  $this->autentica($dado, $senha);
			
			if($user){ 
				$_SESSION["login"] = $user; //Crio a sessão login com o cd_usuario
				return TRUE; 
			}
			else return FALSE;		
		}
	
	}
	
	
	function verificaLogin(){ //Verifico se a sessão está ativa
				
			if (isset($_SESSION["login"])){// Verifico se a sessão está ativada
				$user_ = $_SESSION["login"];
				return $user_; //Retorna um objeto usuário	
			}
			else return FALSE;	
	}
	
	function logout(){ //Remove a sessão
	
		
		session_unregister($_SESSION["login"]); //Remove a variável global
		session_unset();
		session_destroy(); //Destroi todos os dados da sessão
	}
	
	
	//Insere um objeto usuário no banco de dados
	function insert (){	
	
		include_once 'Conexao.class.php';
		include_once 'Endereco.class.php';
		include_once '../controllers/usuario/converte_data2.func.php';
		
		//Verifico se é um objeto ou apenas um id
		if(is_object($this->endereco)) $endereco = $this->endereco->getId(); 	
		else $endereco = $this->endereco;
		
		date_default_timezone_set('America/Sao_Paulo');
		$data_hora =  date("Y-m-d H:i:s"); //Dara do cadastro	
		$data = converte_data2($this->dtNascimento); //Data de nascimento
						
		$sql = "INSERT INTO usuario VALUES (nextval('usuario_cd_usuario_seq'::regclass), '$endereco', '$this->nome', '$this->login', NULL, NULL, '$this->senha', '$this->email', '$this->sexo', '$this->cpf', '$data_hora', '$data');";

		$minhaConexao = new Conexao(); //Crio uma conexão
		$result = $minhaConexao->envia_sql($sql);	//Envio a SQL
		
		//Altero o id para o valor atual da sequência
		$sql = "SELECT last_value FROM usuario_cd_usuario_seq;";
		$r = $minhaConexao->envia_sql($sql);	//Envio a SQL
		$row = pg_fetch_array($r);
		$this->id = $row[0];
		
		
		return $result; // retorno o resultado da SQL
	}
	
	//gets e sets 
	function getId (){
		return $this->id;		
	}
	
	function setId ($id){
		$this->id = $id;		
	}
	
	function getNome (){
		return $this->nome;		
	}
	
	function setNome ($nome){
		$this->nome = $nome;		
	}
	
	function getLogin (){
		return $this->login;		
	}
	
	function setLogin ($login){
		$this->login = $login;		
	}
	
	function getEmail (){
		return $this->email;		
	}
	
	function setEmail ($email){
		$this->email = $email;		
	}
	
	function getSexo (){
		return $this->sexo;		
	}
	
	function setSexo ($sexo){
		$this->sexo = $sexo;		
	}
	
	function getCpf (){
		return $this->cpf;		
	}
	
	function setCpf ($cpf){
		$this->cpf = $cpf;		
	}
	
	function getSenha (){
		return $this->senha;		
	}
	
	function setSenha ($senha){
		$this->senha = $senha;		
	}
	function getDtNascimento (){
		return $this->dtNascimento;		
	}
	
	function setDtNascimento ($dtNascimento){
		$this->dtNascimento = $dtNascimento;		
	}
	
	function getEndereco (){
		return $this->endereco;		
	}
	
	
	
}
?>