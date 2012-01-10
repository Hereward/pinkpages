<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockedCustomerService
* GENERATION DATE:  12.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockedCustomerService.php
* FOR MYSQL TABLE:  BlockedCustomer
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class BlockedCustomerService extends BaseFactoryService { // class : begin

	var $BlockedCustomerId;   // (KEY Attribute)
	var $FisrtName;   // (Normal Attribute)
	var $LastName;   // (Normal Attribute)
	var $Zip;   // (Normal Attribute)
	var $AddTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockedCustomerId() {
		return $this->BlockedCustomerId;
	}
	
	public function getFisrtName() {
		return $this->FisrtName;
	}
	
	public function getLastName() {
		return $this->LastName;
	}
	
	public function getZip() {
		return $this->Zip;
	}
	
	public function getAddTime() {
		return $this->AddTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockedCustomerId($val) {
		$this->BlockedCustomerId =  $val;
	}
	
	public function setFisrtName($val) {
		$this->FisrtName =  $val;
	}
	
	public function setLastName($val) {
		$this->LastName =  $val;
	}
	
	public function setZip($val) {
		$this->Zip =  $val;
	}
	
	public function setAddTime($val) {
		$this->AddTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockedCustomer() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockedCustomer ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockedCustomerById($BlockedCustomerId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockedCustomer WHERE BlockedCustomerId='$BlockedCustomerId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockedCustomer() {
		
		$SQL = "INSERT INTO BlockedCustomer 
					(
					`FisrtName`,
					`LastName`,
					`Zip`,
					`AddTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->FisrtName',
					'$this->LastName',
					'$this->Zip',
					'$this->AddTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockedCustomer() {
		
		$SQL = "UPDATE BlockedCustomer SET
	
					`FisrtName`='$this->FisrtName',
					`LastName`='$this->LastName',
					`Zip`='$this->Zip',
					`AddTime`='$this->AddTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockedCustomerId='$this->BlockedCustomerId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockedCustomer() {
		
		$SQL = "DELETE FROM 
					BlockedCustomer
				WHERE
					CustomerId='$this->BlockedCustomerId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
