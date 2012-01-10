<div class="content">
	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit Brands & Services</a> | </label>
		<label><a href="{$manageHoursDays}&ID={$smarty.get.ID}">Edit Hours and Payment</a></label>
	</div>
	<br />
<div><h3 align="center" style="margin-left:250px;">Manage Addresses&nbsp;<label style="margin-left:150px;"><a href="{$addMoreAddresses}={$smarty.get.ID}">Add more Address</a></label></h3></div>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed"><b>Street1</b></td>
		<td class="h4reversed"><b>Street2</b></td>
		<td class="h4reversed"><b>Shire Name</b></td>
		<td class="h4reversed"><b>Suburb</b></td>
		<td class="h4reversed"><b>State</b></td>
		<td class="h4reversed"><b>Postcode</b></td>
		
		<td class="h4reversed"><b>Action</b></td>
      
 		{if $count eq '0'}
	<tr ><td></td><td></td><td></td><td>No records found</td></tr>
	{else}

    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
			
			<td>{$key.business_street1}</td>
			<td>{$key.business_street2}</td>
			<td>{$key.shirename_shirename}</td>			
			<td>{$key.shiretown_townname}</td>
			<td>{$key.business_state}</td>
			<td>{$key.business_postcode}</td>
			<td><a href="{$editurl}&ID1={$key.id}&ID={$key.business_id}" ><font color="#CC3399"><b>edit</b></font></a>/<a href="#" onmousedown="del('{$delete}&ID1={$key.id}&ID={$key.business_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>
			
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