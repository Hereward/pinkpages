<div class="content">
<h3  ><center><b> Site Statistics</b></center></h3><br />
<table class="datatable" width="100" border="0" cellpadding="10" cellspacing="0" align="center">
{*
<tr><td style="font-size: 12px; font-weight:bold;" >

You can run the "Classification - Region - Report" This will download an Excel spreadsheet which tells 
you how many people performed a search for a specific classifcation (Keyword Search) in a particular region. 
The totals at the bottom of the page are a tally of how many times a region was looked at. 
The totals on the right hand side are how many times a specific classifcation has been looked at. More 
reports will be added over the coming weeeks. If you have a particular report request please speak with Graham Cattley. 


Please use the links on the right to perform report functions.
</td></tr></table>
*}

<h3 style="color:red;">Please use the links on the right to perform report functions.</h3>
 
 {*
 <form action="{$sitePerformanceReport}" id="" name="" method="post" >
<div align="center">
						
						<strong>From</strong><select name="FDate" class="width60"><option value="">Date</option>{$Date}</select> 
						                    <select name="FMonth" class="width75"><option value="">Month</option>{$Month}</select> 
										    <select name="FYear" class="width60"><option value="">Year</option>{$Year}</select>
						<strong>To</strong>  <select name="ToDate" class="width60"><option value="">Date</option>{$ToDate}</select> 
						                    <select name="ToMonth" class="width75"><option value="">Month</option>{$ToMonth}</select> 
										    <select name="ToYear" class="width60"><option value="">Year</option>{$ToYear}</select>
						<input type="submit" class="btn" name="Submit" value="Go" /> 
						
						</div> <br />
						
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr class="h4reversed">
		 <td><b>Report</b></td>
		 <td><b>Count</b></td>
		</tr>
       <tr>
		   <td class="odd">Unique Visitors</td>
		   <td class="odd"><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].unique_visitors}{else}{$values.0}{/if}</b></td>
	   </tr>
      
        <tr>
			<td class="">Total Visits</td>
			<td><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].total_visits}{else}{$values.1}{/if}</b></td>
		</tr>
		
        <tr>
			<td class="odd">Total Visit Home Page</td>
			<td class="odd"><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].total_visit_home_page}{else}{$values.2}{/if}</b></td>
		</tr>
		
		<tr>
			<td class="">Unique Visit Home Page</td>
			<td><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].unique_visit_home_page}{else}{$values.3}{/if}</b></td>
		</tr>
		
		 <tr>
			 <td class="odd">Average Number of search performed by the user</td>
			 <td class="odd"><b>{if $AvgCount eq ''} 0  {if $AvgDateWiseCount eq ''} 0 {else}{$AvgDateWiseCount}   {/if}{else}{$AvgCount}{/if}</b></td>
		 </tr> 
		 
		<tr>
			<td class="">Total Number of Search Performed on site</td>
			<td class=""><b>{if $totalCount1 eq ''} {$totalCount} {else} {$totalCount1}{/if}</b></td>
		</tr>
		
		<tr>
			<td class="odd">Total Number of times Business Details Viewed</td>
			<td class="odd"><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].count_business_views}{else}{$values.4}{/if}</b></td>
		</tr>
		
		<tr>
			<td class="">Number of Failed Searches</td>
			<td class=""><b>{if $values[0].datereport eq '0000-00-00'}{$values[0].failed_searches}{else}{$values.5}{/if}</b></td>
		</tr>
		

</table> 
</form> 
<div align="center"> {include file="pagination.tpl"}</div>
*}
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(val)
{
	var answer = confirm  ("Are you sure,you want to delete?");
	if (answer)
	 window.location.href=val;
	else
		{;}

}
</script>
{/literal}
