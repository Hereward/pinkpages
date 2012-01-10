<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockedCityService
* GENERATION DATE:  12.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockedCityService.php
* FOR MYSQL TABLE:  BlockedCity
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class BlockedCityService extends BaseFactoryService { // class : begin

	var $BlockedCityId;   // (KEY Attribute)
	var $City;   // (Normal Attribute)
	var $State;   // (Normal Attribute)
	var $AddTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockedCityId() {
		return $this->BlockedCityId;
	}
	
	public function getCity() {
		return $this->City;
	}
	
	public function getState() {
		return $this->State;
	}
	
	public function getAddTime() {
		return $this->AddTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockedCityId($val) {
		$this->BlockedCityId =  $val;
	}
	
	public function setCity($val) {
		$this->City =  $val;
	}
	
	public function setState($val) {
		$this->State =  $val;
	}
	
	public function setAddTime($val) {
		$this->AddTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockedCity() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockedCity ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockedCityById($BlockedCityId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockedCity WHERE BlockedCityId='$BlockedCityId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockedCity() {
		
		$SQL = "INSERT INTO BlockedCity 
					(
					`City`,
					`State`,
					`AddTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->City',
					'$this->State',
					'$this->AddTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockedCity() {
		
		$SQL = "UPDATE BlockedCity SET
	
					`City`='$this->City',
					`State`='$this->State',
					`AddTime`='$this->AddTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockedCityId='$this->BlockedCityId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockedCity() {
		
		$SQL = "DELETE FROM 
					BlockedCity
				WHERE
					CustomerId='$this->BlockedCityId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
