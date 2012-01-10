<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        TemplateTextService
* GENERATION DATE:  11.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/TemplateTextService.php
* FOR MYSQL TABLE:  TemplateText
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class TemplateTextService extends BaseFactoryService { // class : begin

	var $TemplateText;   // (KEY Attribute)
	var $Group;   // (Normal Attribute)
	var $Template;   // (Normal Attribute)
	var $Title;   // (Normal Attribute)
	var $Text;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getTemplateText() {
		return $this->TemplateText;
	}
	
	public function getGroup() {
		return $this->Group;
	}
	
	public function getTemplate() {
		return $this->Template;
	}
	
	public function getTitle() {
		return $this->Title;
	}
	
	public function getText() {
		return $this->Text;
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
	
	public function setTemplateText($val) {
		$this->TemplateText =  $val;
	}
	
	public function setGroup($val) {
		$this->Group =  $val;
	}
	
	public function setTemplate($val) {
		$this->Template =  $val;
	}
	
	public function setTitle($val) {
		$this->Title =  $val;
	}
	
	public function setText($val) {
		$this->Text =  $val;
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
	
	function SelectAllTemplateText() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM TemplateText ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectTemplateTextById($TemplateText) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM TemplateText WHERE TemplateText='$TemplateText'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertTemplateText() {
		
		$SQL = "INSERT INTO TemplateText 
					(
					`Group`,
					`Template`,
					`Title`,
					`Text`,
					`Status`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->Group',
					'$this->Template',
					'$this->Title',
					'$this->Text',
					'$this->Status',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateTemplateText() {
		
		$SQL = "UPDATE TemplateText SET
	
					`Group`='$this->Group',
					`Template`='$this->Template',
					`Title`='$this->Title',
					`Text`='$this->Text',
					`Status`='$this->Status',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					TemplateText='$this->TemplateText'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteTemplateText() {
		
		$SQL = "DELETE FROM 
					TemplateText
				WHERE
					TemplateText='$this->TemplateText'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
