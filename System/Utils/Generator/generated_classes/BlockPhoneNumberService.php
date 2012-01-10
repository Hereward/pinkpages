<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockPhoneNumberService
* GENERATION DATE:  20.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockPhoneNumberService.php
* FOR MYSQL TABLE:  BlockPhoneNumber
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class BlockPhoneNumberService extends BaseFactoryService { // class : begin

	var $BlockPhoneNumberId;   // (KEY Attribute)
	var $PhoneNumber;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockPhoneNumberId() {
		return $this->BlockPhoneNumberId;
	}
	
	public function getPhoneNumber() {
		return $this->PhoneNumber;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockPhoneNumberId($val) {
		$this->BlockPhoneNumberId =  $val;
	}
	
	public function setPhoneNumber($val) {
		$this->PhoneNumber =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockPhoneNumber() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockPhoneNumber ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockPhoneNumberById($BlockPhoneNumberId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockPhoneNumber WHERE BlockPhoneNumberId='$BlockPhoneNumberId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockPhoneNumber() {
		
		$SQL = "INSERT INTO BlockPhoneNumber 
					(
					`PhoneNumber`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->PhoneNumber',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockPhoneNumber() {
		
		$SQL = "UPDATE BlockPhoneNumber SET
	
					`PhoneNumber`='$this->PhoneNumber',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockPhoneNumberId='$this->BlockPhoneNumberId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockPhoneNumber() {
		
		$SQL = "DELETE FROM 
					BlockPhoneNumber
				WHERE
					BlockPhoneNumberId='$this->BlockPhoneNumberId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
