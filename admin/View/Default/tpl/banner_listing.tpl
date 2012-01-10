<div class="content">
<h3 align="left">Banner Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Title</b></td>
		 <td class="h4reversed"><b>Banner Page</b></td>
        <td class="h4reversed"><b>Banner Image</b></td>
		<td class="h4reversed"><b>Status</b></td>
        <td class="h4reversed"><b>Action</b></td>
		
      
 

    {assign var="j" value=0}
    {foreach from=$bannerArray item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.banner_title}</td>
		 <td>
			{if $key.banner_page eq '0'} Home Page Footer 
			{elseif $key.banner_page eq '1'} Business Listing Page Right 
			{elseif $key.banner_page eq '2'} Category Listing Page Right
			{elseif $key.banner_page eq '3'} Category Listing Page Footer
			{elseif $key.banner_page eq '4'} Category Result Page Right
			{elseif $key.banner_page eq '5'} Category Result Page Footer
			{elseif $key.banner_page eq '6'} Map Search Page Footer
			{elseif $key.banner_page eq '7'} Browse By Category Page Right
			{elseif $key.banner_page eq '8'} Browse By Category Page Footer
			{elseif $key.banner_page eq '9'} Business Listing Page Footer
			{elseif $key.banner_page eq '10'} Business in my Street Page
			{elseif $key.banner_page eq '11'} Business Name Search age
		 {/if}
		 </td>
		 
 		{if $key.banner_name eq ''}
		<td>No Banner</td>
		{else}
        <td>
			<img src="{$BANNER_PATH}{$key.banner_name}" height="50" width="50" />
		</td>
		{/if}
      	<td>
	  		{if $key.status eq '1'}
				<a href="#" onmousedown="changeStatus('{$change_status}={$key.banner_id}&page={$key.banner_page}','Active')"><font color="#009900"><b>Active</b></font></a>
				{else}
				<a href="#" onmousedown="changeStatus('{$change_status}={$key.banner_id}&page={$key.banner_page}','Inactive')"><font color="#FF0000"><b>Inactive</b></font></a>
				{/if}
		</td>
        <td>
				<a href="{$edit_url}={$key.banner_id}'" ><font color="#CC3399"><b>Edit</b></a>
				/
				<a href="#" onmousedown="del('{$delete}={$key.banner_id}')"><font color="#CC3399"><b>Delete</b></font></a>
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
