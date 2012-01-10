<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        MasterDataService
* GENERATION DATE:  15.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/MasterDataService.php
* FOR MYSQL TABLE:  MasterData
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class MasterDataService extends BaseFactoryService { // class : begin

	var $ItemId;   // (KEY Attribute)
	var $TableId;   // (Normal Attribute)
	var $ItemValue;   // (Normal Attribute)
	var $ItemText;   // (Normal Attribute)
	var $DisplayOrder;   // (Normal Attribute)
	var $ParentItemValue;   // (Normal Attribute)
	var $Flag;   // (Normal Attribute)
	var $CustomField1;   // (Normal Attribute)
	var $CustomField2;   // (Normal Attribute)
	var $CustomField3;   // (Normal Attribute)

	public function getItemId() {
		return $this->ItemId;
	}
	
	public function getTableId() {
		return $this->TableId;
	}
	
	public function getItemValue() {
		return $this->ItemValue;
	}
	
	public function getItemText() {
		return $this->ItemText;
	}
	
	public function getDisplayOrder() {
		return $this->DisplayOrder;
	}
	
	public function getParentItemValue() {
		return $this->ParentItemValue;
	}
	
	public function getFlag() {
		return $this->Flag;
	}
	
	public function getCustomField1() {
		return $this->CustomField1;
	}
	
	public function getCustomField2() {
		return $this->CustomField2;
	}
	
	public function getCustomField3() {
		return $this->CustomField3;
	}
	
	public function setItemId($val) {
		$this->ItemId =  $val;
	}
	
	public function setTableId($val) {
		$this->TableId =  $val;
	}
	
	public function setItemValue($val) {
		$this->ItemValue =  $val;
	}
	
	public function setItemText($val) {
		$this->ItemText =  $val;
	}
	
	public function setDisplayOrder($val) {
		$this->DisplayOrder =  $val;
	}
	
	public function setParentItemValue($val) {
		$this->ParentItemValue =  $val;
	}
	
	public function setFlag($val) {
		$this->Flag =  $val;
	}
	
	public function setCustomField1($val) {
		$this->CustomField1 =  $val;
	}
	
	public function setCustomField2($val) {
		$this->CustomField2 =  $val;
	}
	
	public function setCustomField3($val) {
		$this->CustomField3 =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllMasterData() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM MasterData ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectMasterDataById($ItemId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM MasterData WHERE ItemId='$ItemId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertMasterData() {
		
		$SQL = "INSERT INTO MasterData 
					(
					`TableId`,
					`ItemValue`,
					`ItemText`,
					`DisplayOrder`,
					`ParentItemValue`,
					`Flag`,
					`CustomField1`,
					`CustomField2`,
					`CustomField3`
					)
				VALUES
					(
					'$this->TableId',
					'$this->ItemValue',
					'$this->ItemText',
					'$this->DisplayOrder',
					'$this->ParentItemValue',
					'$this->Flag',
					'$this->CustomField1',
					'$this->CustomField2',
					'$this->CustomField3'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateMasterData() {
		
		$SQL = "UPDATE MasterData SET
	
					`TableId`='$this->TableId',
					`ItemValue`='$this->ItemValue',
					`ItemText`='$this->ItemText',
					`DisplayOrder`='$this->DisplayOrder',
					`ParentItemValue`='$this->ParentItemValue',
					`Flag`='$this->Flag',
					`CustomField1`='$this->CustomField1',
					`CustomField2`='$this->CustomField2',
					`CustomField3`='$this->CustomField3'
				WHERE
					ItemId='$this->ItemId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteMasterData() {
		
		$SQL = "DELETE FROM 
					MasterData
				WHERE
					ItemId='$this->ItemId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
