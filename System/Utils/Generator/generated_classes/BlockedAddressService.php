<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockedAddressService
* GENERATION DATE:  18.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockedAddressService.php
* FOR MYSQL TABLE:  BlockedAddress
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class BlockedAddressService extends BaseFactoryService { // class : begin

	var $BlockedAddressId;   // (KEY Attribute)
	var $Address;   // (Normal Attribute)
	var $City;   // (Normal Attribute)
	var $State;   // (Normal Attribute)
	var $Zip;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockedAddressId() {
		return $this->BlockedAddressId;
	}
	
	public function getAddress() {
		return $this->Address;
	}
	
	public function getCity() {
		return $this->City;
	}
	
	public function getState() {
		return $this->State;
	}
	
	public function getZip() {
		return $this->Zip;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockedAddressId($val) {
		$this->BlockedAddressId =  $val;
	}
	
	public function setAddress($val) {
		$this->Address =  $val;
	}
	
	public function setCity($val) {
		$this->City =  $val;
	}
	
	public function setState($val) {
		$this->State =  $val;
	}
	
	public function setZip($val) {
		$this->Zip =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockedAddress() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockedAddress ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockedAddressById($BlockedAddressId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockedAddress WHERE BlockedAddressId='$BlockedAddressId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockedAddress() {
		
		$SQL = "INSERT INTO BlockedAddress 
					(
					`Address`,
					`City`,
					`State`,
					`Zip`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->Address',
					'$this->City',
					'$this->State',
					'$this->Zip',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockedAddress() {
		
		$SQL = "UPDATE BlockedAddress SET
	
					`Address`='$this->Address',
					`City`='$this->City',
					`State`='$this->State',
					`Zip`='$this->Zip',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockedAddressId='$this->BlockedAddressId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockedAddress() {
		
		$SQL = "DELETE FROM 
					BlockedAddress
				WHERE
					BlockedAddressId='$this->BlockedAddressId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
