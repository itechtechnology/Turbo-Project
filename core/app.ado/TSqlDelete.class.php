<?php

	// classe para delete no DB

	final class TSqlDelete extends TSqlInstruction 
	{
		//retorna a string de delete
		
		public function getInstruction()
		{
			$this->sql = "DELETE FROM {$this->entity} ";
			
			if($this->criteria)
			{
				$expression = $this->criteria->dump();
				if($expression)
				{
					$this->sql .= ' WHERE '. $expression;
				}
			}
			return $this->sql;
		}
	}
?>
