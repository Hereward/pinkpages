<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ItemCategoryTreeService
* GENERATION DATE:  01.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ItemCategoryTreeService.php
* FOR MYSQL TABLE:  ItemCategoryTree
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ItemCategoryTreeService extends BaseFactoryService { // class : begin

	var $ItemCategoryTreeId;   // (KEY Attribute)
	var $Name;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)

	public function getItemCategoryTreeId() {
		return $this->ItemCategoryTreeId;
	}
	
	public function getName() {
		return $this->Name;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function setItemCategoryTreeId($val) {
		$this->ItemCategoryTreeId =  $val;
	}
	
	public function setName($val) {
		$this->Name =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllItemCategoryTree() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ItemCategoryTree ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectItemCategoryTreeById($ItemCategoryTreeId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ItemCategoryTree WHERE ItemCategoryTreeId='$ItemCategoryTreeId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertItemCategoryTree() {
		
		$SQL = "INSERT INTO ItemCategoryTree 
					(
					`Name`,
					`Status`
					)
				VALUES
					(
					'$this->Name',
					'$this->Status'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateItemCategoryTree() {
		
		$SQL = "UPDATE ItemCategoryTree SET
	
					`Name`='$this->Name',
					`Status`='$this->Status'
				WHERE
					ItemCategoryTreeId='$this->ItemCategoryTreeId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteItemCategoryTree() {
		
		$SQL = "DELETE FROM 
					ItemCategoryTree
				WHERE
					ItemCategoryTreeId='$this->ItemCategoryTreeId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
