<div class="content">
<h3 align="center">Manage Permission <font style=" text-transform:uppercase">({$smarty.get.name})</font></h3>
<form name="permission" action="{$action}={$smarty.get.localuser_id}&name={$smarty.get.name}" method="post">
<table>
<tr>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
    

        <td class="h4reversed"><b>Permission Name</b></td>
        <td class="h4reversed"><b><input type="checkbox" onclick="CheckAll(this)" /></b></td>
       



	{assign var="j" value=0}
 
	{section name=j loop=$permissionResult}
	

    <tr class="{if $j % 2==0}{else}odd{/if}">

        <td>{$permissionResult[j].permission_name}</td>        
        <td>
		<input type="checkbox" name="permission[]" value="{$permissionResult[j].permission_id}" {if $permissionResult[j].check eq '1'} checked="checked" {/if} />
		</td>

     
    </tr>
	
	{assign var="j" value=$j+1}
   {/section}
</table>
</tr>

<ul class="controlbar">
<div align="center">
    <input class="controlgrey" name="addPermission" type="submit" value="Update" />
</div>
   
</ul>
</tr>


</table>
</form>

<div align="center">{include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
function CheckAll(chk)
    {

    for (var i=0;i < document.permission.elements.length;i++)
        {
            var e = document.permission.elements[i];
            if (e.type == "checkbox")
            {
                e.checked = chk.checked;
            }
        }
    }
</script>
{/literal}