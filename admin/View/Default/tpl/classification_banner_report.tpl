{literal}
<script type="text/javascript">
$j(function() {
	$j("#from_date").datepicker();
	$j('#from_date').datepicker('option', {dateFormat:'yy-mm-dd'});
	$j("#to_date").datepicker();
	$j('#to_date').datepicker('option', {dateFormat:'yy-mm-dd'});
	
	$j("#dlfrom_date").datepicker();
	$j('#dlfrom_date').datepicker('option', {dateFormat:'yy-mm-dd'});
	$j("#dlto_date").datepicker();
	$j('#dlto_date').datepicker('option', {dateFormat:'yy-mm-dd'});	
});
</script>
{/literal}

<div class="content">
<h3><center><b>Classification Banner Report</b></center></h3><br />
 <form action="{$classificationBannerReport}" id="" name="dlclassificationReport" method="post" >
  <table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td colspan="4" align="center">
	    <h3><strong>Download Markets and Classification Report<strong></h3>
	  </td>
	</tr>
    <tr>
	  <td>From Date :</td><td><input type="text" name="dlfrom_date" id="dlfrom_date" value="{$dlfrom_date}" readonly="true"></td>
	  <td>To Date :</td><td><input type="text" id="dlto_date" name="dlto_date" value="{$dlto_date}" readonly="true"></td>
	</tr>
	<tr>
	  <td colspan="4" align="center"><input type="submit" value="Download Report &nbsp;" class="controlgrey" ></td>
	</tr>
  </table> 
 </form>   

 <form action="{$classificationBannerReport}" id="" name="classificationReport" method="post" onsubmit="return validate();">
  <input type="hidden" id="path" name="path" value="{$ADMIN_SITE_PATH}" /> 
  <table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td colspan="4" align="center">
  	    <h3><strong>Markets and Classification Report<strong></h3>
	  </td>  
	</tr>  
	<tr>
	  <td>Markets :</td>	
	  <td>
	    <select class="markets" name="markets" id="markets">
    	  <option value="" selected>Select a Market</option>		 
		  {section name=row loop=$markets}
  	        <option value="{$markets[row].market_id}" {if $smarty.get.markets eq $markets[row].market_id} selected="selected" {/if} >{$markets[row].market_name}</option>              		    
		  {/section}
		</select>			
	  </td>	
	</tr>
    <tr>
	  <td>Classifications :</td>
	  <td colspan="3">
	      <select class="classifications" name="classifications" id="classifications">
    	    <option value="" selected>Select a Classification</option>		 
		    {section name=row loop=$classifications}
  	          <option value="{$classifications[row].localclassification_id}" {if $smarty.get.classifications eq $classifications[row].localclassification_name} selected="selected" {/if} >{$classifications[row].localclassification_name}</option>              		    		  
		    {/section}
	      </select>			
      </td>	  
	</tr>	
    <tr>
	  <td>From Date :</td>
	  <td><input type="text" name="from_date" id="from_date" value="{$from_date}" readonly="true"></td>
	  <td>To Date :</td>
	  <td><input type="text" id="to_date" name="to_date" value="{$to_date}" readonly="true"></td>
    </tr>	
	<tr>
	  <td colspan="4" align="center"><input type="submit" value="Generate Report" class="controlgrey" ></td>
	</tr>
  </table> 
 </form>  
 
  {if isset($from_date) && isset($to_date)}
    <table class="datatable" width="100" border="1" cellpadding="0" cellspacing="0" align="center">
  
      <tr>
	    <td colspan="4">
  	      <h3><strong>{$selectedMarkets}/{$selectedClassifications}</strong></h3>
	    </td>
	  </tr>
      <tr>		  
	    <td>Dates</td>
	  
	    <td width="25%">&nbsp;</td>
	    <td width="25%">&nbsp;</td>	  
	    <td width="25%">&nbsp;</td>	  
	  </tr>	  
      {$onlineReport}
    </table>
  {/if} 

</div>

{literal}
<script language="javascript">
function validate()
{
	var from_date         = document.classificationReport.from_date.value;
	var to_date           = document.classificationReport.to_date.value;
	var markets           = document.classificationReport.markets.value;
	var classifications   = document.classificationReport.classifications.value;	

	if(markets == "")
	{
	  alert('Please select a Market!!');
      document.classificationReport.markets	  
	  return false;
	}
	
	if(classifications == "")
	{
	  alert('Please select a Classification!!');
      document.classificationReport.classifications	  
	  return false;
	}	
		
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

