<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ReportColumnService
* GENERATION DATE:  18.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ReportColumnService.php
* FOR MYSQL TABLE:  ReportColumn
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ReportColumnService extends BaseFactoryService { // class : begin

	var $ReportColumnId;   // (KEY Attribute)
	var $ReportId;   // (KEY Attribute)
	var $ColumnName;   // (Normal Attribute)
	var $ColumnTitle;   // (Normal Attribute)
	var $ColumnFunc;   // (Normal Attribute)

	public function getReportColumnId() {
		return $this->ReportColumnId;
	}
	
	public function getReportId() {
		return $this->ReportId;
	}
	
	public function getColumnName() {
		return $this->ColumnName;
	}
	
	public function getColumnTitle() {
		return $this->ColumnTitle;
	}
	
	public function getColumnFunc() {
		return $this->ColumnFunc;
	}
	
	public function setReportColumnId($val) {
		$this->ReportColumnId =  $val;
	}
	
	public function setReportId($val) {
		$this->ReportId =  $val;
	}
	
	public function setColumnName($val) {
		$this->ColumnName =  $val;
	}
	
	public function setColumnTitle($val) {
		$this->ColumnTitle =  $val;
	}
	
	public function setColumnFunc($val) {
		$this->ColumnFunc =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllReportColumn() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ReportColumn ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectReportColumnById($ReportId) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ReportColumn WHERE ReportId='$ReportId'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertReportColumn() {
		
		$SQL = "INSERT INTO ReportColumn 
					(
					`ColumnName`,
					`ColumnTitle`,
					`ColumnFunc`
					)
				VALUES
					(
					'$this->ColumnName',
					'$this->ColumnTitle',
					'$this->ColumnFunc'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateReportColumn() {
		
		$SQL = "UPDATE ReportColumn SET
	
					`ColumnName`='$this->ColumnName',
					`ColumnTitle`='$this->ColumnTitle',
					`ColumnFunc`='$this->ColumnFunc'
				WHERE
					ReportId='$this->ReportId'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteReportColumn() {
		
		$SQL = "DELETE FROM 
					ReportColumn
				WHERE
					ReportId='$this->ReportId'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
