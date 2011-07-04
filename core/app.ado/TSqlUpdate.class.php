<?php

	//classe para update no DB
	
	final class TSqlUpdate extends TSqlInstruction 
	{
		//valores a serem alterados
		
		public function setRowData($column,$value)
		{
			if(is_string($value))
			{
				$value = addslashes($value);
				$this->columnValues[$column] = "'$value'";
			}
			else if(is_bool($value))
			{
				$this->columnValues[$column]= $value ? 'TRUE': 'FALSE';
			}
			else if(isset($value))
			{
				$this->columnValues[$column]= $value;
			}
			else 
			{
				$this->columnValues[$column]= "NULL";
			}
		}
		
		/*getInstruction
		* retorna a string de UPDATE
		*/
		
		public function getInstruction()
		{
			$this->sql = "UPDATE {$this->entity}";
			
			//monta os pares coluna=valor
			
			if($this->columnValues)
			{
				foreach ($this->columnValues as $column=> $value)
				{
					$set[] = "{$column} = {$value}";
				}
			}
			$this->sql .= ' SET '.implode(', ',$set);
			
			//retorna a cláusula WHERE
			
			if($this->criteria)
			{
				$this->sql .= ' WHERE ' . $this->criteria->dump();
			}
			return $this->sql;
		}
	}
?>