<div class="content">
<h3 align="left">Rank Rate</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
		<td class="h4reversed"><b>Rank</b></td>
		<td class="h4reversed"><b>Rate</b></td>      
		<td class="h4reversed" align="right"><b>Action</b></td>
		
      
 

    {assign var="j" value=0}
    {foreach from=$rankResult item=key}
     <tr class="{if $j % 2==0}{else}odd{/if}">
      
	<td>{$key.rank}</td>
	<td><input type="text" id="C_{$key.rank}" name="key{$key.localclassification_id}" value="{$key.rate}" readonly></td>
	<td align="right"><a id="A_{$key.rank}" href="#" onClick="editList('{$key.rank}');" ><font color="#CC3399"><b id="B_{$key.rank}">Edit</b></font></a></td>

    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}
</table>
<div align="center"> {include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
function editList(ID)
{
	document.getElementById("C_"+ID).removeAttribute("readonly");
	document.getElementById("B_"+ID).innerHTML="Save";
	document.getElementById("A_"+ID).setAttribute("onclick", "saveList("+ID+")");
}
function saveList(ID)
{
    saveRate(ID, $F('C_'+ID));
	document.getElementById("C_"+ID).setAttribute("readonly", "true");
	document.getElementById("C_"+ID).setAttribute("border","none");
	document.getElementById("B_"+ID).innerHTML="Edit";
	document.getElementById("A_"+ID).setAttribute("onclick", "editList("+ID+")");	
}

</script>
{/literal}
