<?php
/*
Nome: Classe Habilidade 1.0
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa 15/05/2011 
Descrição: Habilidades de um usuário
*/

class Habilidade{
	
    //Variáveis que compõem o objeto
	private $id;
	private $nome;	
	private $descricao;
	private $data_cadastro;
	
	
	function __construct($id, $nome, $descricao, $data_cadastro){
		
        $this->id = $id;
		$this->nome = $nome;
		$this->descricao = $descricao;
		$this->data_cadastro = $data_cadastro;
    }
	
	//Insere um objeto habilidade no banco de dados
	function insert (){		
		include_once 'Conexao.class.php';
		
		date_default_timezone_set('America/Sao_Paulo');
		$data_hora =  date("Y-m-d H:i:s"); //Dara do cadastro		 	
						
		$sql = "INSERT INTO habilidade VALUES (nextval('habilidade_cd_habilidade_seq'::regclass), '$this->descricao',  '$this->nome', '$data_hora');";

		$minhaConexao = new Conexao(); //Crio uma conexão
		$minhaConexao->envia_sql($sql);	//Envio a SQL
		
		//Altero o id para o valor atual da sequência
		$sql = "SELECT last_value FROM habilidade_cd_habilidade_seq;";
		$r = $minhaConexao->envia_sql($sql);	//Envio a SQL
		$row = pg_fetch_array($r);
		$this->id = $row[0];
	}
	
	
	//gets e sets 
	function getId (){
		return $this->id;		
	}
	
	function setId ($id){
		$this->nome = $id;		
	}
	function getNome (){
		return $this->nome;		
	}
	
	function setNome ($nome){
		$this->nome = $nome;		
	}
	function getDescricao (){
		return $this->Descricao;		
	}
	
	function setDescricao ($Descricao){
		$this->Descricao = $Descricao;		
	}	
}
?>