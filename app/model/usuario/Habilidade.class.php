<?php
/*
Nome: Classe Habilidade 1.0
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa 
Descrição: Habilidades de um usuário
*/

class Habilidade{
	
    //Variáveis que compõem o objeto
	private $id;
	private $nome;	
	private $descricao;
	
	
	function __construct($id, $nome, $descricao){
		
        $this->id = $id;
		$this->nome = $nome;
		$this->descricao = $descricao;
    }
	
	//Insere um objeto habilidade no banco de dados
	function insert (){		
		include_once 'conexao.class.php'; 	
						
		$sql = "INSERT INTO habilidade VALUES (nextval('habilidade_cd_habilidade_seq'::regclass), '$this->descricao',  '$this->nome');";

		$minhaConexao = new Conexao(); //Crio uma conexão
		$minhaConexao->envia_sql($sql);	//Envio a SQL
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