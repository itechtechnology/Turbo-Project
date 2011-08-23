<?php

   //Classe Para abstra��o com banco de dados
   
   abstract class TRecord extends TCriteria
   {
      protected $data;
      
      public function __clone()
      {
         unset ($this->id);
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
      
      public function getEntity()
      {
		$classe = strtolower(get_class($this));

                $tabela = substr($classe, 0, -7); //retornara o nome da entidade 
		//$tabela = substr($classe, 0, -6);
		
//		$esquema = substr($tabela,0,4);
//		
//		switch($esquema)
//		{
//			case "acad":
//			{
//				$esquema = 'academico';
//				break;
//			}
//			
//			case "fina":
//			{
//				$esquema = 'financeiro';
//				break;
//			}
//			
//			case "sist":
//			{
//				$esquema = 'sistema';
//				break;
//			}
//		}
		
//		return $esquema.'.'.$tabela;
		return $tabela;
      }
     
      public function last_id()
      {
          TTransaction::open();

          $conn = TTransaction::get();
          $result = $conn->Insert_ID();

          TTransaction::close();
          
          return $result;
      }

      public function save()
      {
         $sql = new TSqlInsert;
         $sql->setEntity($this->getEntity());

		 foreach($this->data as $key => $value)
         {
			$sql->setRowData($key,$this->$key);
         }
         
         try
         {
            TTransaction::open();
            //TTransaction::log($sql->getInstruction());

            $conn = TTransaction::get();

            //echo $sql->getInstruction()."<br>\n";
            $result = $conn->Execute($sql->getInstruction());
			
            TTransaction::close();
			
			if(!$result)
            {
                throw new Exception('Erro ao Inserir !!');
            }else
            {
                return true;
            }
         }
         catch(exception $e)
         {
             TTransaction::rollback();
         }
      }
      
      public function update($cod)
      {
         $criteria = new TCriteria;
         $criteria->add(new TFilter('cd_'.$this->getEntity(),'=',$cod));
         
         $sql = new TSqlUpdate;
         $sql->setEntity($this->getEntity());
         $sql->setCriteria($criteria);

         foreach($this->data as $key => $value)
         {
            if($key != 'cd_'.$this->getEntity())
            {
               $sql->setRowData($key,$this->$key);
            }
         }
         try
         {
            TTransaction::open();
            //TTransaction::log($sql->getInstruction());
			  
            $conn = TTransaction::get();
            $result = $conn->Execute($sql->getInstruction());
			
			TTransaction::close();
			
            if(!$result)
            {
                throw new Exception('Erro!!');
            } else
            {
                return true;
            }
         }
         catch(exception $e)
         {
             TTransaction::rollback();
         }
      }
      
      public function load(TCriteria $criteria)
      {
         $sql = new TSqlSelect;
         $sql->setEntity($this->getEntity());
         $sql->addColumn('*');
         $sql->setCriteria($criteria);

         try
         {
            TTransaction::open();
            //TTransaction::log($sql->getInstruction());
 
            $conn = TTransaction::get();
		 
            $result = $conn->Query($sql->getInstruction());
			 
            TTransaction::close();
            
            return $result;
         }
         catch(exception $e)
         {
             TTransaction::rollback();
         }
      }
      
      public function delete(TCriteria $criteria)
      {

         $sql = new TSqlDelete;
         $sql->setEntity($this->getEntity());
         $sql->setCriteria($criteria);

         try
         {
            TTransaction::open();
            //TTransaction::log($sql->getInstruction());

            $conn = TTransaction::get();
            $result = $conn->Execute($sql->getInstruction());
			
            TTransaction::close();
            
            if($result)
            {
               return $result;
            }else
            {
                return false;
            }
         }
         catch(exception $e)
         {
             TTransaction::rollback();
         }
      }
   }
?>
