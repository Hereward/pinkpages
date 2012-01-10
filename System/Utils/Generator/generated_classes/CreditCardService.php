<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        CreditCardService
* GENERATION DATE:  26.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/CreditCardService.php
* FOR MYSQL TABLE:  CreditCard
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class CreditCardService extends BaseFactoryService { // class : begin

	var $CreditCardId;   // (KEY Attribute)
	var $CreditCardName;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)

	public function getCreditCardId() {
		return $this->CreditCardId;
	}
	
	public function getCreditCardName() {
		return $this->CreditCardName;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function setCreditCardId($val) {
		$this->CreditCardId =  $val;
	}
	
	public function setCreditCardName($val) {
		$this->CreditCardName =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllCreditCard() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM CreditCard ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectCreditCardById($CreditCardId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM CreditCard WHERE CreditCardId='$CreditCardId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertCreditCard() {
		
		$SQL = "INSERT INTO CreditCard 
					(
					`CreditCardName`,
					`Status`
					)
				VALUES
					(
					'$this->CreditCardName',
					'$this->Status'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateCreditCard() {
		
		$SQL = "UPDATE CreditCard SET
	
					`CreditCardName`='$this->CreditCardName',
					`Status`='$this->Status'
				WHERE
					CreditCardId='$this->CreditCardId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteCreditCard() {
		
		$SQL = "DELETE FROM 
					CreditCard
				WHERE
					CreditCardId='$this->CreditCardId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
