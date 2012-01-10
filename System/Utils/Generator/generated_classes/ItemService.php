<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ItemService
* GENERATION DATE:  13.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ItemService.php
* FOR MYSQL TABLE:  Item
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class ItemService extends BaseFactoryService { // class : begin

	var $ItemId;   // (KEY Attribute)
	var $ItemName;   // (Normal Attribute)
	var $RetailPrice;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $PartName;   // (Normal Attribute)
	var $PartType;   // (Normal Attribute)
	var $PartCount;   // (Normal Attribute)
	var $Weight;   // (Normal Attribute)
	var $WeightUnit;   // (Normal Attribute)
	var $RetailerCost;   // (Normal Attribute)
	var $WarehouseCost;   // (Normal Attribute)
	var $MinRetailPrice;   // (Normal Attribute)
	var $MaxRetailPrice;   // (Normal Attribute)
	var $ReorderReminder;   // (Normal Attribute)
	var $ReorderInterval;   // (Normal Attribute)
	var $ReorderGroupId;   // (Normal Attribute)
	var $ItemGroupId;   // (Normal Attribute)
	var $QuestionGroupId;   // (Normal Attribute)
	var $QACategoryId;   // (Normal Attribute)
	var $QAReviewalNeeded;   // (Normal Attribute)
	var $ItemSpecial;   // (Normal Attribute)
	var $EmailVerify;   // (Normal Attribute)
	var $ItemDownload;   // (Normal Attribute)
	var $ItemCommission;   // (Normal Attribute)
	var $Taxable;   // (Normal Attribute)
	var $ItemDescription;   // (Normal Attribute)
	var $ItemInfo;   // (Normal Attribute)
	var $ManufacturerNumber;   // (Normal Attribute)
	var $ManufacturerName;   // (Normal Attribute)
	var $UsageDirection;   // (Normal Attribute)
	var $Label1;   // (Normal Attribute)
	var $Label2;   // (Normal Attribute)
	var $Label3;   // (Normal Attribute)
	var $ItemInfoSheet;   // (Normal Attribute)
	var $AddTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getItemId() {
		return $this->ItemId;
	}
	
	public function getItemName() {
		return $this->ItemName;
	}
	
	public function getRetailPrice() {
		return $this->RetailPrice;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getPartName() {
		return $this->PartName;
	}
	
	public function getPartType() {
		return $this->PartType;
	}
	
	public function getPartCount() {
		return $this->PartCount;
	}
	
	public function getWeight() {
		return $this->Weight;
	}
	
	public function getWeightUnit() {
		return $this->WeightUnit;
	}
	
	public function getRetailerCost() {
		return $this->RetailerCost;
	}
	
	public function getWarehouseCost() {
		return $this->WarehouseCost;
	}
	
	public function getMinRetailPrice() {
		return $this->MinRetailPrice;
	}
	
	public function getMaxRetailPrice() {
		return $this->MaxRetailPrice;
	}
	
	public function getReorderReminder() {
		return $this->ReorderReminder;
	}
	
	public function getReorderInterval() {
		return $this->ReorderInterval;
	}
	
	public function getReorderGroupId() {
		return $this->ReorderGroupId;
	}
	
	public function getItemGroupId() {
		return $this->ItemGroupId;
	}
	
	public function getQuestionGroupId() {
		return $this->QuestionGroupId;
	}
	
	public function getQACategoryId() {
		return $this->QACategoryId;
	}
	
	public function getQAReviewalNeeded() {
		return $this->QAReviewalNeeded;
	}
	
	public function getItemSpecial() {
		return $this->ItemSpecial;
	}
	
	public function getEmailVerify() {
		return $this->EmailVerify;
	}
	
	public function getItemDownload() {
		return $this->ItemDownload;
	}
	
	public function getItemCommission() {
		return $this->ItemCommission;
	}
	
	public function getTaxable() {
		return $this->Taxable;
	}
	
	public function getItemDescription() {
		return $this->ItemDescription;
	}
	
	public function getItemInfo() {
		return $this->ItemInfo;
	}
	
	public function getManufacturerNumber() {
		return $this->ManufacturerNumber;
	}
	
	public function getManufacturerName() {
		return $this->ManufacturerName;
	}
	
	public function getUsageDirection() {
		return $this->UsageDirection;
	}
	
	public function getLabel1() {
		return $this->Label1;
	}
	
	public function getLabel2() {
		return $this->Label2;
	}
	
	public function getLabel3() {
		return $this->Label3;
	}
	
	public function getItemInfoSheet() {
		return $this->ItemInfoSheet;
	}
	
	public function getAddTime() {
		return $this->AddTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setItemId($val) {
		$this->ItemId =  $val;
	}
	
	public function setItemName($val) {
		$this->ItemName =  $val;
	}
	
	public function setRetailPrice($val) {
		$this->RetailPrice =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setPartName($val) {
		$this->PartName =  $val;
	}
	
	public function setPartType($val) {
		$this->PartType =  $val;
	}
	
	public function setPartCount($val) {
		$this->PartCount =  $val;
	}
	
	public function setWeight($val) {
		$this->Weight =  $val;
	}
	
	public function setWeightUnit($val) {
		$this->WeightUnit =  $val;
	}
	
	public function setRetailerCost($val) {
		$this->RetailerCost =  $val;
	}
	
	public function setWarehouseCost($val) {
		$this->WarehouseCost =  $val;
	}
	
	public function setMinRetailPrice($val) {
		$this->MinRetailPrice =  $val;
	}
	
	public function setMaxRetailPrice($val) {
		$this->MaxRetailPrice =  $val;
	}
	
	public function setReorderReminder($val) {
		$this->ReorderReminder =  $val;
	}
	
	public function setReorderInterval($val) {
		$this->ReorderInterval =  $val;
	}
	
	public function setReorderGroupId($val) {
		$this->ReorderGroupId =  $val;
	}
	
	public function setItemGroupId($val) {
		$this->ItemGroupId =  $val;
	}
	
	public function setQuestionGroupId($val) {
		$this->QuestionGroupId =  $val;
	}
	
	public function setQACategoryId($val) {
		$this->QACategoryId =  $val;
	}
	
	public function setQAReviewalNeeded($val) {
		$this->QAReviewalNeeded =  $val;
	}
	
	public function setItemSpecial($val) {
		$this->ItemSpecial =  $val;
	}
	
	public function setEmailVerify($val) {
		$this->EmailVerify =  $val;
	}
	
	public function setItemDownload($val) {
		$this->ItemDownload =  $val;
	}
	
	public function setItemCommission($val) {
		$this->ItemCommission =  $val;
	}
	
	public function setTaxable($val) {
		$this->Taxable =  $val;
	}
	
	public function setItemDescription($val) {
		$this->ItemDescription =  $val;
	}
	
	public function setItemInfo($val) {
		$this->ItemInfo =  $val;
	}
	
	public function setManufacturerNumber($val) {
		$this->ManufacturerNumber =  $val;
	}
	
	public function setManufacturerName($val) {
		$this->ManufacturerName =  $val;
	}
	
	public function setUsageDirection($val) {
		$this->UsageDirection =  $val;
	}
	
	public function setLabel1($val) {
		$this->Label1 =  $val;
	}
	
	public function setLabel2($val) {
		$this->Label2 =  $val;
	}
	
	public function setLabel3($val) {
		$this->Label3 =  $val;
	}
	
	public function setItemInfoSheet($val) {
		$this->ItemInfoSheet =  $val;
	}
	
	public function setAddTime($val) {
		$this->AddTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllItem() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM Item ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectItemById($ItemId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM Item WHERE ItemId='$ItemId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertItem() {
		
		$SQL = "INSERT INTO Item 
					(
					`ItemName`,
					`RetailPrice`,
					`Status`,
					`PartName`,
					`PartType`,
					`PartCount`,
					`Weight`,
					`WeightUnit`,
					`RetailerCost`,
					`WarehouseCost`,
					`MinRetailPrice`,
					`MaxRetailPrice`,
					`ReorderReminder`,
					`ReorderInterval`,
					`ReorderGroupId`,
					`ItemGroupId`,
					`QuestionGroupId`,
					`QACategoryId`,
					`QAReviewalNeeded`,
					`ItemSpecial`,
					`EmailVerify`,
					`ItemDownload`,
					`ItemCommission`,
					`Taxable`,
					`ItemDescription`,
					`ItemInfo`,
					`ManufacturerNumber`,
					`ManufacturerName`,
					`UsageDirection`,
					`Label1`,
					`Label2`,
					`Label3`,
					`ItemInfoSheet`,
					`AddTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->ItemName',
					'$this->RetailPrice',
					'$this->Status',
					'$this->PartName',
					'$this->PartType',
					'$this->PartCount',
					'$this->Weight',
					'$this->WeightUnit',
					'$this->RetailerCost',
					'$this->WarehouseCost',
					'$this->MinRetailPrice',
					'$this->MaxRetailPrice',
					'$this->ReorderReminder',
					'$this->ReorderInterval',
					'$this->ReorderGroupId',
					'$this->ItemGroupId',
					'$this->QuestionGroupId',
					'$this->QACategoryId',
					'$this->QAReviewalNeeded',
					'$this->ItemSpecial',
					'$this->EmailVerify',
					'$this->ItemDownload',
					'$this->ItemCommission',
					'$this->Taxable',
					'$this->ItemDescription',
					'$this->ItemInfo',
					'$this->ManufacturerNumber',
					'$this->ManufacturerName',
					'$this->UsageDirection',
					'$this->Label1',
					'$this->Label2',
					'$this->Label3',
					'$this->ItemInfoSheet',
					'$this->AddTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateItem() {
		
		$SQL = "UPDATE Item SET
	
					`ItemName`='$this->ItemName',
					`RetailPrice`='$this->RetailPrice',
					`Status`='$this->Status',
					`PartName`='$this->PartName',
					`PartType`='$this->PartType',
					`PartCount`='$this->PartCount',
					`Weight`='$this->Weight',
					`WeightUnit`='$this->WeightUnit',
					`RetailerCost`='$this->RetailerCost',
					`WarehouseCost`='$this->WarehouseCost',
					`MinRetailPrice`='$this->MinRetailPrice',
					`MaxRetailPrice`='$this->MaxRetailPrice',
					`ReorderReminder`='$this->ReorderReminder',
					`ReorderInterval`='$this->ReorderInterval',
					`ReorderGroupId`='$this->ReorderGroupId',
					`ItemGroupId`='$this->ItemGroupId',
					`QuestionGroupId`='$this->QuestionGroupId',
					`QACategoryId`='$this->QACategoryId',
					`QAReviewalNeeded`='$this->QAReviewalNeeded',
					`ItemSpecial`='$this->ItemSpecial',
					`EmailVerify`='$this->EmailVerify',
					`ItemDownload`='$this->ItemDownload',
					`ItemCommission`='$this->ItemCommission',
					`Taxable`='$this->Taxable',
					`ItemDescription`='$this->ItemDescription',
					`ItemInfo`='$this->ItemInfo',
					`ManufacturerNumber`='$this->ManufacturerNumber',
					`ManufacturerName`='$this->ManufacturerName',
					`UsageDirection`='$this->UsageDirection',
					`Label1`='$this->Label1',
					`Label2`='$this->Label2',
					`Label3`='$this->Label3',
					`ItemInfoSheet`='$this->ItemInfoSheet',
					`AddTime`='$this->AddTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					ItemId='$this->ItemId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteItem() {
		
		$SQL = "DELETE FROM 
					Item
				WHERE
					CustomerId='$this->ItemId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
