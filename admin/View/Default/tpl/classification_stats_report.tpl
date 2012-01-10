<div class="content">
<h3  ><center><b>Classification Stats</b></center></h3><br />
<form action="{$classificationStats}" id="" name="" method="post" >
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
		 <td><b>Classification Name</b></td>
		  <td><b>Total Visits</b></td>
		 <td><b>Unique Visits</b></td>
		</tr>
      {if $count eq ''}
	   <tr align="center">
	     <td>No records found.</td>
	   </tr> 
	  {else} 
	 {assign var="j" value=0}
     {foreach from=$uniqueClass item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
	   <td>{$key.classification_name}</td>
	    <td>{if $key.total_vists neq ''}{$key.total_vists}{else} {$key.tv}{/if}</td>
	   <td>{if $key.unique_visits neq ''}{$key.unique_visits}{else} {$key.uv}{/if}</td>
	   
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
