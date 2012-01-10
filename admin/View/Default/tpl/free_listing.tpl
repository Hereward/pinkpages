<div class="content">
<h3 align="left">Free Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Business Name</b></td>
        <td class="h4reversed"><b>Classification</b></td>
      
        <td class="h4reversed"><b>Keywords</b></td>
		<td class="h4reversed"><b>Add Date</b></td>
        <td class="h4reversed"><b>Action</b></td>
      
 		{if $count eq '0'}
	<tr><td></td><td></td><td>No records found</td><td></td></tr>
	{else}
 
    {assign var="j" value=0}
    {foreach from=$values item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.business_name}</td>
        <td>{$key.localclassification_name}</td>
      
        <td>{$key.Key}</td>
      
        <td>{if $key.business_adddate|date_format eq 'Nov 30, 1999'}&nbsp;{else}{$key.business_adddate|date_format}{/if}</td>
       
      

<td><a href="{$edit_url}&ID={$key.business_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="{$delete}={$key.business_id}" ><font color="#CC3399"><b>Delete</b></font></a></td>
       <!-- <td><a href="{$edit_url}&ID={$key.business_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}={$key.business_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>
 -->
      

      
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
