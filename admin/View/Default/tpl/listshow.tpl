<div class="content">
<h3 align="left">Business Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed"><b>Business ID</b></td>
		<td class="h4reversed"><b>Name</b></td>
		<td class="h4reversed"><b>Suburb</b></td>
		<td class="h4reversed"><b>Details</b></td>
		<td class="h4reversed"><b>Classifications</b></td>
		<td class="h4reversed"><b>Rank</b></td>
		<td class="h4reversed"><b>Action</b></td>
		<td class="h4reversed"><b>Report</b></td>
		<td class="h4reversed"><b>History</b></td>
      
 		{if $count eq '0'}
	<tr ><td></td><td></td><td></td><td>No records found</td></tr>
	{else}

    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
			<td>{$key.business_id}</td>
			<td><a href="main.php?do=Admin&action=showClientDetails&client_id=0&business_id={$key.business_id}">{$key.business_name}</a></td>
			<!--<td><a href="{$add_card}={$key.business_id}">{$key.business_name}</a></td>-->
			<td>{$key.business_suburb}</td>
			<td><a href="{$edit_url}&ID={$key.business_id}" >edit</a></td>
			<td><a href="{$edit_classification}&ID={$key.business_id}" >edit</a></td>
			<td><a href="{$edit_rank}&ID={$key.business_id}" >Rank</a></td>
			<td><a href="#" onmousedown="del('{$delete}={$key.business_id}')">delete</a></td>
			<td><a href="main.php?do=Listing&action=report&business_id={$key.business_id}&to_date={$key.business_adddate}" target="_new">view</a></td>            
			<td><a href="{$view_history}={$key.business_id}&edit_type=general" target="_new">view</a></td>          
    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}
	{/if}
</table>
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
