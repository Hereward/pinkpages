<div class="content">
<h3 align="left">Mailing Data</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed">Name</td>
		<td class="h4reversed">Company Name</td>
		<td class="h4reversed">Email From</td>
		<td class="h4reversed">Email To</td>
		<td class="h4reversed">Phone</td>
		<td class="h4reversed">Date</td>
		<td class="h4reversed">Delete</td>
      
    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
			<td>{$key.name}</td>
			<td>{$key.company_name}</td>
			<td>{$key.email_from}</td>
			<td>{$key.email_to}</td>
			<td>{$key.phone}</td>
		
			<td>{$key.time|date_format}</td>
			<td><a href="#" onmousedown="del('{$delete_contact_us_details}&ID={$key.contact_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>
			        
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
</script>
{/literal}
