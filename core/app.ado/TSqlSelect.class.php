<?php

	/* classe para manipulaчуo
	* de SELECT no DB
	*/
	
	final class TSqlSelect extends TSqlInstruction 
	{
		private $columns;  //array com as colunas a serem retornadas
		
		/* assColumn 
		* adicona a coluna a ser retornadas no SELECT
		*/
		
		public function addColumn($column)
		{
			$this->columns[]= $column;
		}
		
		/* getInstruction
		* retorna a expressуo SELECT
		*/
		
		public function getInstruction()
		{
			$this->sql = 'SELECT ';
			$this->sql .= implode(',',$this->columns);
			$this->sql .=' FROM '. $this->entity;
			
			//obtщm a clсusula WHERE
			
			if($this->criteria)
			{
				$expression = $this->criteria->dump();
				if($expression)
				{
					$this->sql .= ' WHERE '. $expression;
				}
				
				$order = $this->criteria->getProperty('order');
				$limit = $this->criteria->getProperty('limit');
				$offset = $this->criteria->getProperty('offset');
				$group= $this->criteria->getProperty('group');
				$orderType = $this->criteria->getProperty('type');

				//ordenaчуo do SELECT...
				
				if($order)
				{
					$this->sql .= ' ORDER BY ' . $order;
					
					if(!empty($orderType))
					{
						$this->sql .= ' '.$orderType;
					}
				}
				if($limit)
				{
					$this->sql .= ' LIMIT ' . $limit;
				}
				if($offset)
				{
					$this->sql .= ' OFFSET ' . $offset;
				}
				if($group)
				{
					$this->sql .= ' GROUP BY ' . $group;
				}
			}
			return $this->sql;
		}
	}
?>