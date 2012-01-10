<div class="content">
<h3 align="center"><b>Team Members</b></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
    

        <td class="h4reversed"><b>First Name</b></td>
        <td class="h4reversed"><b>Email</b></td>
        <td class="h4reversed"><b>Username</b></td>
        <td class="h4reversed"><b>Access</b></td>
		<td class="h4reversed"><b>Change Access</b></td>
        <td class="h4reversed"><b>Edit</b></td>
        <td class="h4reversed"><b>Status</b></td>
		<td class="h4reversed" align="right"><b>Permission</b></td>

  {if $count eq '0'}
	<tr><td></td><td></td><td>No records found</td><td></td></tr>
	{else}
	{assign var="j" value=0}
    {foreach from=$values item=key}
    <tr class="{if $j % 2==0}{else}odd{/if}">

        <td>{$key.localuser_firstname}</td>        
        <td >{$key.localuser_email}</td>
        <td>{$key.localuser_username}</td>
        <td>{$key.localuser_access}</td>
		<td><a href="{$changeAccess}={$key.localuser_id}&name={$key.localuser_firstname}">edit</a></td>
		
       <!-- <td>{if $key.localuser_status eq '1'}Active{else}Inactive{/if}</td>-->
		
        <td><a href="{$edit_url}={$key.localuser_id}'" ><font color="#CC3399"><b>edit</b></font></a><font color="#CC3399"><b><!--/</b></font><a href="{$delete}={$key.localuser_id}"><font color="#CC3399"><b>Change Status</b></font></a>--></td>
		
		<td>{if $key.localuser_status eq '1'}<a href="#" onmousedown="changeStatus('{$delete}={$key.localuser_id}')"><font color="#009900"><b>Active</b></font></a>{else}<a href="#" onmousedown="changeStatus('{$delete}={$key.localuser_id}')"><font color="#FF0000"><b>Inactive</b></font></a>{/if}</td>
		<td align="center"><a href="{$setPermission}={$key.localuser_id}&name={$key.localuser_firstname}">edit</a></td>
      
	    <!--<td><a href="{$edit_url}={$key.localuser_id}'" ><font color="#CC3399"><b>Edit</b></font></a><font color="#CC3399"><b>/</b></font><a href="#" onmousedown="del('{$delete}={$key.localuser_id}')"><font color="#CC3399"><b>Change Status</b></font></a></td> -->
    </tr>
	{assign var="j" value=$j+1}
    {/foreach}
	{/if}
</table>

<div align="center">{include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(val)
{

	var answer = confirm  ("Are you sure,you want to Change the Status?");
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