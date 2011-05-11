<?php
/*
Nome: Classe Endereco 1.0
Autor: Marcos Rosa
Criado em: 01/05/11
Modificado por: 
Descrição: Classe endereço
*/

class Endereco{
	
    //Variáveis que compõem o objeto
	private $id;
	private $rua;
	private $bairro;
	private $cidade;
	private $estado;
	private $cep;
	private $numero;
	private $complemento;
	private $pais;
	private $tel_fixo;
	private $tel_celular;
	
	
	function __construct($id, $rua, $numero, $complemento, $bairro, $cidade, $cep, $pais, $tel_celular, $tel_fixo, $estado){
		
		$this->id = $id;
		$this->rua= $rua;
		$this->numero = $numero;
		$this->complemento = $complemento;
		$this->bairro = $bairro;
		$this->cidade = $cidade;		
		$this->cep = $cep;
		$this->pais = $pais;
		$this->tel_celular = $tel_celular;
		$this->tel_fixo = $tel_fixo;		
		$this->estado = $estado;
    }
	
	//Insere um objeto endereço no banco de dados
	function insert (){		
		include_once 'conexao.class.php'; 	
						
		$sql = "INSERT INTO endereco VALUES (nextval('endereco_cd_endereco_seq'::regclass), '$this->rua',  '$this->numero', '$this->complemento', '$this->bairro', '$this->cidade', '$this->cep', '$this->pais', '$this->tel_celular', '$this->tel_fixo', '$this->estado');";

		$minhaConexao = new Conexao(); //Crio uma conexão
		$result = $minhaConexao->envia_sql($sql);	//Envio a SQL
		
		//Altero o id para o valor atual da sequência
		$sql = "SELECT last_value FROM endereco_cd_endereco_seq;";
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
	
	
}
?>