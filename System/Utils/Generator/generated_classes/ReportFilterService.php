<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        ReportFilterService
* GENERATION DATE:  18.04.2008
* CLASS FILE:       /home/vsworx/Projects/Current/OrderingCRM/Code/Generator/generated_classes/ReportFilterService.php
* FOR MYSQL TABLE:  ReportFilter
* FOR MYSQL DB:     vsworx_ordering_crm
*
*/

class ReportFilterService extends BaseFactoryService { // class : begin

	var $ReportFilter;   // (KEY Attribute)
	var $ReportId;   // (Normal Attribute)
	var $ColumnName;   // (Normal Attribute)
	var $Operator;   // (Normal Attribute)
	var $FieldType;   // (Normal Attribute)
	var $SourceTable;   // (Normal Attribute)
	var $SourceColumn;   // (Normal Attribute)

	public function getReportFilter() {
		return $this->ReportFilter;
	}
	
	public function getReportId() {
		return $this->ReportId;
	}
	
	public function getColumnName() {
		return $this->ColumnName;
	}
	
	public function getOperator() {
		return $this->Operator;
	}
	
	public function getFieldType() {
		return $this->FieldType;
	}
	
	public function getSourceTable() {
		return $this->SourceTable;
	}
	
	public function getSourceColumn() {
		return $this->SourceColumn;
	}
	
	public function setReportFilter($val) {
		$this->ReportFilter =  $val;
	}
	
	public function setReportId($val) {
		$this->ReportId =  $val;
	}
	
	public function setColumnName($val) {
		$this->ColumnName =  $val;
	}
	
	public function setOperator($val) {
		$this->Operator =  $val;
	}
	
	public function setFieldType($val) {
		$this->FieldType =  $val;
	}
	
	public function setSourceTable($val) {
		$this->SourceTable =  $val;
	}
	
	public function setSourceColumn($val) {
		$this->SourceColumn =  $val;
	}
	
	public function __construct() { parent::__construct();}
	
	function SelectAllReportFilter() {
		
		$SQL =  "SELECT ".$this->getCols()." FROM ReportFilter ".$this->getCondition();
		return $this->db->QueryRecordsArray($SQL);
	}

	public function SelectReportFilterById($ReportFilter) {
		
		$SQL =  " SELECT ".$this->getCols()." FROM ReportFilter WHERE ReportFilter='$ReportFilter'";
		return $this->db->QueryRecordsArray($SQL);
	}
	
	public function InsertReportFilter() {
		
		$SQL = "INSERT INTO ReportFilter 
					(
					`ReportId`,
					`ColumnName`,
					`Operator`,
					`FieldType`,
					`SourceTable`,
					`SourceColumn`
					)
				VALUES
					(
					'$this->ReportId',
					'$this->ColumnName',
					'$this->Operator',
					'$this->FieldType',
					'$this->SourceTable',
					'$this->SourceColumn'
					)";
		
		$this->db->execute($SQL);
		return $this->db->lastInsertedId();
	}
	
	public function UpdateReportFilter() {
		
		$SQL = "UPDATE ReportFilter SET
	
					`ReportId`='$this->ReportId',
					`ColumnName`='$this->ColumnName',
					`Operator`='$this->Operator',
					`FieldType`='$this->FieldType',
					`SourceTable`='$this->SourceTable',
					`SourceColumn`='$this->SourceColumn'
				WHERE
					ReportFilter='$this->ReportFilter'";
				
		$this->db->execute($SQL);
	}
	
	public function DeleteReportFilter() {
		
		$SQL = "DELETE FROM 
					ReportFilter
				WHERE
					ReportFilter='$this->ReportFilter'";
		$this->db->execute($SQL);
	}
	
} // class : end

?>
