<?
/*
Nome: Classe conexão 1.0
Autor: Marcos Rosa
Criado em: 07/05/11
Modificado por: Marcos Rosa em 08/05/11
Descrição: Métodos para conexão com o banco e envio de SQLs
*/
Class Conexao{
	
	private $host = "localhost";
	private $user = "itechcom";
	private $pswd = "itechuesc123";
	private $dbname = "itechcom_turbo";
	private $con = null;

	function __construct(){} //método construtor

	#método que inicia conexao 
	function open(){
		$this->con = @pg_connect("host=$this->host user=$this->user
		password=$this->pswd dbname=$this->dbname");
		return $this->con;
	}

	#método que encerra a conexao
	function close(){
		@pg_close($this->con);
	}

	#método verifica status da conexao
	function statusCon(){
		if(!$this->con){
			echo "<h3>O sistema não está conectado à  [$this->dbname] em [$this->host].</h3>";
			exit;
	}
		else{
			echo "<h3>O sistema está conectado à  [$this->dbname] em [$this->host].</h3>";
		}
	}
	
	
	/*método que add de forma genérica uma SQL ao banco
	Basta add o seguinte código em aluma página...
	
	$minhaConexao = new Conexao();
	$minhaConexao->envia_sql($sql);
	
	... onde $sql deve ser uma string com a sql a ser enviada para o banco
	
	*/
	function envia_sql($sql){
		
		$this->open(); //Abre a conexão		

		$result = pg_query($this->con, $sql);//Envia a SQL para o banco
		if (!$result) {
  			echo "Erro na consulta.<br>";
  		exit;		
		}
		
		$this->close(); //Fecha conexão
		return $result; //The query result resource on success or FALSE on failure.
	}
	
	
}
?>