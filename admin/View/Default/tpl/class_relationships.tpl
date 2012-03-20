
<div class="content">
<h3><center><b>Export Classification Relationships</b></center></h3>
<br />
<form action="{$class_region_report_action}" id="" name="classificationReport" method="post" onsubmit="return validate();">
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
		 <td><p>From Date: <input type="text" name="from_date" id="from_date" readonly="true"></p></td>
		 <td><p>To Date: <input type="text" id="to_date" name="to_date" readonly="true"></p></td>
		 <td><p>Filter Google & Bing Searches: <input type="Checkbox" name="filter_google" value="google"></p></td>
		</tr>
		<tr>
		 <td colspan="2" align="center"><input type="submit" value="Generate Report" class="controlgrey" ></td>
		</tr>
</table>
</form>

</div>