<?php

final class TSqlInsert extends TSqlInstruction{
	
	public function setRowData($column, $value){
		if(is_string($value)){
			$value = addslashes($value);
			$this->columnValues[$column] = "'$value'";
		}else if (is_bool($value)){
			$this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
		}else if(isset($value)){
			$this->columnValues[$column] = $value;
		}else{
			$this->columnValues[$column] = "NULL";
		}
	}
	
	public function setCriteria($criteria){
		throw new Exception("Nao pode chamar setCriteria from " . __CLASS__);
	}

	
	public function getInstruction(){
		$this->sql = "INSERT INTO {$this->rntity} (";
		
		$columns = implode(', ', array_keys($this->columnValues));
		
		$values = implode(', ', array_values($this->columnValues));
		
		$this->sql .= $columns .')';
		
		$this->sql .= " values ({$values})";
		
		return $this->sql;
	}
}
?>