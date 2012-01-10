<div class="content">
<h3 align="left">Clients Under Minimum Visits</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Business Name</b></td>
		 <td class="h4reversed"><b>Count</b></td>
		
		
      
 

    {assign var="j" value=0}
    {foreach from=$min_visits item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.name}</td>
		<td>{$key.count}</td>
		 
 		
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
