<?php
ini_set("display_errors", 1);
include("../config/configuration.php");
include(SERVICE_CLASSES_PATH."BaseFactoryService.php");
$database = new BaseFactoryService();

$f = (isset($_REQUEST["f"]))?$_REQUEST["f"]:'';
if($f == "")
{
?>

<b>Class Generator</b>
<form action="generator.php" method="POST" name="FORMGEN">
1) Select Table Name:
<br>

<select name="tablename">

<?php

$tablelist = mysql_list_tables(DB_NAME);
while ($row = mysql_fetch_row($tablelist)) {
	print "<option value=\"$row[0]\">$row[0]</option>";
}
?>
</select>

<p>
2) Type Class Name (ex. "test"): <br>
<input type="text" name="classname" size="50" value="">
<p>
3) Type Name of Key Field:
<br>
<input type="text" name="keyname" value="" size="50">
<br>
<font size=1>
(Name of key-field with type number with autoincrement!)
</font>
<p>


<input type="submit" name="s1" value="Generate Class">
<input type="hidden" name="f" value="formshowed">

</form>

<?php
} else {
	// fill parameters from form
	$table = $_REQUEST["tablename"];
	$className = (!empty($_REQUEST["classname"]))?$_REQUEST["classname"]:$table.'Service';

	$dir = dirname(__FILE__);

	$filename = $dir . "/generated_classes/".$className . ".php";

	// if file exists, then delete it
	if(file_exists($filename)) unlink($filename);

	// open file in insert mode
	$file = fopen($filename, "w+");
	$filedate = date("d.m.Y");

	$DB_NAME = DB_NAME;
	$columns = array();

	$c = "<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        $className
* GENERATION DATE:  $filedate
* CLASS FILE:       $filename
* FOR MYSQL TABLE:  $table
* FOR MYSQL DB:     $DB_NAME
*
*/

class $className extends BaseFactoryService { // class : begin

";

	$SQL = "SHOW COLUMNS FROM $table;";
	$result = mysql_query($SQL);

	while ($row = mysql_fetch_row($result))	{
		$attrib_type = "Normal";
		if($row[3] == "PRI") {
			$key = $row[0]; $attrib_type = "KEY";
		}
		else
		$columns[] = $row[0];
		$c.= "	var $$row[0];   // ($attrib_type Attribute)
";
	}

	$result = mysql_query($SQL);
	while ($row = mysql_fetch_row($result))	{
		$col=$row[0];
		$mname = "get" . $col . "()";
		$mthis = "$" . "this->" . $col;
		$c.="
	public function $mname {
		return $mthis;
	}
	";
	}
	$result = mysql_query($SQL);
	while ($row = mysql_fetch_row($result))	{
		$col=$row[0];
		$val = "$" . "val";
		$mname = "set" . $col . "($" . "val)";
		$mthis = "$" . "this->" . $col . " = ";
		$c.="
	public function $mname {
		$mthis $val;
	}
	";
	}

	$c .="
	public function __construct() { parent::__construct();}
	";

	$SQL = '$SQL = ';
	$id = '$'.$key;
	$thisDotgetCols = '$this->getCols()';
	$returnThisDBquery = 'return $this->db->QueryRecordsArray($SQL)';
	$thisDotgetCondition = '$this->getCondition()';

	$c .="
	function SelectAll$table() {
		
		$SQL \"SELECT \".$thisDotgetCols.\" FROM $table \".$thisDotgetCondition;
		$returnThisDBquery;
	}

	public function Select$table"."ById($id) {
		
		$SQL \" SELECT \".$thisDotgetCols.\" FROM $table WHERE $key='$id'\";
		$returnThisDBquery;
	}
	";

	$Execute = '$this->db->execute($SQL)';
	$ReturnLastInsertId = 'return $this->db->lastInsertedId()';
	$thisDot = '$this->';

	$c.="
	public function Insert$table() {
		
		$SQL\"INSERT INTO $table 
					(
					";
	$c .= '`'.implode("`,\n\t\t\t\t\t`",$columns).'`';
	$c .=
	"\n\t\t\t\t\t)
				VALUES
					(
					";
	$c .= "'$thisDot".implode("',\n\t\t\t\t\t'$thisDot",$columns)."'";
	$c .=
	"\n\t\t\t\t\t)\";
		
		$Execute;
		$ReturnLastInsertId;
	}
	";
	foreach ($columns as $col) $updateColsArr[] = "`$col`='$thisDot".$col."'";
	$c.="
	public function Update$table() {
		
		$SQL\"UPDATE $table SET
	
					";
	$c .= implode(",\n\t\t\t\t\t",$updateColsArr);
	$c .="
				WHERE
					$key='$thisDot$key'\";
				
		$Execute;
	}
	";

	$c.="
	public function Delete$table() {
		
		$SQL\"DELETE FROM 
					$table
				WHERE
					$key='$thisDot".$key."'\";
		$Execute;
	}
	";

	$c.= "
} // class : end

?>
";
	fwrite($file, $c);

	print "
<b>Class '$className' successfully generated as file '$filename'<br>
<a href=\"javascript:history.back();\">Back</a><br><br>
Source Code:<br>
</b></font>

";
	show_source($filename);
} // endif

?>