<div class="content">
<h3 align="left"><b>Business Keywords</b></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

        <td class="h4reversed"><b>Keywords</b></td>
        <td class="h4reversed"><b>Delete</b></td>
      
 

    {assign var="j" value=0}
    {foreach from=$values item=key}
      <tr class="{if $j % 2==0}{else}odd{/if}" >
      <td><input class="saveinput" type="text" id="C_{$key.key_id}" name="key{$key.business_id}" size="60" value="{$key.keyword_name}" readonly>
	  <td>
	  	<a href="#" onmousedown="del('{$delete_business_keyword}&ID={$key.key_id}')"> <font color="#CC3399"><b>Delete</b></font></a> 
	  </td> 
       
	   
	   <!-- <td><a href="{$edit_url}&ID={$key.localclassification_id}'" ><font color="#CC3399"><b>Edit</b></a>/<a href="#" onmousedown="del('{$delete}={$key.localclassification_id}')"><font color="#CC3399"><b>Delete</b></font></a></td>  -->

       </tr>
	    {assign var="j" value=$j+1}
        {/foreach} 
</table>
<div align="center"> {include file="pagination.tpl"}<!--<a href="{$add}"><font color="#CC3399">ADD KEYWORD</font></a> --></div>
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
function editList(ID)
{
	document.getElementById("C_"+ID).removeAttribute("readonly");
	document.getElementById("B_"+ID).innerHTML="save";
	document.getElementById("A_"+ID).setAttribute("onclick", "saveList("+ID+")");
	document.getElementById("C_"+ID).setAttribute("class", "editinput");	
}
function saveList(ID)
{
    SaveKeys(ID, $F('C_'+ID));
	document.getElementById("C_"+ID).setAttribute("readonly", "true");
	document.getElementById("B_"+ID).innerHTML="edit";
	document.getElementById("A_"+ID).setAttribute("onclick", "editList("+ID+")");
	document.getElementById("C_"+ID).setAttribute("class", "saveinput");
}
</script>
{/literal}
