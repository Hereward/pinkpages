<div class="content">
<h3 align="left">CLASSIFICATIONS</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<td class="h4reversed"><b>Classification</b></td>
		 <td class="h4reversed"><b>Suppress</b></td>
      
 		{if $count eq '0'}
	<tr ><td align="center">No records found</td></tr>
	{else}

    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
			<td>{$key.localclassification_name}</td>
			 <td><a href="{$supressClassification}={$key.localclassification_id}">suppress</a></td>
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
