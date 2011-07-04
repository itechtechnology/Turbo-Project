<?php
/*
Nome: Classe Mensagem 1.0
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: 11/05/2011
Descrição: Substitui a classe chat
*/

class Mensagem{
	
    //Variáveis que compõem o objeto
	private $id;
	private $remetente;	
	private $destinatario;
	private $texto;
	private $hora;
	private $status;
	private $titulo;
	
	
	function __construct($id, $remetente, $destinatario, $texto, $hora, $status, $titulo){
		
        $this->id = $id;
		$this->remetente = $remetente;
		$this->destinatario = $destinatario;
		$this->texto = $texto;
		$this->hora = $hora;
		$this->status = $status;
		$this->titulo = $titulo;
		
    }
	
	//Insere um objeto habilidade no banco de dados
	function insert (){		
		include_once 'Conexao.class.php';
		include_once 'Usuario.class.php'; 	  
		
		//Verifico se é um objeto ou apenas um id
		if(is_object($this->remetente)) $remetente = $this->remetente->getId(); 
		else $remetente = $this->remetente;
		if(is_object($this->destinatario))$destinatario =  $this->destinatario->getId();
		else $destinatario = $this->destinatario; 
		
		//Ver se posso fazer isso no postgre	
		date_default_timezone_set('America/Sao_Paulo');
		$data_hora =  date("Y-m-d H:i:s");			
						
		$sql = "INSERT INTO mensagem VALUES (nextval('mensagem_cd_mensagem_seq'::regclass), '$remetente',  '$destinatario', '$this->texto', '$data_hora', '$this->status', '$this->titulo');";

		$minhaConexao = new Conexao(); //Crio uma conexão
		$result = $minhaConexao->envia_sql($sql);	//Envio a SQL
		
		//Altero o id para o valor atual da sequência
		$sql = "SELECT last_value FROM mensagem_cd_mensagem_seq;";
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
		$this->nome = $id;		
	}
	
}
?>