<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        OrderItemService
* GENERATION DATE:  14.05.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/OrderItemService.php
* FOR MYSQL TABLE:  OrderItem
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class OrderItemService extends BaseFactoryService { // class : begin

	var $OrderItemId;   // (KEY Attribute)
	var $OrderId;   // (Normal Attribute)
	var $CustomerId;   // (Normal Attribute)
	var $ItemCode;   // (Normal Attribute)
	var $Qty;   // (Normal Attribute)
	var $ItemName;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $RetailerId;   // (Normal Attribute)
	var $AllAnswersText;   // (Normal Attribute)
	var $UnitPrice;   // (Normal Attribute)
	var $TotalPrice;   // (Normal Attribute)
	var $Birthday;   // (Normal Attribute)
	var $BirthMonth;   // (Normal Attribute)
	var $BirthYear;   // (Normal Attribute)
	var $Gender;   // (Normal Attribute)
	var $Height;   // (Normal Attribute)
	var $Weight;   // (Normal Attribute)
	var $BMI;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getOrderItemId() {
		return $this->OrderItemId;
	}
	
	public function getOrderId() {
		return $this->OrderId;
	}
	
	public function getCustomerId() {
		return $this->CustomerId;
	}
	
	public function getItemCode() {
		return $this->ItemCode;
	}
	
	public function getQty() {
		return $this->Qty;
	}
	
	public function getItemName() {
		return $this->ItemName;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getRetailerId() {
		return $this->RetailerId;
	}
	
	public function getAllAnswersText() {
		return $this->AllAnswersText;
	}
	
	public function getUnitPrice() {
		return $this->UnitPrice;
	}
	
	public function getTotalPrice() {
		return $this->TotalPrice;
	}
	
	public function getBirthday() {
		return $this->Birthday;
	}
	
	public function getBirthMonth() {
		return $this->BirthMonth;
	}
	
	public function getBirthYear() {
		return $this->BirthYear;
	}
	
	public function getGender() {
		return $this->Gender;
	}
	
	public function getHeight() {
		return $this->Height;
	}
	
	public function getWeight() {
		return $this->Weight;
	}
	
	public function getBMI() {
		return $this->BMI;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setOrderItemId($val) {
		$this->OrderItemId =  $val;
	}
	
	public function setOrderId($val) {
		$this->OrderId =  $val;
	}
	
	public function setCustomerId($val) {
		$this->CustomerId =  $val;
	}
	
	public function setItemCode($val) {
		$this->ItemCode =  $val;
	}
	
	public function setQty($val) {
		$this->Qty =  $val;
	}
	
	public function setItemName($val) {
		$this->ItemName =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setRetailerId($val) {
		$this->RetailerId =  $val;
	}
	
	public function setAllAnswersText($val) {
		$this->AllAnswersText =  $val;
	}
	
	public function setUnitPrice($val) {
		$this->UnitPrice =  $val;
	}
	
	public function setTotalPrice($val) {
		$this->TotalPrice =  $val;
	}
	
	public function setBirthday($val) {
		$this->Birthday =  $val;
	}
	
	public function setBirthMonth($val) {
		$this->BirthMonth =  $val;
	}
	
	public function setBirthYear($val) {
		$this->BirthYear =  $val;
	}
	
	public function setGender($val) {
		$this->Gender =  $val;
	}
	
	public function setHeight($val) {
		$this->Height =  $val;
	}
	
	public function setWeight($val) {
		$this->Weight =  $val;
	}
	
	public function setBMI($val) {
		$this->BMI =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllOrderItem() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM OrderItem ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectOrderItemById($OrderItemId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM OrderItem WHERE OrderItemId='$OrderItemId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertOrderItem() {
		
		$SQL = "INSERT INTO OrderItem 
					(
					`OrderId`,
					`CustomerId`,
					`ItemCode`,
					`Qty`,
					`ItemName`,
					`Status`,
					`RetailerId`,
					`AllAnswersText`,
					`UnitPrice`,
					`TotalPrice`,
					`Birthday`,
					`BirthMonth`,
					`BirthYear`,
					`Gender`,
					`Height`,
					`Weight`,
					`BMI`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->OrderId',
					'$this->CustomerId',
					'$this->ItemCode',
					'$this->Qty',
					'$this->ItemName',
					'$this->Status',
					'$this->RetailerId',
					'$this->AllAnswersText',
					'$this->UnitPrice',
					'$this->TotalPrice',
					'$this->Birthday',
					'$this->BirthMonth',
					'$this->BirthYear',
					'$this->Gender',
					'$this->Height',
					'$this->Weight',
					'$this->BMI',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateOrderItem() {
		
		$SQL = "UPDATE OrderItem SET
	
					`OrderId`='$this->OrderId',
					`CustomerId`='$this->CustomerId',
					`ItemCode`='$this->ItemCode',
					`Qty`='$this->Qty',
					`ItemName`='$this->ItemName',
					`Status`='$this->Status',
					`RetailerId`='$this->RetailerId',
					`AllAnswersText`='$this->AllAnswersText',
					`UnitPrice`='$this->UnitPrice',
					`TotalPrice`='$this->TotalPrice',
					`Birthday`='$this->Birthday',
					`BirthMonth`='$this->BirthMonth',
					`BirthYear`='$this->BirthYear',
					`Gender`='$this->Gender',
					`Height`='$this->Height',
					`Weight`='$this->Weight',
					`BMI`='$this->BMI',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					OrderItemId='$this->OrderItemId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteOrderItem() {
		
		$SQL = "DELETE FROM 
					OrderItem
				WHERE
					OrderItemId='$this->OrderItemId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
