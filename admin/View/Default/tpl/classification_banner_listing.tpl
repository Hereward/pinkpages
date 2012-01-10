<div class="content">
<h3 align="left">Classification Banner Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     
        <td class="h4reversed"><b>Business Name</b></td>
		 <td class="h4reversed"><b>Classification</b></td>
		 <td class="h4reversed"><b>Position</b></td>
        <td class="h4reversed"><b>Banner Image</b></td>
		<td class="h4reversed"><b>Status</b></td>
        <td class="h4reversed"><b>Action</b></td>
		
      
    {assign var="j" value=0}
    {foreach from=$bannerArray item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.business_name}</td>
		<td>{$key.classification_name}</td>
		<td>{$key.position}</td>
		 
		  		{if $key.banner_name eq ''}
				<td>No Banner</td>
				{elseif $key.banner_name neq '' && $key.banner_type eq '1'}
        		<td><img src="{$BANNER_PATH}{$key.banner_name}" height="50" width="50" /></td>
				{else}
				<td>html code</td>
				{/if}
      	<td>
	  		{if $key.status eq '1'}
				<a href="#" onmousedown="changeStatus('{$change_classification_status}={$key.banner_id}','Active')"><font color="#009900"><b>Active</b></font></a>
				{else}
				<a href="#" onmousedown="changeStatus('{$change_classification_status}={$key.banner_id}','Inactive')"><font color="#FF0000"><b>Inactive</b></font></a>
				{/if}
		</td>
        <td>
				<a href="{$edit_classification_url}={$key.banner_id}" ><font color="#CC3399"><b>Edit</b></a>
				/
				<a href="#" onmousedown="del('{$delete_classification}={$key.banner_id}')"><font color="#CC3399"><b>Delete</b></font></a>
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

function changeStatus(val,status)
{

	if(status == 'Active')
	{
	var value ="Inactivate";
	}else if (status == 'Inactive'){
	var value ="Activate";
	}
	
	
	var answer = confirm  ("Are you sure,you want to "+value+" the banner?");
	if (answer)

	 window.location.href=val;
	else
		{;}

}
</script>
{/literal}
