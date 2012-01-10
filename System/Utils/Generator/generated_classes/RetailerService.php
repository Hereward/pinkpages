<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        RetailerService
* GENERATION DATE:  13.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/RetailerService.php
* FOR MYSQL TABLE:  Retailer
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class RetailerService extends BaseFactoryService { // class : begin

	var $RetailerId;   // (KEY Attribute)
	var $UserId;   // (Normal Attribute)
	var $XMLPassword;   // (Normal Attribute)
	var $ContactName;   // (Normal Attribute)
	var $ContactPhone;   // (Normal Attribute)
	var $ContactEmail;   // (Normal Attribute)
	var $SiteDomain;   // (Normal Attribute)
	var $SiteSupportPhone;   // (Normal Attribute)
	var $SiteSupportEmail;   // (Normal Attribute)
	var $EmailNotification;   // (Normal Attribute)
	var $User;   // (Normal Attribute)
	var $ReferredBy;   // (Normal Attribute)
	var $ReferredCommissionType;   // (Normal Attribute)
	var $ReferredCommission;   // (Normal Attribute)
	var $RetailerType;   // (Normal Attribute)
	var $SetupAffiliateAc;   // (Normal Attribute)
	var $RealtimePayment;   // (Normal Attribute)
	var $RetailerSupport;   // (Normal Attribute)
	var $Comments;   // (Normal Attribute)

	public function getRetailerId() {
		return $this->RetailerId;
	}
	
	public function getUserId() {
		return $this->UserId;
	}
	
	public function getXMLPassword() {
		return $this->XMLPassword;
	}
	
	public function getContactName() {
		return $this->ContactName;
	}
	
	public function getContactPhone() {
		return $this->ContactPhone;
	}
	
	public function getContactEmail() {
		return $this->ContactEmail;
	}
	
	public function getSiteDomain() {
		return $this->SiteDomain;
	}
	
	public function getSiteSupportPhone() {
		return $this->SiteSupportPhone;
	}
	
	public function getSiteSupportEmail() {
		return $this->SiteSupportEmail;
	}
	
	public function getEmailNotification() {
		return $this->EmailNotification;
	}
	
	public function getUser() {
		return $this->User;
	}
	
	public function getReferredBy() {
		return $this->ReferredBy;
	}
	
	public function getReferredCommissionType() {
		return $this->ReferredCommissionType;
	}
	
	public function getReferredCommission() {
		return $this->ReferredCommission;
	}
	
	public function getRetailerType() {
		return $this->RetailerType;
	}
	
	public function getSetupAffiliateAc() {
		return $this->SetupAffiliateAc;
	}
	
	public function getRealtimePayment() {
		return $this->RealtimePayment;
	}
	
	public function getRetailerSupport() {
		return $this->RetailerSupport;
	}
	
	public function getComments() {
		return $this->Comments;
	}
	
	public function setRetailerId($val) {
		$this->RetailerId =  $val;
	}
	
	public function setUserId($val) {
		$this->UserId =  $val;
	}
	
	public function setXMLPassword($val) {
		$this->XMLPassword =  $val;
	}
	
	public function setContactName($val) {
		$this->ContactName =  $val;
	}
	
	public function setContactPhone($val) {
		$this->ContactPhone =  $val;
	}
	
	public function setContactEmail($val) {
		$this->ContactEmail =  $val;
	}
	
	public function setSiteDomain($val) {
		$this->SiteDomain =  $val;
	}
	
	public function setSiteSupportPhone($val) {
		$this->SiteSupportPhone =  $val;
	}
	
	public function setSiteSupportEmail($val) {
		$this->SiteSupportEmail =  $val;
	}
	
	public function setEmailNotification($val) {
		$this->EmailNotification =  $val;
	}
	
	public function setUser($val) {
		$this->User =  $val;
	}
	
	public function setReferredBy($val) {
		$this->ReferredBy =  $val;
	}
	
	public function setReferredCommissionType($val) {
		$this->ReferredCommissionType =  $val;
	}
	
	public function setReferredCommission($val) {
		$this->ReferredCommission =  $val;
	}
	
	public function setRetailerType($val) {
		$this->RetailerType =  $val;
	}
	
	public function setSetupAffiliateAc($val) {
		$this->SetupAffiliateAc =  $val;
	}
	
	public function setRealtimePayment($val) {
		$this->RealtimePayment =  $val;
	}
	
	public function setRetailerSupport($val) {
		$this->RetailerSupport =  $val;
	}
	
	public function setComments($val) {
		$this->Comments =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllRetailer() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM Retailer ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectRetailerById($RetailerId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM Retailer WHERE RetailerId='$RetailerId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertRetailer() {
		
		$SQL = "INSERT INTO Retailer 
					(
					`UserId`,
					`XMLPassword`,
					`ContactName`,
					`ContactPhone`,
					`ContactEmail`,
					`SiteDomain`,
					`SiteSupportPhone`,
					`SiteSupportEmail`,
					`EmailNotification`,
					`User`,
					`ReferredBy`,
					`ReferredCommissionType`,
					`ReferredCommission`,
					`RetailerType`,
					`SetupAffiliateAc`,
					`RealtimePayment`,
					`RetailerSupport`,
					`Comments`
					)
				VALUES
					(
					'$this->UserId',
					'$this->XMLPassword',
					'$this->ContactName',
					'$this->ContactPhone',
					'$this->ContactEmail',
					'$this->SiteDomain',
					'$this->SiteSupportPhone',
					'$this->SiteSupportEmail',
					'$this->EmailNotification',
					'$this->User',
					'$this->ReferredBy',
					'$this->ReferredCommissionType',
					'$this->ReferredCommission',
					'$this->RetailerType',
					'$this->SetupAffiliateAc',
					'$this->RealtimePayment',
					'$this->RetailerSupport',
					'$this->Comments'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateRetailer() {
		
		$SQL = "UPDATE Retailer SET
	
					`UserId`='$this->UserId',
					`XMLPassword`='$this->XMLPassword',
					`ContactName`='$this->ContactName',
					`ContactPhone`='$this->ContactPhone',
					`ContactEmail`='$this->ContactEmail',
					`SiteDomain`='$this->SiteDomain',
					`SiteSupportPhone`='$this->SiteSupportPhone',
					`SiteSupportEmail`='$this->SiteSupportEmail',
					`EmailNotification`='$this->EmailNotification',
					`User`='$this->User',
					`ReferredBy`='$this->ReferredBy',
					`ReferredCommissionType`='$this->ReferredCommissionType',
					`ReferredCommission`='$this->ReferredCommission',
					`RetailerType`='$this->RetailerType',
					`SetupAffiliateAc`='$this->SetupAffiliateAc',
					`RealtimePayment`='$this->RealtimePayment',
					`RetailerSupport`='$this->RetailerSupport',
					`Comments`='$this->Comments'
				WHERE
					RetailerId='$this->RetailerId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteRetailer() {
		
		$SQL = "DELETE FROM 
					Retailer
				WHERE
					CustomerId='$this->RetailerId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
