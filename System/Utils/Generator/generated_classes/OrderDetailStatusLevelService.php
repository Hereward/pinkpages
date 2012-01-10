<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        OrderDetailStatusLevelService
* GENERATION DATE:  11.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/OrderDetailStatusLevelService.php
* FOR MYSQL TABLE:  OrderDetailStatusLevel
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class OrderDetailStatusLevelService extends BaseFactoryService { // class : begin

	var $OrderDetailStatusLevelId;   // (KEY Attribute)
	var $Position;   // (Normal Attribute)
	var $SYS;   // (Normal Attribute)
	var $Description;   // (Normal Attribute)
	var $AllowQAtoChange;   // (Normal Attribute)
	var $StatusText;   // (Normal Attribute)
	var $Status;   // (Normal Attribute)

	public function getOrderDetailStatusLevelId() {
		return $this->OrderDetailStatusLevelId;
	}
	
	public function getPosition() {
		return $this->Position;
	}
	
	public function getSYS() {
		return $this->SYS;
	}
	
	public function getDescription() {
		return $this->Description;
	}
	
	public function getAllowQAtoChange() {
		return $this->AllowQAtoChange;
	}
	
	public function getStatusText() {
		return $this->StatusText;
	}
	
	public function getStatus() {
		return $this->Status;
	}
	
	public function setOrderDetailStatusLevelId($val) {
		$this->OrderDetailStatusLevelId =  $val;
	}
	
	public function setPosition($val) {
		$this->Position =  $val;
	}
	
	public function setSYS($val) {
		$this->SYS =  $val;
	}
	
	public function setDescription($val) {
		$this->Description =  $val;
	}
	
	public function setAllowQAtoChange($val) {
		$this->AllowQAtoChange =  $val;
	}
	
	public function setStatusText($val) {
		$this->StatusText =  $val;
	}
	
	public function setStatus($val) {
		$this->Status =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllOrderDetailStatusLevel() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM OrderDetailStatusLevel ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectOrderDetailStatusLevelById($OrderDetailStatusLevelId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM OrderDetailStatusLevel WHERE OrderDetailStatusLevelId='$OrderDetailStatusLevelId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertOrderDetailStatusLevel() {
		
		$SQL = "INSERT INTO OrderDetailStatusLevel 
					(
					`Position`,
					`SYS`,
					`Description`,
					`AllowQAtoChange`,
					`StatusText`,
					`Status`
					)
				VALUES
					(
					'$this->Position',
					'$this->SYS',
					'$this->Description',
					'$this->AllowQAtoChange',
					'$this->StatusText',
					'$this->Status'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateOrderDetailStatusLevel() {
		
		$SQL = "UPDATE OrderDetailStatusLevel SET
	
					`Position`='$this->Position',
					`SYS`='$this->SYS',
					`Description`='$this->Description',
					`AllowQAtoChange`='$this->AllowQAtoChange',
					`StatusText`='$this->StatusText',
					`Status`='$this->Status'
				WHERE
					OrderDetailStatusLevelId='$this->OrderDetailStatusLevelId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteOrderDetailStatusLevel() {
		
		$SQL = "DELETE FROM 
					OrderDetailStatusLevel
				WHERE
					OrderDetailStatusLevelId='$this->OrderDetailStatusLevelId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
