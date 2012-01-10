<div class="content">
<h3><center><b>Page Popularity Report</b></center></h3><br />
<form action="{$pagePopularityReport}" id="" name="" method="post" >
<div align="center">
						
						<strong>From</strong><select name="FDate" class="width60"><option value="">Date</option>{$Date}</select> 
						                    <select name="FMonth" class="width75"><option value="">Month</option>{$Month}</select> 
										    <select name="FYear" class="width60"><option value="">Year</option>{$Year}</select><!-- <small>00:00:00</small> -->
						<strong>To</strong>  <select name="ToDate" class="width60"><option value="">Date</option>{$ToDate}</select> 
						                    <select name="ToMonth" class="width75"><option value="">Month</option>{$ToMonth}</select> 
										    <select name="ToYear" class="width60"><option value="">Year</option>{$ToYear}</select> <!--<small>00:00:00</small>-->
						<input type="submit" class="btn" name="Submit" value="Go" /> 
						
						</div><br />
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr class="h4reversed">
	 <td><b>Pages<b></td>
	 <td><b>Hits</b></td>
	 </tr>
		
   {if $popularityArray1Count neq '3' && $popularityArray0Count neq '3'}
	{assign var="j" value=0}
    {foreach from=$popularityArray0 item=key}
	 {if $popularityArray0.$j neq ''}
       <tr class="{if $j % 2==0}{else}odd{/if}">
		   <td >{$popularityArray1.$j}</td>
		   <td ><b>{$popularityArray0.$j}</b></td>
	   </tr>
	{/if}
	{assign var="j" value=$j+1}
    {/foreach}
	
	{else}
	{assign var="j" value=0}
	{section name=j loop=$popularityArray2}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
		   <td >{$popularityArray2[j].page_name}</td>
		   <td ><b>{$popularityArray2[j].count}</b></td>
	   </tr>
	   {assign var="j" value=$j+1}
	 {/section}
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
