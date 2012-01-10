<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockCustomerService
* GENERATION DATE:  20.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockCustomerService.php
* FOR MYSQL TABLE:  BlockCustomer
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class BlockCustomerService extends BaseFactoryService { // class : begin

	var $BlockedCustomerId;   // (KEY Attribute)
	var $FisrtName;   // (Normal Attribute)
	var $LastName;   // (Normal Attribute)
	var $Zip;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
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
	
	public function getInsertTime() {
		return $this->InsertTime;
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
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockCustomer() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockCustomer ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockCustomerById($BlockedCustomerId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockCustomer WHERE BlockedCustomerId='$BlockedCustomerId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockCustomer() {
		
		$SQL = "INSERT INTO BlockCustomer 
					(
					`FisrtName`,
					`LastName`,
					`Zip`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->FisrtName',
					'$this->LastName',
					'$this->Zip',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockCustomer() {
		
		$SQL = "UPDATE BlockCustomer SET
	
					`FisrtName`='$this->FisrtName',
					`LastName`='$this->LastName',
					`Zip`='$this->Zip',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockedCustomerId='$this->BlockedCustomerId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockCustomer() {
		
		$SQL = "DELETE FROM 
					BlockCustomer
				WHERE
					BlockedCustomerId='$this->BlockedCustomerId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
