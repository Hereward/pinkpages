<?php

/**
 *  MyDB Class
 *
 *  extends MDB_QueryTool class
 * 
 *  @author     Vinod Kumar
 *  @package    Project Name
 *
 */

class MyDB extends MDB_QueryTool {

	public function getInsertId() {
		return mysql_insert_id();
	}

	public function fetchAll($rs) {
		return $this->db->fetchAll($rs);
	}

	public function query($sql) {

		return $this->db->queryAll($sql);
	}
	
/*	public function affectedRows($sql) {

		return mysql_affected_rows($sql);
	}*/

	public function quote($str) {
		return mysql_real_escape_string($str);
	}
	
	public function setFetchMode($mode_num) {//1->numeric,2->associative, 3->object
		$this->db->setFetchMode($mode_num);
	}
	
	public function exec($sql) {//1->numeric,2->associative, 3->object
		return $this->db->exec($sql);
	}

}/*END MyDB*/
?>