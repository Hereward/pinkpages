<div class="content">
<h3 align="left">Business Listings</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b> Name</b></td>
        <td class="h4reversed"><b> Email</b></td>
      
        <td class="h4reversed"><b> Postcode</b></td>
        <td class="h4reversed"><b> Phone</b></td>
		<td class="h4reversed"><b> Status</b></td>
        <td class="h4reversed"><b>Action</b></td>
      
 

    {assign var="j" value=0}
    {foreach from=$values item=key}
	
     <tr class="{if $j % 2==0}{else}odd{/if}">
       <td><font color="#006600"><b>{$key.client_name}</b></font></td>
       <td><font color="#006600"><b>{$key.email}</b></font></td>
       <td><font color="#006600"><b>{$key.postcode}</b></font></td>
       <td><font color="#006600"><b>{$key.phone}</b></font></td>
       <td><font color="#006600"><b>{$key.status}</b></font></td>
	        <!--<td><a href="{$edit_url}&ID={$key.business_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}={$key.business_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>  -->

       <td><a href="{$edit_url}&ID={$key.client_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="{$delete}={$key.client_id}"><font color="#CC3399"><b>Delete</b></font></a></td>


      
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
