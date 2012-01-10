<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        GatewaySystemErrorService
* GENERATION DATE:  04.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/GatewaySystemErrorService.php
* FOR MYSQL TABLE:  GatewaySystemError
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class GatewaySystemErrorService extends BaseFactoryService { // class : begin

	var $GatewaySystemErrorId;   // (KEY Attribute)
	var $ErrorType;   // (Normal Attribute)
	var $XMLData;   // (Normal Attribute)
	var $InsertTime;   // (Normal Attribute)
	var $UpdateTime;   // (Normal Attribute)

	public function getGatewaySystemErrorId() {
		return $this->GatewaySystemErrorId;
	}
	
	public function getErrorType() {
		return $this->ErrorType;
	}
	
	public function getXMLData() {
		return $this->XMLData;
	}
	
	public function getInsertTime() {
		return $this->InsertTime;
	}
	
	public function getUpdateTime() {
		return $this->UpdateTime;
	}
	
	public function setGatewaySystemErrorId($val) {
		$this->GatewaySystemErrorId =  $val;
	}
	
	public function setErrorType($val) {
		$this->ErrorType =  $val;
	}
	
	public function setXMLData($val) {
		$this->XMLData =  $val;
	}
	
	public function setInsertTime($val) {
		$this->InsertTime =  $val;
	}
	
	public function setUpdateTime($val) {
		$this->UpdateTime =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllGatewaySystemError() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM GatewaySystemError ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectGatewaySystemErrorById($GatewaySystemErrorId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM GatewaySystemError WHERE GatewaySystemErrorId='$GatewaySystemErrorId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertGatewaySystemError() {
		
		$SQL = "INSERT INTO GatewaySystemError 
					(
					`ErrorType`,
					`XMLData`,
					`InsertTime`,
					`UpdateTime`
					)
				VALUES
					(
					'$this->ErrorType',
					'$this->XMLData',
					'$this->InsertTime',
					'$this->UpdateTime'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateGatewaySystemError() {
		
		$SQL = "UPDATE GatewaySystemError SET
	
					`ErrorType`='$this->ErrorType',
					`XMLData`='$this->XMLData',
					`InsertTime`='$this->InsertTime',
					`UpdateTime`='$this->UpdateTime'
				WHERE
					GatewaySystemErrorId='$this->GatewaySystemErrorId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteGatewaySystemError() {
		
		$SQL = "DELETE FROM 
					GatewaySystemError
				WHERE
					GatewaySystemErrorId='$this->GatewaySystemErrorId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
