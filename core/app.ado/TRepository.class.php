<?php
/*
 * classe TRepository
 *  Esta classe provê os métodos
 *  necessários para manipular coleções de objetos.
 */
final class TRepository
{
    private $class; // nome da classe manipulada pelo repositório
    protected $data;
    
    /* método __construct()
     *  instancia um Repositório de objetos
     *  @param $class = Classe dos Objetos
     */
    function __construct($class)
    {
        $this->class = $class;
    }
    
    public function __get($propriedade)
    {
         if(method_exists($this, 'get_'.$propriedade))
         {
            return call_user_func(array($this, 'get_'.$propriedade));
         }
         else
         {
            return $this->data[$propriedade];
         }
    }

      public function __set($propriedade,$value)
      {
         if(method_exists($this, 'set_'.$propriedade))
         {
            return call_user_func(array($this, 'set_'.$propriedade),$value);
         }
         else
         {
            $this->data[$propriedade] = $value;
         }
      }
      
    /*
     * método load()
     *  Recuperar um conjunto de objetos (collection) da base de dados
     *  através de um critério  de seleção, e instanciá-los em memória
     *  @param $criteria = objeto do tipo TCriteria
     */
    function load(TCriteria $criteria)
    {
        // instancia a instrução de SELECT
        $sql = new TSqlSelect;
        $sql->addColumn('*');
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transação
        TTransaction::open();

        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa a consulta no banco de dados            
            $result= $conn->Execute($sql->getInstruction());
			 
            if ($result->FieldCount() > 0)
            { 
                // percorre os resultados da consulta, retornando um objeto
                while (!$result->EOF)
                {
					// armazena no array $results;
                    $results[] = $result->fetchObject($this->class . 'Record');

                    $result->moveNext();
                }
            }
			
            TTransaction::close();
			 
            return $results;
        }
        else
        {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa !!');
        }   
    }
    
    /*
     * método delete()
     *  Excluir um conjunto de objetos (collection) da base de dados
     *  através de um critério de seleção.
     *  @param $criteria = objeto do tipo TCriteria
     */
    function delete(TCriteria $criteria)
    {
        // instancia instrução de DELETE
        $sql = new TSqlDelete;
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transação
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instrução de DELETE
            $result = $conn->Execute($sql->getInstruction());

            return $result;

        }
        else
        {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa !!');
        }
    }
    
    /*
     * método count()
     *  Retorna a quantidade de objetos da base de dados
     *  que satisfazem um determinado critério de seleção.
     *  @param $criteria = objeto do tipo TCriteria
     */
    function count(TCriteria $criteria)
    {
        // instancia instrução de SELECT
        $sql = new TSqlSelect;
        $sql->addColumn('count(*)');
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transação
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instrução de SELECT
            $result= $conn->Execute($sql->getInstruction());

            if ($result)
            {
                $row = $result->fields[0];
            }

            // retorna o resultado
            return $row;
        }
        else
        {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa !!');
        }
    }
    
    function sum(TCriteria $criteria,$coluna)
    {
        // inicia transação
        TTransaction::open();

        // instancia instrução de SELECT
        $col = 'SUM('.$coluna.')';
        $sql = new TSqlSelect;
        $sql->addColumn($col);
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);

        // inicia transação
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instrução de SELECT
            $result= $conn->Execute($sql->getInstruction());
 
            if ($result)
            {
                $row = $result->fields[0];
            }

            // retorna o resultado
            return $row;
        }
        else
        {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa !!');
        }
        
        TTransaction::close();
    }
    
     function update(TCriteria $criteria)
      {

         $sql = new TSqlUpdate;
         $sql->setEntity($this->class);
         $sql->setCriteria($criteria);

         foreach($this->data as $key => $value)
         {
            if($key !== 'id')
            {
               $sql->setRowData($key,$this->$key);
            }
         }
                 
         $conn = TTransaction::get();
         
         if ($conn)
         {
            $result = $conn->Execute($sql->getInstruction());
            
         } else {
            throw new Exception('Não há transação ativa !!');
         }
      }
      
      // Metodo para selecionar intens sem repetição

      function loadDistinct(TCriteria $criteria,$campo)
      {
          // instancia a instrução de SELECT
          $sql = new TSqlSelect;
          $sql->addColumn('DISTINCT('.$campo.')');
          $sql->setEntity($this->class);
          $sql->setCriteria($criteria);
        
          // inicia transação
          TTransaction::open();
        
          $conn = TTransaction::get();
          
          if ($conn)
          { 
            // executa a consulta no banco de dados
            $result= $conn->Execute($sql->getInstruction());
             
            if ($result->FieldCount() > 0)
            { 
                // percorre os resultados da consulta, retornando um objeto
                while (!$result->EOF)
                {
                    // armazena no array $results;
                    $results[] = $result->fetchObject($this->class . 'Record');

                    $result->moveNext();
                }
            } 
            return $results;
        }
        else
        {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa !!');
        }
        
        TTransaction::close();   
     }
}  
?>