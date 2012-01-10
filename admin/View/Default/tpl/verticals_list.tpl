<div class="content">
<h3 align="left">Verticals</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      <tr>
        <td class="h4reversed"><b>Title</b></td>
        <td class="h4reversed"><b>Description</b></td>
      
        <td class="h4reversed"><b>Classifications</b></td>
        <!--<td class="h4reversed"><b>Business Phone</b></td> -->
        <td class="h4reversed"><b>Action</b></td>
		</tr>
				{if $count eq '0'}
	<tr><td></td><td></td><td>No records found</td><td></td></tr>
	{else}
      
 

    {assign var="j" value=0}
    {foreach from=$values item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.vertical_title}</td>
        <td>{$key.vertical_description}</td>
      
        
        <td>{$key.Name}</td>
        <!--<td>{$key.business_phone}</td>  -->
      


        <td><a href="{$edit_url}={$key.vertical_id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}={$key.vertical_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>

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
