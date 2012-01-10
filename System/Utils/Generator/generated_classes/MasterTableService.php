<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        MasterTableService
* GENERATION DATE:  15.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/MasterTableService.php
* FOR MYSQL TABLE:  MasterTable
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class MasterTableService extends BaseFactoryService { // class : begin

	var $MasterTableId;   // (KEY Attribute)
	var $TableName;   // (Normal Attribute)
	var $Description;   // (Normal Attribute)
	var $ParentTableId;   // (Normal Attribute)
	var $IsUserEditable;   // (Normal Attribute)
	var $IsCustom;   // (Normal Attribute)
	var $CustomLink;   // (Normal Attribute)
	var $CustomField1Name;   // (Normal Attribute)
	var $CustomField2Name;   // (Normal Attribute)
	var $CustomField3Name;   // (Normal Attribute)

	public function getMasterTableId() {
		return $this->MasterTableId;
	}
	
	public function getTableName() {
		return $this->TableName;
	}
	
	public function getDescription() {
		return $this->Description;
	}
	
	public function getParentTableId() {
		return $this->ParentTableId;
	}
	
	public function getIsUserEditable() {
		return $this->IsUserEditable;
	}
	
	public function getIsCustom() {
		return $this->IsCustom;
	}
	
	public function getCustomLink() {
		return $this->CustomLink;
	}
	
	public function getCustomField1Name() {
		return $this->CustomField1Name;
	}
	
	public function getCustomField2Name() {
		return $this->CustomField2Name;
	}
	
	public function getCustomField3Name() {
		return $this->CustomField3Name;
	}
	
	public function setMasterTableId($val) {
		$this->MasterTableId =  $val;
	}
	
	public function setTableName($val) {
		$this->TableName =  $val;
	}
	
	public function setDescription($val) {
		$this->Description =  $val;
	}
	
	public function setParentTableId($val) {
		$this->ParentTableId =  $val;
	}
	
	public function setIsUserEditable($val) {
		$this->IsUserEditable =  $val;
	}
	
	public function setIsCustom($val) {
		$this->IsCustom =  $val;
	}
	
	public function setCustomLink($val) {
		$this->CustomLink =  $val;
	}
	
	public function setCustomField1Name($val) {
		$this->CustomField1Name =  $val;
	}
	
	public function setCustomField2Name($val) {
		$this->CustomField2Name =  $val;
	}
	
	public function setCustomField3Name($val) {
		$this->CustomField3Name =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllMasterTable() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM MasterTable ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectMasterTableById($MasterTableId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM MasterTable WHERE MasterTableId='$MasterTableId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertMasterTable() {
		
		$SQL = "INSERT INTO MasterTable 
					(
					`TableName`,
					`Description`,
					`ParentTableId`,
					`IsUserEditable`,
					`IsCustom`,
					`CustomLink`,
					`CustomField1Name`,
					`CustomField2Name`,
					`CustomField3Name`
					)
				VALUES
					(
					'$this->TableName',
					'$this->Description',
					'$this->ParentTableId',
					'$this->IsUserEditable',
					'$this->IsCustom',
					'$this->CustomLink',
					'$this->CustomField1Name',
					'$this->CustomField2Name',
					'$this->CustomField3Name'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateMasterTable() {
		
		$SQL = "UPDATE MasterTable SET
	
					`TableName`='$this->TableName',
					`Description`='$this->Description',
					`ParentTableId`='$this->ParentTableId',
					`IsUserEditable`='$this->IsUserEditable',
					`IsCustom`='$this->IsCustom',
					`CustomLink`='$this->CustomLink',
					`CustomField1Name`='$this->CustomField1Name',
					`CustomField2Name`='$this->CustomField2Name',
					`CustomField3Name`='$this->CustomField3Name'
				WHERE
					MasterTableId='$this->MasterTableId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteMasterTable() {
		
		$SQL = "DELETE FROM 
					MasterTable
				WHERE
					MasterTableId='$this->MasterTableId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
