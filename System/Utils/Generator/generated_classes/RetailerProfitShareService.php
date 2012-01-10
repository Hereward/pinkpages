<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        RetailerProfitShareService
* GENERATION DATE:  15.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/RetailerProfitShareService.php
* FOR MYSQL TABLE:  RetailerProfitShare
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class RetailerProfitShareService extends BaseFactoryService { // class : begin

	var $RetailerProfitShareId;   // (KEY Attribute)
	var $ProfitShare;   // (Normal Attribute)
	var $FillCost;   // (Normal Attribute)
	var $ProcessingFee;   // (Normal Attribute)
	var $OrderBounty;   // (Normal Attribute)
	var $SalesComm;   // (Normal Attribute)
	var $BasedOn;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)
	var $UpdatedBy;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $CreatedBy;   // (Normal Attribute)

	public function getRetailerProfitShareId() {
		return $this->RetailerProfitShareId;
	}
	
	public function getProfitShare() {
		return $this->ProfitShare;
	}
	
	public function getFillCost() {
		return $this->FillCost;
	}
	
	public function getProcessingFee() {
		return $this->ProcessingFee;
	}
	
	public function getOrderBounty() {
		return $this->OrderBounty;
	}
	
	public function getSalesComm() {
		return $this->SalesComm;
	}
	
	public function getBasedOn() {
		return $this->BasedOn;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function getUpdatedBy() {
		return $this->UpdatedBy;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getCreatedBy() {
		return $this->CreatedBy;
	}
	
	public function setRetailerProfitShareId($val) {
		$this->RetailerProfitShareId =  $val;
	}
	
	public function setProfitShare($val) {
		$this->ProfitShare =  $val;
	}
	
	public function setFillCost($val) {
		$this->FillCost =  $val;
	}
	
	public function setProcessingFee($val) {
		$this->ProcessingFee =  $val;
	}
	
	public function setOrderBounty($val) {
		$this->OrderBounty =  $val;
	}
	
	public function setSalesComm($val) {
		$this->SalesComm =  $val;
	}
	
	public function setBasedOn($val) {
		$this->BasedOn =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function setUpdatedBy($val) {
		$this->UpdatedBy =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setCreatedBy($val) {
		$this->CreatedBy =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllRetailerProfitShare() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM RetailerProfitShare ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectRetailerProfitShareById($RetailerProfitShareId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM RetailerProfitShare WHERE RetailerProfitShareId='$RetailerProfitShareId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertRetailerProfitShare() {
		
		$SQL = "INSERT INTO RetailerProfitShare 
					(
					`ProfitShare`,
					`FillCost`,
					`ProcessingFee`,
					`OrderBounty`,
					`SalesComm`,
					`BasedOn`,
					`UpdateTime`,
					`UpdatedBy`,
					`InsertTime`,
					`CreatedBy`
					)
				VALUES
					(
					'$this->ProfitShare',
					'$this->FillCost',
					'$this->ProcessingFee',
					'$this->OrderBounty',
					'$this->SalesComm',
					'$this->BasedOn',
					'$this->UpdateTime',
					'$this->UpdatedBy',
					'$this->InsertTime',
					'$this->CreatedBy'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateRetailerProfitShare() {
		
		$SQL = "UPDATE RetailerProfitShare SET
	
					`ProfitShare`='$this->ProfitShare',
					`FillCost`='$this->FillCost',
					`ProcessingFee`='$this->ProcessingFee',
					`OrderBounty`='$this->OrderBounty',
					`SalesComm`='$this->SalesComm',
					`BasedOn`='$this->BasedOn',
					`UpdateTime`='$this->UpdateTime',
					`UpdatedBy`='$this->UpdatedBy',
					`InsertTime`='$this->InsertTime',
					`CreatedBy`='$this->CreatedBy'
				WHERE
					RetailerProfitShareId='$this->RetailerProfitShareId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteRetailerProfitShare() {
		
		$SQL = "DELETE FROM 
					RetailerProfitShare
				WHERE
					CustomerId='$this->RetailerProfitShareId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
