<?php

	/* classe para inserчуo no Db
	*
	*/
	
	final class TSqlInsert extends TSqlInstruction 
	{
		/* serRowData atribui valores 
		* a determinadas colunas do banco de dados
		*/
		
		public function setRowData($column,$value)
		{
			//monta um array associativo
			
			if(is_string($value))
			{
				//adiciona \ em aspas
				$value = addslashes($value);
				
				//caso seja string
			    $this->columnValues[$column] = "'$value'";
			}
			else if(is_bool($value))
			{
				$this->columnValues[$column] = $value ? 'TRUE': 'FALSE';
			}
			else if(isset($value))
			{
				$this->columnValues[$column] = $value;
			}
			else 
			{
				$this->columnValues[$column] = "NULL";
			}
		}
		
		/* setCriteria, nуo existe nessa classe
		* assim, ele lanчa um erro se for executado
		*/
		
		public function setCriteria($criteria)
		{
			throw new Exception("Cannot call setCriteria from " .__CLASS__);
		}
		
		/*getInstruction
		* retorna a instruчуo SQL em forma de string
		*/
		
		public function getInstruction()
		{
			$this->sql = "INSERT INTO {$this->entity} (";
			$columns = implode(', ', array_keys($this->columnValues));
			$values = implode(', ', array_values($this->columnValues));
			$this->sql .= $columns . ')';
			$this->sql .=" VALUES ({$values});";
			
			return $this->sql;
		}
	}

?>