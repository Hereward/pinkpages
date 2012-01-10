<div class="content">
<h3  ><center><b>Failed Searches</b></center></h3><br />
<form action="main.php" id="" name="" method="get" >
<input type="hidden" name="do" value="Admin" />
<input type="hidden" name="action" value="failed_searches" />
<div align="center">
						
<strong>From</strong><select name="FDate" class="width60"><option value="">-Date-</option>{$Date}</select> 
					<select name="FMonth" class="width75"><option value="">-Month-</option>{$Month}</select> 
					<select name="FYear" class="width60"><option value="">-Year-</option>{$Year}</select>
					
					
					
<strong>To</strong>  <select name="ToDate" class="width60"><option value="">-Date-</option>{$ToDate}</select> 
					<select name="ToMonth" class="width75"><option value="">-Month-</option>{$ToMonth}</select> 
					<select name="ToYear" class="width60"><option value="">-Year-</option>{$ToYear}</select> 
<input type="submit" class="btn" name="Submit" value="Go" /> 

</div><br />
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr class="h4reversed">
		 <td><b>Date</b></td>
		 <td><b>Search Type</b></td>
		 <td><b>Search Term</b></td>
		 <td><b>Suburb</b></td>
		 <td><b>Street</b></td>
		</tr>
	
	{if $count eq ''}
	 <tr>
	 <td><td><td>No records found</td></td></td>
	 </tr>
	{else}	
       {assign var="j" value=0}
     {foreach from=$values12 item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
	   <td>{$key.search_date|date_format}</td>
	   <td>{$key.search_type}</td>
	   <td>{$key.search_term}</td>
	   <td>{$key.suburb}</td>
	   <td>{$key.street}</td>

	</tr>
	 {assign var="j" value=$j+1}
    {/foreach}	
	{/if}	

</table>
</form>
<div align="center"> {include file="pagination.tpl"}</div>

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
