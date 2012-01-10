<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        TicketStatusService
* GENERATION DATE:  14.05.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/TicketStatusService.php
* FOR MYSQL TABLE:  TicketStatus
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class TicketStatusService extends BaseFactoryService { // class : begin

	var $TicketStatusId;   // (KEY Attribute)
	var $Position;   // (Normal Attribute)
	var $StatusCode;   // (Normal Attribute)
	var $StatusText;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getTicketStatusId() {
		return $this->TicketStatusId;
	}
	
	public function getPosition() {
		return $this->Position;
	}
	
	public function getStatusCode() {
		return $this->StatusCode;
	}
	
	public function getStatusText() {
		return $this->StatusText;
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
	
	public function setTicketStatusId($val) {
		$this->TicketStatusId =  $val;
	}
	
	public function setPosition($val) {
		$this->Position =  $val;
	}
	
	public function setStatusCode($val) {
		$this->StatusCode =  $val;
	}
	
	public function setStatusText($val) {
		$this->StatusText =  $val;
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
	
	function SelectAllTicketStatus() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM TicketStatus ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectTicketStatusById($TicketStatusId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM TicketStatus WHERE TicketStatusId='$TicketStatusId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertTicketStatus() {
		
		$SQL = "INSERT INTO TicketStatus 
					(
					`Position`,
					`StatusCode`,
					`StatusText`,
					`Status`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->Position',
					'$this->StatusCode',
					'$this->StatusText',
					'$this->Status',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateTicketStatus() {
		
		$SQL = "UPDATE TicketStatus SET
	
					`Position`='$this->Position',
					`StatusCode`='$this->StatusCode',
					`StatusText`='$this->StatusText',
					`Status`='$this->Status',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					TicketStatusId='$this->TicketStatusId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteTicketStatus() {
		
		$SQL = "DELETE FROM 
					TicketStatus
				WHERE
					TicketStatusId='$this->TicketStatusId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
