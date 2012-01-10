{literal}
<script type="text/javascript">
$j(function() {
	$j("#from_date").datepicker();
	$j('#from_date').datepicker('option', {dateFormat:'yy-mm-dd'});
	$j("#to_date").datepicker();
	$j('#to_date').datepicker('option', {dateFormat:'yy-mm-dd'});
});
</script>

{/literal}
<div class="content">
<h3><center><b>Classification views statistics (Region wise)</b></center></h3>
<br />
<form action="{$class_region_report}" id="" name="classificationReport" method="post" onsubmit="return validate();">
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
{literal}
<script language="javascript">
function validate()
{
	var from_date = document.classificationReport.from_date.value;
	var to_date = document.classificationReport.to_date.value;
	if(from_date == "" )
	{
		alert('Please Enter From Date!!');
		document.classificationReport.from_date.focus();
		return false;
	}
	else if(to_date == "" )
	{
		alert('Please Enter To Date!!');
		document.classificationReport.to_date.focus();
		return false;
	}
	if(CompareDates(from_date, to_date)) {
		alert('To date must be greater than or equal to from date!!');
		return false;
	}
	return true;
}
function CompareDates(str1, str2)
{
   var dt1   = parseInt(str1.substring(8,10),10);
   var mon1  = parseInt(str1.substring(5,7),10);
   var yr1   = parseInt(str1.substring(0,4),10);
   var dt2   = parseInt(str2.substring(8,10),10);
   var mon2  = parseInt(str2.substring(5,7),10);
   var yr2   = parseInt(str2.substring(0,4),10);
   var date1 = new Date(yr1, mon1, dt1);
   var date2 = new Date(yr2, mon2, dt2);

   if(date2 < date1)
   {
      return true;
   }
   else
   {
      return false;
   }
} 
</script>
{/literal}
