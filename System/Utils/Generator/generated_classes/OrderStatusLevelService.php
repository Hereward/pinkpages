<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        OrderStatusLevelService
* GENERATION DATE:  11.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/OrderStatusLevelService.php
* FOR MYSQL TABLE:  OrderStatusLevel
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class OrderStatusLevelService extends BaseFactoryService { // class : begin

	var $OrderStatusLevelId;   // (KEY Attribute)
	var $Position;   // (Normal Attribute)
	var $SYS;   // (Normal Attribute)
	var $StatusText;   // (Normal Attribute)
	var $Description;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $PayCommision;   // (Normal Attribute)
	var $Settle;   // (Normal Attribute)
	var $RetryFailedCC;   // (Normal Attribute)
	var $ReorderTooSoon;   // (Normal Attribute)
	var $CSToRunPayment;   // (Normal Attribute)
	var $CSToChange;   // (Normal Attribute)
	var $CSToList;   // (Normal Attribute)
	var $WHToChange;   // (Normal Attribute)
	var $WHToList;   // (Normal Attribute)
	var $QAToChange;   // (Normal Attribute)
	var $QAToList;   // (Normal Attribute)
	var $RTToList;   // (Normal Attribute)
	var $SendSystemEmail;   // (Normal Attribute)
	var $EmailSubject;   // (Normal Attribute)
	var $EmailMessage;   // (Normal Attribute)

	public function getOrderStatusLevelId() {
		return $this->OrderStatusLevelId;
	}
	
	public function getPosition() {
		return $this->Position;
	}
	
	public function getSYS() {
		return $this->SYS;
	}
	
	public function getStatusText() {
		return $this->StatusText;
	}
	
	public function getDescription() {
		return $this->Description;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getPayCommision() {
		return $this->PayCommision;
	}
	
	public function getSettle() {
		return $this->Settle;
	}
	
	public function getRetryFailedCC() {
		return $this->RetryFailedCC;
	}
	
	public function getReorderTooSoon() {
		return $this->ReorderTooSoon;
	}
	
	public function getCSToRunPayment() {
		return $this->CSToRunPayment;
	}
	
	public function getCSToChange() {
		return $this->CSToChange;
	}
	
	public function getCSToList() {
		return $this->CSToList;
	}
	
	public function getWHToChange() {
		return $this->WHToChange;
	}
	
	public function getWHToList() {
		return $this->WHToList;
	}
	
	public function getQAToChange() {
		return $this->QAToChange;
	}
	
	public function getQAToList() {
		return $this->QAToList;
	}
	
	public function getRTToList() {
		return $this->RTToList;
	}
	
	public function getSendSystemEmail() {
		return $this->SendSystemEmail;
	}
	
	public function getEmailSubject() {
		return $this->EmailSubject;
	}
	
	public function getEmailMessage() {
		return $this->EmailMessage;
	}
	
	public function setOrderStatusLevelId($val) {
		$this->OrderStatusLevelId =  $val;
	}
	
	public function setPosition($val) {
		$this->Position =  $val;
	}
	
	public function setSYS($val) {
		$this->SYS =  $val;
	}
	
	public function setStatusText($val) {
		$this->StatusText =  $val;
	}
	
	public function setDescription($val) {
		$this->Description =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setPayCommision($val) {
		$this->PayCommision =  $val;
	}
	
	public function setSettle($val) {
		$this->Settle =  $val;
	}
	
	public function setRetryFailedCC($val) {
		$this->RetryFailedCC =  $val;
	}
	
	public function setReorderTooSoon($val) {
		$this->ReorderTooSoon =  $val;
	}
	
	public function setCSToRunPayment($val) {
		$this->CSToRunPayment =  $val;
	}
	
	public function setCSToChange($val) {
		$this->CSToChange =  $val;
	}
	
	public function setCSToList($val) {
		$this->CSToList =  $val;
	}
	
	public function setWHToChange($val) {
		$this->WHToChange =  $val;
	}
	
	public function setWHToList($val) {
		$this->WHToList =  $val;
	}
	
	public function setQAToChange($val) {
		$this->QAToChange =  $val;
	}
	
	public function setQAToList($val) {
		$this->QAToList =  $val;
	}
	
	public function setRTToList($val) {
		$this->RTToList =  $val;
	}
	
	public function setSendSystemEmail($val) {
		$this->SendSystemEmail =  $val;
	}
	
	public function setEmailSubject($val) {
		$this->EmailSubject =  $val;
	}
	
	public function setEmailMessage($val) {
		$this->EmailMessage =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllOrderStatusLevel() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM OrderStatusLevel ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectOrderStatusLevelById($OrderStatusLevelId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM OrderStatusLevel WHERE OrderStatusLevelId='$OrderStatusLevelId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertOrderStatusLevel() {
		
		$SQL = "INSERT INTO OrderStatusLevel 
					(
					`Position`,
					`SYS`,
					`StatusText`,
					`Description`,
					`Status`,
					`PayCommision`,
					`Settle`,
					`RetryFailedCC`,
					`ReorderTooSoon`,
					`CSToRunPayment`,
					`CSToChange`,
					`CSToList`,
					`WHToChange`,
					`WHToList`,
					`QAToChange`,
					`QAToList`,
					`RTToList`,
					`SendSystemEmail`,
					`EmailSubject`,
					`EmailMessage`
					)
				VALUES
					(
					'$this->Position',
					'$this->SYS',
					'$this->StatusText',
					'$this->Description',
					'$this->Status',
					'$this->PayCommision',
					'$this->Settle',
					'$this->RetryFailedCC',
					'$this->ReorderTooSoon',
					'$this->CSToRunPayment',
					'$this->CSToChange',
					'$this->CSToList',
					'$this->WHToChange',
					'$this->WHToList',
					'$this->QAToChange',
					'$this->QAToList',
					'$this->RTToList',
					'$this->SendSystemEmail',
					'$this->EmailSubject',
					'$this->EmailMessage'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateOrderStatusLevel() {
		
		$SQL = "UPDATE OrderStatusLevel SET
	
					`Position`='$this->Position',
					`SYS`='$this->SYS',
					`StatusText`='$this->StatusText',
					`Description`='$this->Description',
					`Status`='$this->Status',
					`PayCommision`='$this->PayCommision',
					`Settle`='$this->Settle',
					`RetryFailedCC`='$this->RetryFailedCC',
					`ReorderTooSoon`='$this->ReorderTooSoon',
					`CSToRunPayment`='$this->CSToRunPayment',
					`CSToChange`='$this->CSToChange',
					`CSToList`='$this->CSToList',
					`WHToChange`='$this->WHToChange',
					`WHToList`='$this->WHToList',
					`QAToChange`='$this->QAToChange',
					`QAToList`='$this->QAToList',
					`RTToList`='$this->RTToList',
					`SendSystemEmail`='$this->SendSystemEmail',
					`EmailSubject`='$this->EmailSubject',
					`EmailMessage`='$this->EmailMessage'
				WHERE
					OrderStatusLevelId='$this->OrderStatusLevelId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteOrderStatusLevel() {
		
		$SQL = "DELETE FROM 
					OrderStatusLevel
				WHERE
					OrderStatusLevelId='$this->OrderStatusLevelId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
