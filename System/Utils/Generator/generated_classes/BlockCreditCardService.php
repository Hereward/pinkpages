<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        BlockCreditCardService
* GENERATION DATE:  19.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/BlockCreditCardService.php
* FOR MYSQL TABLE:  BlockCreditCard
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class BlockCreditCardService extends BaseFactoryService { // class : begin

	var $BlockCreditCardId;   // (KEY Attribute)
	var $CardNumber;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getBlockCreditCardId() {
		return $this->BlockCreditCardId;
	}
	
	public function getCardNumber() {
		return $this->CardNumber;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setBlockCreditCardId($val) {
		$this->BlockCreditCardId =  $val;
	}
	
	public function setCardNumber($val) {
		$this->CardNumber =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllBlockCreditCard() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM BlockCreditCard ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectBlockCreditCardById($BlockCreditCardId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM BlockCreditCard WHERE BlockCreditCardId='$BlockCreditCardId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertBlockCreditCard() {
		
		$SQL = "INSERT INTO BlockCreditCard 
					(
					`CardNumber`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->CardNumber',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateBlockCreditCard() {
		
		$SQL = "UPDATE BlockCreditCard SET
	
					`CardNumber`='$this->CardNumber',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					BlockCreditCardId='$this->BlockCreditCardId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteBlockCreditCard() {
		
		$SQL = "DELETE FROM 
					BlockCreditCard
				WHERE
					BlockCreditCardId='$this->BlockCreditCardId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
