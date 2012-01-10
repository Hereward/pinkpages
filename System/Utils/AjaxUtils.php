<?php
class AjaxUtils {
	
	public static function CreateSelectBox($Data, $SelectId='', $SelectName='', $Func='', $Text='') {
		
		$DropDown = "<select id=\"$SelectId\" name=\"$SelectName\" $Func>";
		$DropDown .= "<option value=\"\">--$Text--</option>";
		foreach ($Data as $value) {
			$DropDown .= "<option value=\"{$value[0]}\">{$value[0]}</option>";
		}
		$DropDown .= "</select>";
		
		return $DropDown;
	}
}
?>