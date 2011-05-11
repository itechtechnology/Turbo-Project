<?php
/*
Nome: Classe Usuário 1.1
Autor: Marcos Rosa
Criado em: 01/05/11
Modificado por: Marcos Rosa - Data 06/05/11
Descrição: Classe do usuário
*/
class Usuario{
	
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
	private $tele_residencial;
	private $tele_celular;
	private $endereco;
	private $habilidades;
			
	
	//Construtor - Obs:. Noque que a declaração dos construtores são diferentes do que estamos acostumados no JAVA
	function __construct($id, $nome, $login, $email, $senha, $sexo, $cpf, $data_nascimento, $data_cadastro, $tele_residencial, $tele_celular, $endereco, $habilidade){
		
        $this->id = $id;
		$this->nome = $nome;
		$this->login = $login;
        $this->email = $email;
        $this->senha = $senha;
		$this->sexo = $sexo;
		$this->cpf = $cpf;
        $this->dtNascimento = $data_nascimento;
		$this->dtCadastro = $data_cadastro;
        $this->tele_residencial = $tele_residencial;
		$this->tele_celular = $tele_celular;
		$this->endereco = $endereco;
		$this->habilidade = $habilidade;
    }
	
	//Insere um objeto usuário no banco de dados
	function insert (){	
	
		include_once 'conexao.class.php';
		include_once 'Endereco.class.php';
		
		  	
		if($this->endereco != NULL) $endereco = $this->endereco->getId();
		else $endereco = NULL;
						
		$sql = "INSERT INTO usuario VALUES (nextval('usuario_cd_usuario_seq'::regclass), '$endereco', '$this->nome', '$this->login', NULL, NULL, '$this->senha', '$this->email', '$this->sexo', '$this->cpf', CURRENT_DATE, '$this->dtNascimento');";

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
	
}
?>