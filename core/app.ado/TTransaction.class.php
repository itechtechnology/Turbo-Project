<?php

     //classe para manipular transações
     
     final class TTransaction
     {
           private static $conn;
           private static $logger;  //objeto LOG
           
           private function __construct(){}
           
           //abre conexão com o DB
           
           public static function open()
           {
                  if(empty(self::$conn))
                  {
                     self::$conn = TConnection::open();
                     
                     //inicia a transação
                     self::$conn->StartTrans();
                     
                     self::$logger = NULL;
                  }
           }
           
           //retorna a conexão ativa
           
           public static function get()
           {
                  return self::$conn;
           }
           
           //desfaz todas as operações realizadas
           
           public static function rollback()
           {
                  if(self::$conn)
                  {
                     //self::$conn->RollbackTrans();
					 TConnection::revertConnection(self::$conn);
                     self::$conn = NULL;
                  }
           }
           
           //aplica todas as alterações realizadas e fecha a transação
           
           public static function close()
           {
                  if(self::$conn)
                  {
                     //self::$conn->CommitTrans();
					 TConnection::closeConnection(self::$conn);
                     self::$conn = NULL;
                  }
           }
           
           //define qual algoritmo de LOG usar
           
           public static function setLogger(TLogger $logger)
           {
                  self::$logger = $logger;
           }
           
           //armazena uma mensagem no arquivo de LOG
           
           public static function log($message)
           {
                  if(self::$logger)
                  {
                     self::$logger->write($message);
                  }
           }
     }
?>
