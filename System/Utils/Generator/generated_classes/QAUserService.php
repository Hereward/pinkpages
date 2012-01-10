<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        QAUserService
* GENERATION DATE:  04.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/QAUserService.php
* FOR MYSQL TABLE:  QAUser
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class QAUserService extends BaseFactoryService { // class : begin

	var $QAUserId;   // (KEY Attribute)
	var $UserId;   // (Normal Attribute)
	var $FullName;   // (Normal Attribute)
	var $Reference;   // (Normal Attribute)
	var $Address;   // (Normal Attribute)
	var $City;   // (Normal Attribute)
	var $Region;   // (Normal Attribute)
	var $Zip;   // (Normal Attribute)
	var $Phone;   // (Normal Attribute)
	var $TIFRequired;   // (Normal Attribute)
	var $Signature;   // (Normal Attribute)

	public function getQAUserId() {
		return $this->QAUserId;
	}
	
	public function getUserId() {
		return $this->UserId;
	}
	
	public function getFullName() {
		return $this->FullName;
	}
	
	public function getReference() {
		return $this->Reference;
	}
	
	public function getAddress() {
		return $this->Address;
	}
	
	public function getCity() {
		return $this->City;
	}
	
	public function getRegion() {
		return $this->Region;
	}
	
	public function getZip() {
		return $this->Zip;
	}
	
	public function getPhone() {
		return $this->Phone;
	}
	
	public function getTIFRequired() {
		return $this->TIFRequired;
	}
	
	public function getSignature() {
		return $this->Signature;
	}
	
	public function setQAUserId($val) {
		$this->QAUserId =  $val;
	}
	
	public function setUserId($val) {
		$this->UserId =  $val;
	}
	
	public function setFullName($val) {
		$this->FullName =  $val;
	}
	
	public function setReference($val) {
		$this->Reference =  $val;
	}
	
	public function setAddress($val) {
		$this->Address =  $val;
	}
	
	public function setCity($val) {
		$this->City =  $val;
	}
	
	public function setRegion($val) {
		$this->Region =  $val;
	}
	
	public function setZip($val) {
		$this->Zip =  $val;
	}
	
	public function setPhone($val) {
		$this->Phone =  $val;
	}
	
	public function setTIFRequired($val) {
		$this->TIFRequired =  $val;
	}
	
	public function setSignature($val) {
		$this->Signature =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllQAUser() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM QAUser ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectQAUserById($QAUserId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM QAUser WHERE QAUserId='$QAUserId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertQAUser() {
		
		$SQL = "INSERT INTO QAUser 
					(
					`UserId`,
					`FullName`,
					`Reference`,
					`Address`,
					`City`,
					`Region`,
					`Zip`,
					`Phone`,
					`TIFRequired`,
					`Signature`
					)
				VALUES
					(
					'$this->UserId',
					'$this->FullName',
					'$this->Reference',
					'$this->Address',
					'$this->City',
					'$this->Region',
					'$this->Zip',
					'$this->Phone',
					'$this->TIFRequired',
					'$this->Signature'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateQAUser() {
		
		$SQL = "UPDATE QAUser SET
	
					`UserId`='$this->UserId',
					`FullName`='$this->FullName',
					`Reference`='$this->Reference',
					`Address`='$this->Address',
					`City`='$this->City',
					`Region`='$this->Region',
					`Zip`='$this->Zip',
					`Phone`='$this->Phone',
					`TIFRequired`='$this->TIFRequired',
					`Signature`='$this->Signature'
				WHERE
					QAUserId='$this->QAUserId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteQAUser() {
		
		$SQL = "DELETE FROM 
					QAUser
				WHERE
					QAUserId='$this->QAUserId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
