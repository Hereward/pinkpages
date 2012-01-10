<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockCityService
* GENERATION DATE:  18.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockCityService.php
* FOR MYSQL TABLE:  BlockCity
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class BlockCityService extends BaseFactoryService { // class : begin

	var $BlockCityId;   // (KEY Attribute)
	var $City;   // (Normal Attribute)
	var $State;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockCityId() {
		return $this->BlockCityId;
	}
	
	public function getCity() {
		return $this->City;
	}
	
	public function getState() {
		return $this->State;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockCityId($val) {
		$this->BlockCityId =  $val;
	}
	
	public function setCity($val) {
		$this->City =  $val;
	}
	
	public function setState($val) {
		$this->State =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockCity() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockCity ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockCityById($BlockCityId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockCity WHERE BlockCityId='$BlockCityId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockCity() {
		
		$SQL = "INSERT INTO BlockCity 
					(
					`City`,
					`State`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->City',
					'$this->State',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockCity() {
		
		$SQL = "UPDATE BlockCity SET
	
					`City`='$this->City',
					`State`='$this->State',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockCityId='$this->BlockCityId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockCity() {
		
		$SQL = "DELETE FROM 
					BlockCity
				WHERE
					BlockCityId='$this->BlockCityId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
