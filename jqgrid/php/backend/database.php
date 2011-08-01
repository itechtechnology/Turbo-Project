<?php
/**
 * jqScheduler
 *
 * Database backend
 *
 * @version 1.0
 * @author Tony Tomov
 * @copyright (c) Tony Tomov
 */
require_once('backend.php');

final class Database extends Backend 
{
	private $db;
	private $table;
	private $user_id;
	private $dbmap;
	private $dbtype;
	// 
	private $searchwhere = "";
	private $searchdata = array();


	public function __construct($db) {
		$this->db = $db;
	}
  
	public function setUser( $user) {
		if($user) {
			$this->user_id=$user;
		}
	}
	public function setTable( $table) {
		if($table) {
			$this->table=$table;
		}
	}
	public function setDbMap( $map ) {
		$this->dbmap =$map;		
	}
	public function setDbType( $dtype ) {
		$this->dbtype =$dtype;		
	}
	public function setSearchs( $where, array $whrval)
	{
		$this->searchwhere = $where;
		$this->searchdata = $whrval;
	}
	
	public function newEvent($start, $end, $title, $description, $location, $categories, $access, $allDay) {
		if (!empty($this->user_id) && !empty($this->table) ) {
			jqGridDB::beginTransaction($this->db);
			$query = jqGridDB::prepare($this->db,
			"INSERT INTO ".$this->table."	(user_id, start, end, title, description, location, categories, access, all_day)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
			array($this->user_id,
				$start,
				$end,
				$title,
				$description,
				$location,
				$categories,
				$access,
				$allDay
			));
			jqGridDB::execute($query);
			$lastid = jqGridDB::lastInsertId($this->db, $this->table, 'event_id', $this->dbtype);
			jqGridDB::commit($this->db);
			jqGridDB::closeCursor($query);
			return $lastid;
		} else {
			return false;
		}
	}

	public function editEvent($id, $start, $end, $title, $description, $location, $categories, $access, $allDay) 
	{
		if (!empty($this->user_id) && !empty($this->table)) {
			$query = jqGridDB::prepare($this->db,
			"UPDATE ".$this->table." SET start=?, end=?, title=?, description=?, location=?, categories=?, access=?, all_day=?
			WHERE event_id=?
			AND user_id=?",
			array($start,
				$end,
				$title,
				$description,
				$location,
				$categories,
				$access,
				$allDay,
				$id,
				$this->user_id
			));
			jqGridDB::execute($query);
			jqGridDB::closeCursor($query);
			return true;
		} else {
			return false;
		}
	}

	public function moveEvent($id, $start, $end, $allDay) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$query = jqGridDB::prepare($this->db,
			"UPDATE ".$this->table." SET start=?, end=?, all_day=?
			WHERE event_id=?
			AND user_id=?",
			array($start,
				$end,
				$allDay,
				$id,
				$this->user_id
			));
			jqGridDB::execute($query);
			jqGridDB::closeCursor($query);
			return  true;
		} else {
			return false;
		}
	}
  
	 public function resizeEvent($id, $start, $end) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$query = jqGridDB::prepare($this->db,
			"UPDATE ".$this->table." SET start=?, end=?
			WHERE event_id=?
			AND user_id=?",
			array($start,
				$end,
				$id,
				$this->user_id
			));
			jqGridDB::execute($query);
			jqGridDB::closeCursor($query);
			return true;
		} else {
			return false;
		}
	}

	public function removeEvent($id) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$query = jqGridDB::prepare($this->db,"DELETE FROM ".$this->table." WHERE event_id=?	AND user_id=? ORDER by start",
				array((int)$id,$this->user_id)
			);
			jqGridDB::execute($query);
			jqGridDB::closeCursor($query);
			return true;
		} else {
			return false;
		}
	}
  
	public function getEvents($start, $end) {
		if (!empty($this->user_id) && !empty($this->table) ) {
			$sql = "SELECT ";
			$i =0;
			foreach($this->dbmap as $k=>$v) {
				$sql .= $i==0 ?  $k .' AS '.$v :  ', '.$k .' AS '.$v;
				$i++;
			}
			
			if(strlen($this->searchwhere) > 0 ) {
				$sql .= ' FROM '.$this->table.' WHERE '.$this->searchwhere.' AND (user_id = ?) ORDER BY start DESC';
				$params = $this->searchdata;
				$params[] = (int)$this->user_id;
			} else {
				$sql .= ' FROM '.$this->table.' WHERE user_id = ? AND start >= ? AND start <= ? ORDER BY start'; 
				$params = array((int)$this->user_id, (int)$start, (int)$end);
			}
			$query = jqGridDB::prepare($this->db, $sql, $params );
			$ret = jqGridDB::execute($query);
			$ev = array();
			while($row = jqGridDB::fetch_assoc($query, $this->db))
			{
				$row[$this->dbmap['all_day']] = $row[$this->dbmap['all_day']] == 1 ? true : false;
				$ev[] = $row;
			}
			jqGridDB::closeCursor($query);
			return $ev;
		} else {
			return false;
		}
	}
}
?>