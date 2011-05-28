<?php
/*
 * classe TRepository
 *  Esta classe prov� os m�todos
 *  necess�rios para manipular cole��es de objetos.
 */
final class TRepository
{
    private $class; // nome da classe manipulada pelo reposit�rio
    protected $data;
    
    /* m�todo __construct()
     *  instancia um Reposit�rio de objetos
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
     * m�todo load()
     *  Recuperar um conjunto de objetos (collection) da base de dados
     *  atrav�s de um crit�rio  de sele��o, e instanci�-los em mem�ria
     *  @param $criteria = objeto do tipo TCriteria
     */
    function load(TCriteria $criteria)
    {
        // instancia a instru��o de SELECT
        $sql = new TSqlSelect;
        $sql->addColumn('*');
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transa��o
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
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa !!');
        }   
    }
    
    /*
     * m�todo delete()
     *  Excluir um conjunto de objetos (collection) da base de dados
     *  atrav�s de um crit�rio de sele��o.
     *  @param $criteria = objeto do tipo TCriteria
     */
    function delete(TCriteria $criteria)
    {
        // instancia instru��o de DELETE
        $sql = new TSqlDelete;
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transa��o
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instru��o de DELETE
            $result = $conn->Execute($sql->getInstruction());

            return $result;

        }
        else
        {
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa !!');
        }
    }
    
    /*
     * m�todo count()
     *  Retorna a quantidade de objetos da base de dados
     *  que satisfazem um determinado crit�rio de sele��o.
     *  @param $criteria = objeto do tipo TCriteria
     */
    function count(TCriteria $criteria)
    {
        // instancia instru��o de SELECT
        $sql = new TSqlSelect;
        $sql->addColumn('count(*)');
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);
        
        // inicia transa��o
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instru��o de SELECT
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
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa !!');
        }
    }
    
    function sum(TCriteria $criteria,$coluna)
    {
        // inicia transa��o
        TTransaction::open();

        // instancia instru��o de SELECT
        $col = 'SUM('.$coluna.')';
        $sql = new TSqlSelect;
        $sql->addColumn($col);
        $sql->setEntity($this->class);
        $sql->setCriteria($criteria);

        // inicia transa��o
        $conn = TTransaction::get();
        
        if ($conn)
        {
            // executa instru��o de SELECT
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
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa !!');
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
            throw new Exception('N�o h� transa��o ativa !!');
         }
      }
      
      // Metodo para selecionar intens sem repeti��o

      function loadDistinct(TCriteria $criteria,$campo)
      {
          // instancia a instru��o de SELECT
          $sql = new TSqlSelect;
          $sql->addColumn('DISTINCT('.$campo.')');
          $sql->setEntity($this->class);
          $sql->setCriteria($criteria);
        
          // inicia transa��o
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
            // se n�o tiver transa��o, retorna uma exce��o
            throw new Exception('N�o h� transa��o ativa !!');
        }
        
        TTransaction::close();   
     }
}  
?>
