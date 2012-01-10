<div class="content">
<h3 align="left">Affiliate Banner Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Title</b></td>
		 <td class="h4reversed"><b>Add Date</b></td>
		 <td class="h4reversed"><b>Status</b></td>		 
        <td class="h4reversed"><b>Action</b></td>
		<td class="h4reversed"><b>Report</b></td>
		
      
 

    {assign var="j" value=0}
    {foreach from=$bannerArray item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.banner_title}</td>
		<td>{$key.add_date|date_format}</td>
		<td>{if $key.status eq '1'}<a href="#" onmousedown="changeStatus('{$change_aff_status}={$key.banner_id}')"><font color="#009900"><b>Published</b></font></a>{else}<a href="#" onmousedown="changeStatus('{$change_aff_status}={$key.banner_id}')"><font color="#FF0000"><b>Unpublished</b></font></a>{/if}</td>            
        <td><a href="{$edit_aff_url}={$key.banner_id}'" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete_aff}={$key.banner_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>
		<td><a href="{$viewReport}={$key.banner_id}"><font color="#CC3399"><b>View Report</b></font></a></td>
		

      

      
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
