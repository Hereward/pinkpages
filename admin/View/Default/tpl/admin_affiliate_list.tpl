<div class="content">
<h3 align="left">Affiliates</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <td class="h4reversed"><b> First Name</b></td>
		<td class="h4reversed"><b> Email</b></td>
        <td class="h4reversed"><b> Company Name</b></td>
        <td class="h4reversed"><b> Phone</b></td>
		<td class="h4reversed"><b> Edit</b></td> 
        <td class="h4reversed"><b>Status</b></td>
    {assign var="j" value=0}
    {foreach from=$values item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
     	<td>{$key.fname}</td>
		<td>{$key.email}</td>
		<td>{$key.company_name}</td>
		<td>{$key.phone}</td>
		<td><a href="{$editaffiliate}={$key.affiliate_id}" ><font color="#CC3399"><b>Edit</b></font></a></td>
		<td>
		{if $key.status eq '1'}
		<a href="#" onmousedown="changeStatus('{$deleteaffiliate}={$key.affiliate_id}')"><font color="#009900"><b>Active</b></font></a>
		{else}
		<a href="#" onmousedown="changeStatus('{$deleteaffiliate}={$key.affiliate_id}')"><font color="#FF0000"><b>Inactive</b></font></a>
		{/if}
		</td>

    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}
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

function changeStatus(val)
{
	
	var answer = confirm  ("Are you sure,you want to change the status?");
	if (answer)

	 window.location.href=val;
	else
		{;}

}
</script>
{/literal}
