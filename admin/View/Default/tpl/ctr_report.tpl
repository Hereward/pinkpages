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
<h3><center><b>PPO CTR Report</b></center></h3>
<br />
<form action="{$action}" id="" name="classificationReport" method="post" onsubmit="return validate();">
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr>
	   <td>
         <label>Select Classification:</label>
       </td>
	   <td colspan="3">
	     <select name="classification" id="type1">
  	       <option value="0">--Select a Classification--</option>
		   {foreach from=$classifications item=key}			
		     <option id="postcode1" value="{$key.localclassification_id}" {if $classification eq $key.localclassification_name} selected="selected" {/if}>{$key.localclassification_name}</option>
		   {/foreach} 
	     </select>
	   </td>			
     </tr>					
        <tr>
		 <td><label>From Date:</label></td><td><input type="text" name="from_date" id="from_date" readonly="true"></td>
		 <td><label>To Date:  </label></td><td><input type="text" id="to_date" name="to_date" readonly="true"></td>
		</tr>
		<tr>
		 <td colspan="4" align="center"><input type="submit" value="Generate Report" class="controlgrey" ></td>
		</tr>
</table>
</form>

<form action="{$action2}" name="completeCTRReport" method="post">
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr>
	   <td align="right">
         <label><strong>FULL CTR Report: </strong></label><input type="submit" value="Generate Report" class="controlgrey">
         
       </td>
       
       <td align="left">
         <label>Total Months: </label>
         <select id="full_ctr_months" name="full_ctr_months">
  	       <option value="1">1</option>
  	       <option value="2">2</option>
  	       <option value="3">3</option>	
	     </select>
         
       </td>
       
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
</div>