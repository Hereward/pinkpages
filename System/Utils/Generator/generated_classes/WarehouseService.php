<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        WarehouseService
* GENERATION DATE:  21.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/WarehouseService.php
* FOR MYSQL TABLE:  Warehouse
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class WarehouseService extends BaseFactoryService { // class : begin

	var $WarehouseId;   // (KEY Attribute)
	var $Title;   // (Normal Attribute)
	var $AltName;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)
	var $License;   // (Normal Attribute)
	var $ContactName;   // (Normal Attribute)
	var $Initials;   // (Normal Attribute)
	var $Address1;   // (Normal Attribute)
	var $Address2;   // (Normal Attribute)
	var $City;   // (Normal Attribute)
	var $State;   // (Normal Attribute)
	var $Zip;   // (Normal Attribute)
	var $Country;   // (Normal Attribute)
	var $Phone;   // (Normal Attribute)
	var $TollFreePhone;   // (Normal Attribute)
	var $ReorderPhone;   // (Normal Attribute)
	var $Fax;   // (Normal Attribute)
	var $Comments;   // (Normal Attribute)
	var $ShippingLabelTypeId;   // (Normal Attribute)
	var $ModifyCosts;   // (Normal Attribute)
	var $PostingIntegrationId;   // (Normal Attribute)
	var $PostingURL;   // (Normal Attribute)
	var $PostingUserName;   // (Normal Attribute)
	var $PostingPassword;   // (Normal Attribute)
	var $PostingId;   // (Normal Attribute)
	var $ItemTotal;   // (Normal Attribute)
	var $OrderNote;   // (Normal Attribute)
	var $QADetail;   // (Normal Attribute)
	var $InvoiceTemplateId;   // (Normal Attribute)

	public function getWarehouseId() {
		return $this->WarehouseId;
	}
	
	public function getTitle() {
		return $this->Title;
	}
	
	public function getAltName() {
		return $this->AltName;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function getLicense() {
		return $this->License;
	}
	
	public function getContactName() {
		return $this->ContactName;
	}
	
	public function getInitials() {
		return $this->Initials;
	}
	
	public function getAddress1() {
		return $this->Address1;
	}
	
	public function getAddress2() {
		return $this->Address2;
	}
	
	public function getCity() {
		return $this->City;
	}
	
	public function getState() {
		return $this->State;
	}
	
	public function getZip() {
		return $this->Zip;
	}
	
	public function getCountry() {
		return $this->Country;
	}
	
	public function getPhone() {
		return $this->Phone;
	}
	
	public function getTollFreePhone() {
		return $this->TollFreePhone;
	}
	
	public function getReorderPhone() {
		return $this->ReorderPhone;
	}
	
	public function getFax() {
		return $this->Fax;
	}
	
	public function getComments() {
		return $this->Comments;
	}
	
	public function getShippingLabelTypeId() {
		return $this->ShippingLabelTypeId;
	}
	
	public function getModifyCosts() {
		return $this->ModifyCosts;
	}
	
	public function getPostingIntegrationId() {
		return $this->PostingIntegrationId;
	}
	
	public function getPostingURL() {
		return $this->PostingURL;
	}
	
	public function getPostingUserName() {
		return $this->PostingUserName;
	}
	
	public function getPostingPassword() {
		return $this->PostingPassword;
	}
	
	public function getPostingId() {
		return $this->PostingId;
	}
	
	public function getItemTotal() {
		return $this->ItemTotal;
	}
	
	public function getOrderNote() {
		return $this->OrderNote;
	}
	
	public function getQADetail() {
		return $this->QADetail;
	}
	
	public function getInvoiceTemplateId() {
		return $this->InvoiceTemplateId;
	}
	
	public function setWarehouseId($val) {
		$this->WarehouseId =  $val;
	}
	
	public function setTitle($val) {
		$this->Title =  $val;
	}
	
	public function setAltName($val) {
		$this->AltName =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function setLicense($val) {
		$this->License =  $val;
	}
	
	public function setContactName($val) {
		$this->ContactName =  $val;
	}
	
	public function setInitials($val) {
		$this->Initials =  $val;
	}
	
	public function setAddress1($val) {
		$this->Address1 =  $val;
	}
	
	public function setAddress2($val) {
		$this->Address2 =  $val;
	}
	
	public function setCity($val) {
		$this->City =  $val;
	}
	
	public function setState($val) {
		$this->State =  $val;
	}
	
	public function setZip($val) {
		$this->Zip =  $val;
	}
	
	public function setCountry($val) {
		$this->Country =  $val;
	}
	
	public function setPhone($val) {
		$this->Phone =  $val;
	}
	
	public function setTollFreePhone($val) {
		$this->TollFreePhone =  $val;
	}
	
	public function setReorderPhone($val) {
		$this->ReorderPhone =  $val;
	}
	
	public function setFax($val) {
		$this->Fax =  $val;
	}
	
	public function setComments($val) {
		$this->Comments =  $val;
	}
	
	public function setShippingLabelTypeId($val) {
		$this->ShippingLabelTypeId =  $val;
	}
	
	public function setModifyCosts($val) {
		$this->ModifyCosts =  $val;
	}
	
	public function setPostingIntegrationId($val) {
		$this->PostingIntegrationId =  $val;
	}
	
	public function setPostingURL($val) {
		$this->PostingURL =  $val;
	}
	
	public function setPostingUserName($val) {
		$this->PostingUserName =  $val;
	}
	
	public function setPostingPassword($val) {
		$this->PostingPassword =  $val;
	}
	
	public function setPostingId($val) {
		$this->PostingId =  $val;
	}
	
	public function setItemTotal($val) {
		$this->ItemTotal =  $val;
	}
	
	public function setOrderNote($val) {
		$this->OrderNote =  $val;
	}
	
	public function setQADetail($val) {
		$this->QADetail =  $val;
	}
	
	public function setInvoiceTemplateId($val) {
		$this->InvoiceTemplateId =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllWarehouse() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM Warehouse ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectWarehouseById($WarehouseId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM Warehouse WHERE WarehouseId='$WarehouseId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertWarehouse() {
		
		$SQL = "INSERT INTO Warehouse 
					(
					`Title`,
					`AltName`,
					`Status`,
					`License`,
					`ContactName`,
					`Initials`,
					`Address1`,
					`Address2`,
					`City`,
					`State`,
					`Zip`,
					`Country`,
					`Phone`,
					`TollFreePhone`,
					`ReorderPhone`,
					`Fax`,
					`Comments`,
					`ShippingLabelTypeId`,
					`ModifyCosts`,
					`PostingIntegrationId`,
					`PostingURL`,
					`PostingUserName`,
					`PostingPassword`,
					`PostingId`,
					`ItemTotal`,
					`OrderNote`,
					`QADetail`,
					`InvoiceTemplateId`
					)
				VALUES
					(
					'$this->Title',
					'$this->AltName',
					'$this->Status',
					'$this->License',
					'$this->ContactName',
					'$this->Initials',
					'$this->Address1',
					'$this->Address2',
					'$this->City',
					'$this->State',
					'$this->Zip',
					'$this->Country',
					'$this->Phone',
					'$this->TollFreePhone',
					'$this->ReorderPhone',
					'$this->Fax',
					'$this->Comments',
					'$this->ShippingLabelTypeId',
					'$this->ModifyCosts',
					'$this->PostingIntegrationId',
					'$this->PostingURL',
					'$this->PostingUserName',
					'$this->PostingPassword',
					'$this->PostingId',
					'$this->ItemTotal',
					'$this->OrderNote',
					'$this->QADetail',
					'$this->InvoiceTemplateId'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateWarehouse() {
		
		$SQL = "UPDATE Warehouse SET
	
					`Title`='$this->Title',
					`AltName`='$this->AltName',
					`Status`='$this->Status',
					`License`='$this->License',
					`ContactName`='$this->ContactName',
					`Initials`='$this->Initials',
					`Address1`='$this->Address1',
					`Address2`='$this->Address2',
					`City`='$this->City',
					`State`='$this->State',
					`Zip`='$this->Zip',
					`Country`='$this->Country',
					`Phone`='$this->Phone',
					`TollFreePhone`='$this->TollFreePhone',
					`ReorderPhone`='$this->ReorderPhone',
					`Fax`='$this->Fax',
					`Comments`='$this->Comments',
					`ShippingLabelTypeId`='$this->ShippingLabelTypeId',
					`ModifyCosts`='$this->ModifyCosts',
					`PostingIntegrationId`='$this->PostingIntegrationId',
					`PostingURL`='$this->PostingURL',
					`PostingUserName`='$this->PostingUserName',
					`PostingPassword`='$this->PostingPassword',
					`PostingId`='$this->PostingId',
					`ItemTotal`='$this->ItemTotal',
					`OrderNote`='$this->OrderNote',
					`QADetail`='$this->QADetail',
					`InvoiceTemplateId`='$this->InvoiceTemplateId'
				WHERE
					WarehouseId='$this->WarehouseId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteWarehouse() {
		
		$SQL = "DELETE FROM 
					Warehouse
				WHERE
					WarehouseId='$this->WarehouseId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
