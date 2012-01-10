<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ReportService
* GENERATION DATE:  18.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ReportService.php
* FOR MYSQL TABLE:  Report
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ReportService extends BaseFactoryService { // class : begin

	var $ReportId;   // (KEY Attribute)
	var $Header;   // (Normal Attribute)
	var $Footer;   // (Normal Attribute)
	var $Name;   // (Normal Attribute)

	public function getReportId() {
		return $this->ReportId;
	}
	
	public function getHeader() {
		return $this->Header;
	}
	
	public function getFooter() {
		return $this->Footer;
	}
	
	public function getName() {
		return $this->Name;
	}
	
	public function setReportId($val) {
		$this->ReportId =  $val;
	}
	
	public function setHeader($val) {
		$this->Header =  $val;
	}
	
	public function setFooter($val) {
		$this->Footer =  $val;
	}
	
	public function setName($val) {
		$this->Name =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllReport() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM Report ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectReportById($ReportId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM Report WHERE ReportId='$ReportId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertReport() {
		
		$SQL = "INSERT INTO Report 
					(
					`Header`,
					`Footer`,
					`Name`
					)
				VALUES
					(
					'$this->Header',
					'$this->Footer',
					'$this->Name'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateReport() {
		
		$SQL = "UPDATE Report SET
	
					`Header`='$this->Header',
					`Footer`='$this->Footer',
					`Name`='$this->Name'
				WHERE
					ReportId='$this->ReportId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteReport() {
		
		$SQL = "DELETE FROM 
					Report
				WHERE
					ReportId='$this->ReportId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
