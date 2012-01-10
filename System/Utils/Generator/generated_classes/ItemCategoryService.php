<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ItemCategoryService
* GENERATION DATE:  12.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ItemCategoryService.php
* FOR MYSQL TABLE:  ItemCategory
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class ItemCategoryService extends BaseFactoryService { // class : begin

	var $ItemCategoryId;   // (KEY Attribute)
	var $CategoryName;   // (Normal Attribute)
	var $Description;   // (Normal Attribute)
	var $SortOrder;   // (Normal Attribute)
	var $ParentCategoryId;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)

	public function getItemCategoryId() {
		return $this->ItemCategoryId;
	}
	
	public function getCategoryName() {
		return $this->CategoryName;
	}
	
	public function getDescription() {
		return $this->Description;
	}
	
	public function getSortOrder() {
		return $this->SortOrder;
	}
	
	public function getParentCategoryId() {
		return $this->ParentCategoryId;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function setItemCategoryId($val) {
		$this->ItemCategoryId =  $val;
	}
	
	public function setCategoryName($val) {
		$this->CategoryName =  $val;
	}
	
	public function setDescription($val) {
		$this->Description =  $val;
	}
	
	public function setSortOrder($val) {
		$this->SortOrder =  $val;
	}
	
	public function setParentCategoryId($val) {
		$this->ParentCategoryId =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllItemCategory() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ItemCategory ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectItemCategoryById($ItemCategoryId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ItemCategory WHERE ItemCategoryId='$ItemCategoryId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertItemCategory() {
		
		$SQL = "INSERT INTO ItemCategory 
					(
					`CategoryName`,
					`Description`,
					`SortOrder`,
					`ParentCategoryId`,
					`Status`
					)
				VALUES
					(
					'$this->CategoryName',
					'$this->Description',
					'$this->SortOrder',
					'$this->ParentCategoryId',
					'$this->Status'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateItemCategory() {
		
		$SQL = "UPDATE ItemCategory SET
	
					`CategoryName`='$this->CategoryName',
					`Description`='$this->Description',
					`SortOrder`='$this->SortOrder',
					`ParentCategoryId`='$this->ParentCategoryId',
					`Status`='$this->Status'
				WHERE
					ItemCategoryId='$this->ItemCategoryId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteItemCategory() {
		
		$SQL = "DELETE FROM 
					ItemCategory
				WHERE
					CustomerId='$this->ItemCategoryId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
