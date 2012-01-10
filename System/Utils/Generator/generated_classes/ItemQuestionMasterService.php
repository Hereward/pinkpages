<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ItemQuestionMasterService
* GENERATION DATE:  29.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ItemQuestionMasterService.php
* FOR MYSQL TABLE:  ItemQuestionMaster
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ItemQuestionMasterService extends BaseFactoryService { // class : begin

	var $QuestionId;   // (KEY Attribute)
	var $Status;   // (Normal Attribute)
	var $QuestionGroupId;   // (Normal Attribute)
	var $Sort;   // (Normal Attribute)
	var $QuestionTypeId;   // (Normal Attribute)
	var $Question;   // (Normal Attribute)
	var $XMLType;   // (Normal Attribute)
	var $XMLName;   // (Normal Attribute)

	public function getQuestionId() {
		return $this->QuestionId;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getQuestionGroupId() {
		return $this->QuestionGroupId;
	}
	
	public function getSort() {
		return $this->Sort;
	}
	
	public function getQuestionTypeId() {
		return $this->QuestionTypeId;
	}
	
	public function getQuestion() {
		return $this->Question;
	}
	
	public function getXMLType() {
		return $this->XMLType;
	}
	
	public function getXMLName() {
		return $this->XMLName;
	}
	
	public function setQuestionId($val) {
		$this->QuestionId =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setQuestionGroupId($val) {
		$this->QuestionGroupId =  $val;
	}
	
	public function setSort($val) {
		$this->Sort =  $val;
	}
	
	public function setQuestionTypeId($val) {
		$this->QuestionTypeId =  $val;
	}
	
	public function setQuestion($val) {
		$this->Question =  $val;
	}
	
	public function setXMLType($val) {
		$this->XMLType =  $val;
	}
	
	public function setXMLName($val) {
		$this->XMLName =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllItemQuestionMaster() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ItemQuestionMaster ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectItemQuestionMasterById($QuestionId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ItemQuestionMaster WHERE QuestionId='$QuestionId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertItemQuestionMaster() {
		
		$SQL = "INSERT INTO ItemQuestionMaster 
					(
					`Status`,
					`QuestionGroupId`,
					`Sort`,
					`QuestionTypeId`,
					`Question`,
					`XMLType`,
					`XMLName`
					)
				VALUES
					(
					'$this->Status',
					'$this->QuestionGroupId',
					'$this->Sort',
					'$this->QuestionTypeId',
					'$this->Question',
					'$this->XMLType',
					'$this->XMLName'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateItemQuestionMaster() {
		
		$SQL = "UPDATE ItemQuestionMaster SET
	
					`Status`='$this->Status',
					`QuestionGroupId`='$this->QuestionGroupId',
					`Sort`='$this->Sort',
					`QuestionTypeId`='$this->QuestionTypeId',
					`Question`='$this->Question',
					`XMLType`='$this->XMLType',
					`XMLName`='$this->XMLName'
				WHERE
					QuestionId='$this->QuestionId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteItemQuestionMaster() {
		
		$SQL = "DELETE FROM 
					ItemQuestionMaster
				WHERE
					QuestionId='$this->QuestionId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
