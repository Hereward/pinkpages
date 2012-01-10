<div class="content">
<h3 align="left">Banner Report</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
		<td class="h4reversed"><b>Date</b></td>
		<td class="h4reversed"><b>Total Clicks</b></td>
		<td class="h4reversed"><b>Total Views</b></td>
		<td class="h4reversed"><b>CTR</b></td>
		
		{if $count eq '0'}
		
		<tr><td></td><td></td><td>No records found</td><td></td></tr>
		{/if}

    {assign var="j" value=0}
    {foreach from=$bannerArray item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

        <td><a href="{$link_date}={$key.day}&ID={$smarty.get.ID}">{$key.day|date_format}</a></td>
        <td>{$key.click}</td>
        <td>{$key.view}</td>
		<td>{math equation="x/y" x=$key.click y=$key.view format="%.2f"}</td>
		      
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
