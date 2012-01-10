<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        EmailTemplateService
* GENERATION DATE:  02.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/EmailTemplateService.php
* FOR MYSQL TABLE:  EmailTemplate
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class EmailTemplateService extends BaseFactoryService { // class : begin

	var $EmailTemplateId;   // (KEY Attribute)
	var $TemplateName;   // (Normal Attribute)
	var $FromEmail;   // (Normal Attribute)
	var $ToEmail;   // (Normal Attribute)
	var $EmailSubject;   // (Normal Attribute)
	var $EmailMessage;   // (Normal Attribute)
	var $Additional_Headers;   // (Normal Attribute)
	var $TemplateTypeId;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getEmailTemplateId() {
		return $this->EmailTemplateId;
	}
	
	public function getTemplateName() {
		return $this->TemplateName;
	}
	
	public function getFromEmail() {
		return $this->FromEmail;
	}
	
	public function getToEmail() {
		return $this->ToEmail;
	}
	
	public function getEmailSubject() {
		return $this->EmailSubject;
	}
	
	public function getEmailMessage() {
		return $this->EmailMessage;
	}
	
	public function getAdditional_Headers() {
		return $this->Additional_Headers;
	}
	
	public function getTemplateTypeId() {
		return $this->TemplateTypeId;
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
	
	public function setEmailTemplateId($val) {
		$this->EmailTemplateId =  $val;
	}
	
	public function setTemplateName($val) {
		$this->TemplateName =  $val;
	}
	
	public function setFromEmail($val) {
		$this->FromEmail =  $val;
	}
	
	public function setToEmail($val) {
		$this->ToEmail =  $val;
	}
	
	public function setEmailSubject($val) {
		$this->EmailSubject =  $val;
	}
	
	public function setEmailMessage($val) {
		$this->EmailMessage =  $val;
	}
	
	public function setAdditional_Headers($val) {
		$this->Additional_Headers =  $val;
	}
	
	public function setTemplateTypeId($val) {
		$this->TemplateTypeId =  $val;
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
	
	function SelectAllEmailTemplate() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM EmailTemplate ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectEmailTemplateById($EmailTemplateId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM EmailTemplate WHERE EmailTemplateId='$EmailTemplateId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertEmailTemplate() {
		
		$SQL = "INSERT INTO EmailTemplate 
					(
					`TemplateName`,
					`FromEmail`,
					`ToEmail`,
					`EmailSubject`,
					`EmailMessage`,
					`Additional_Headers`,
					`TemplateTypeId`,
					`Status`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->TemplateName',
					'$this->FromEmail',
					'$this->ToEmail',
					'$this->EmailSubject',
					'$this->EmailMessage',
					'$this->Additional_Headers',
					'$this->TemplateTypeId',
					'$this->Status',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateEmailTemplate() {
		
		$SQL = "UPDATE EmailTemplate SET
	
					`TemplateName`='$this->TemplateName',
					`FromEmail`='$this->FromEmail',
					`ToEmail`='$this->ToEmail',
					`EmailSubject`='$this->EmailSubject',
					`EmailMessage`='$this->EmailMessage',
					`Additional_Headers`='$this->Additional_Headers',
					`TemplateTypeId`='$this->TemplateTypeId',
					`Status`='$this->Status',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					EmailTemplateId='$this->EmailTemplateId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteEmailTemplate() {
		
		$SQL = "DELETE FROM 
					EmailTemplate
				WHERE
					EmailTemplateId='$this->EmailTemplateId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
