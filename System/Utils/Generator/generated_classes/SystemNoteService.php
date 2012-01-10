<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        SystemNoteService
* GENERATION DATE:  04.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/SystemNoteService.php
* FOR MYSQL TABLE:  SystemNote
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class SystemNoteService extends BaseFactoryService { // class : begin

	var $SystemNoteId;   // (KEY Attribute)
	var $Title;   // (Normal Attribute)
	var $NoteText;   // (Normal Attribute)
	var $Administrator;   // (Normal Attribute)
	var $CustomerService;   // (Normal Attribute)
	var $QAUser;   // (Normal Attribute)
	var $WarehouseUser;   // (Normal Attribute)
	var $Retailer;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getSystemNoteId() {
		return $this->SystemNoteId;
	}
	
	public function getTitle() {
		return $this->Title;
	}
	
	public function getNoteText() {
		return $this->NoteText;
	}
	
	public function getAdministrator() {
		return $this->Administrator;
	}
	
	public function getCustomerService() {
		return $this->CustomerService;
	}
	
	public function getQAUser() {
		return $this->QAUser;
	}
	
	public function getWarehouseUser() {
		return $this->WarehouseUser;
	}
	
	public function getRetailer() {
		return $this->Retailer;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setSystemNoteId($val) {
		$this->SystemNoteId =  $val;
	}
	
	public function setTitle($val) {
		$this->Title =  $val;
	}
	
	public function setNoteText($val) {
		$this->NoteText =  $val;
	}
	
	public function setAdministrator($val) {
		$this->Administrator =  $val;
	}
	
	public function setCustomerService($val) {
		$this->CustomerService =  $val;
	}
	
	public function setQAUser($val) {
		$this->QAUser =  $val;
	}
	
	public function setWarehouseUser($val) {
		$this->WarehouseUser =  $val;
	}
	
	public function setRetailer($val) {
		$this->Retailer =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllSystemNote() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM SystemNote ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectSystemNoteById($SystemNoteId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM SystemNote WHERE SystemNoteId='$SystemNoteId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertSystemNote() {
		
		$SQL = "INSERT INTO SystemNote 
					(
					`Title`,
					`NoteText`,
					`Administrator`,
					`CustomerService`,
					`QAUser`,
					`WarehouseUser`,
					`Retailer`,
					`Status`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->Title',
					'$this->NoteText',
					'$this->Administrator',
					'$this->CustomerService',
					'$this->QAUser',
					'$this->WarehouseUser',
					'$this->Retailer',
					'$this->Status',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateSystemNote() {
		
		$SQL = "UPDATE SystemNote SET
	
					`Title`='$this->Title',
					`NoteText`='$this->NoteText',
					`Administrator`='$this->Administrator',
					`CustomerService`='$this->CustomerService',
					`QAUser`='$this->QAUser',
					`WarehouseUser`='$this->WarehouseUser',
					`Retailer`='$this->Retailer',
					`Status`='$this->Status',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					SystemNoteId='$this->SystemNoteId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteSystemNote() {
		
		$SQL = "DELETE FROM 
					SystemNote
				WHERE
					SystemNoteId='$this->SystemNoteId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
