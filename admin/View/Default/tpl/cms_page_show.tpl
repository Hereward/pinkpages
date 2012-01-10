<div class="content">
<h3 align="left">Content Pages</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <td class="h4reversed"><b>Meta Description</b></td>
        <td class="h4reversed"><b>Meta Tag</b></td>
        <td class="h4reversed"><b>Title Tag</b></td>
        <td class="h4reversed"><b>Page Title</b></td>
        <td class="h4reversed"><b>Action</b></td>
    {assign var="j" value=0} 
    {foreach from=$values1 item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}"> 
        <td>{$key.meta_description}</td>
        <td>{$key.meta_tag}</td>
        <td>{$key.title_tag}</td>
        <td>{$key.page_title}</td>
	    <td><a href="{$edit_url}&ID={$key.id}" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}&ID={$key.id}')"><font color="#CC3399"><b>Delete</b></font></a></td>
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
