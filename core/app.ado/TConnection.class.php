<?php
	/* classe para gerenciar
	* as conexões com o DB através de arquivos de configuração
	*/
	
	final class TConnection
	{
		private function __construct() {}

		/*Metodo open()
		* recebe os parametros do DB e instancia um objeto ADODB
		*/
		
		public static function open($user = '',$pass = '')
		{
			$conn =  ADONewConnection(DBSGBD);
			$conn->debug = false; // coloca o debug como ativo
			
			if((empty($user)) and (empty($pass)))
			{  
				if($conn->PConnect(DBHOST,DBUSER,DBPASS,DBNAME))
				{
					return $conn;
				} else
				{
					return false;
				}
			} else
			{ 
				if($conn->PConnect(DBHOST,$user,$pass,DBNAME))
				{
					return $conn;
				} else
				{
					return false;
				}
			}	
		}
		
		public static function closeConnection($conn)
		{
			$conn->Execute('COMMIT');
		}
		
		public static function revertConnection($conn)
		{
			$conn->Execute('ROLLBACK');
		}
	}
?>
