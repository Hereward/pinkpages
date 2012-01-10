<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ReorderEmailTemplateService
* GENERATION DATE:  13.05.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ReorderEmailTemplateService.php
* FOR MYSQL TABLE:  ReorderEmailTemplate
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ReorderEmailTemplateService extends BaseFactoryService { // class : begin

	var $ReorderEmailTemplateId;   // (KEY Attribute)
	var $Message;   // (Normal Attribute)
	var $Note;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getReorderEmailTemplateId() {
		return $this->ReorderEmailTemplateId;
	}
	
	public function getMessage() {
		return $this->Message;
	}
	
	public function getNote() {
		return $this->Note;
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
	
	public function setReorderEmailTemplateId($val) {
		$this->ReorderEmailTemplateId =  $val;
	}
	
	public function setMessage($val) {
		$this->Message =  $val;
	}
	
	public function setNote($val) {
		$this->Note =  $val;
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
	
	function SelectAllReorderEmailTemplate() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ReorderEmailTemplate ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectReorderEmailTemplateById($ReorderEmailTemplateId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ReorderEmailTemplate WHERE ReorderEmailTemplateId='$ReorderEmailTemplateId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertReorderEmailTemplate() {
		
		$SQL = "INSERT INTO ReorderEmailTemplate 
					(
					`Message`,
					`Note`,
					`Status`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->Message',
					'$this->Note',
					'$this->Status',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateReorderEmailTemplate() {
		
		$SQL = "UPDATE ReorderEmailTemplate SET
	
					`Message`='$this->Message',
					`Note`='$this->Note',
					`Status`='$this->Status',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					ReorderEmailTemplateId='$this->ReorderEmailTemplateId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteReorderEmailTemplate() {
		
		$SQL = "DELETE FROM 
					ReorderEmailTemplate
				WHERE
					ReorderEmailTemplateId='$this->ReorderEmailTemplateId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
