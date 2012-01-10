<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        OrderStatusEmailService
* GENERATION DATE:  13.05.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/OrderStatusEmailService.php
* FOR MYSQL TABLE:  OrderStatusEmail
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class OrderStatusEmailService extends BaseFactoryService { // class : begin

	var $OrderStatusEmailId;   // (KEY Attribute)
	var $OrderStatusId;   // (Normal Attribute)
	var $ItemIds;   // (Normal Attribute)
	var $SendSystemEmail;   // (Normal Attribute)
	var $EmailSubject;   // (Normal Attribute)
	var $Email Message;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)

	public function getOrderStatusEmailId() {
		return $this->OrderStatusEmailId;
	}
	
	public function getOrderStatusId() {
		return $this->OrderStatusId;
	}
	
	public function getItemIds() {
		return $this->ItemIds;
	}
	
	public function getSendSystemEmail() {
		return $this->SendSystemEmail;
	}
	
	public function getEmailSubject() {
		return $this->EmailSubject;
	}
	
	public function getEmail Message() {
		return $this->Email Message;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function setOrderStatusEmailId($val) {
		$this->OrderStatusEmailId =  $val;
	}
	
	public function setOrderStatusId($val) {
		$this->OrderStatusId =  $val;
	}
	
	public function setItemIds($val) {
		$this->ItemIds =  $val;
	}
	
	public function setSendSystemEmail($val) {
		$this->SendSystemEmail =  $val;
	}
	
	public function setEmailSubject($val) {
		$this->EmailSubject =  $val;
	}
	
	public function setEmail Message($val) {
		$this->Email Message =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllOrderStatusEmail() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM OrderStatusEmail ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectOrderStatusEmailById($OrderStatusEmailId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM OrderStatusEmail WHERE OrderStatusEmailId='$OrderStatusEmailId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertOrderStatusEmail() {
		
		$SQL = "INSERT INTO OrderStatusEmail 
					(
					`OrderStatusId`,
					`ItemIds`,
					`SendSystemEmail`,
					`EmailSubject`,
					`Email Message`,
					`Status`
					)
				VALUES
					(
					'$this->OrderStatusId',
					'$this->ItemIds',
					'$this->SendSystemEmail',
					'$this->EmailSubject',
					'$this->Email Message',
					'$this->Status'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateOrderStatusEmail() {
		
		$SQL = "UPDATE OrderStatusEmail SET
	
					`OrderStatusId`='$this->OrderStatusId',
					`ItemIds`='$this->ItemIds',
					`SendSystemEmail`='$this->SendSystemEmail',
					`EmailSubject`='$this->EmailSubject',
					`Email Message`='$this->Email Message',
					`Status`='$this->Status'
				WHERE
					OrderStatusEmailId='$this->OrderStatusEmailId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteOrderStatusEmail() {
		
		$SQL = "DELETE FROM 
					OrderStatusEmail
				WHERE
					OrderStatusEmailId='$this->OrderStatusEmailId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
