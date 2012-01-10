<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        CustomerService
* GENERATION DATE:  12.03.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/CustomerService.php
* FOR MYSQL TABLE:  Customer
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

include(SERVICE_CLASSES_PATH.'BaseFactoryService.php');

class CustomerService extends BaseFactoryService { // class : begin

	var $CustomerId;   // (KEY Attribute)
	var $FirstName;   // (Normal Attribute)
	var $LastName;   // (Normal Attribute)
	var $Email;   // (Normal Attribute)

	public function getCustomerId()	{
		return $this->CustomerId;
	}
	
	public function getFirstName()	{
		return $this->FirstName;
	}
	
	public function getLastName()	{
		return $this->LastName;
	}
	
	public function getEmail()	{
		return $this->Email;
	}
	
	public function setCustomerId($val) {
		$this->CustomerId =  $val;
	}
	
	public function setFirstName($val) {
		$this->FirstName =  $val;
	}
	
	public function setLastName($val) {
		$this->LastName =  $val;
	}
	
	public function setEmail($val) {
		$this->Email =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllCustomer() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM Customer ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectCustomerById($CustomerId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM Customer WHERE CustomerId='$CustomerId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertCustomer() {
		
		$SQL = "INSERT INTO Customer 
					(
					`FirstName`,
					`LastName`,
					`Email`
					)
				VALUES
					(
					'$this->FirstName',
					'$this->LastName',
					'$this->Email'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateCustomer() {
		
		$SQL = "UPDATE Customer SET
	
					`FirstName`='$this->FirstName',
					`LastName`='$this->LastName',
					`Email`='$this->Email'
				WHERE
					CustomerId='$this->CustomerId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteCustomer() {
		
		$SQL = "DELETE FROM 
					Customer
				WHERE
					CustomerId='$this->CustomerId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
