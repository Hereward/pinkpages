<div class="content">
<h3 align="left"><b>Site Configure Manager</b></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Area</b></td>
		<td class="h4reversed"><b>Value</b></td>
		<td class="h4reversed"><b>Edit</b></td>

    {assign var="j" value=0}
	{foreach from=$site_config_manager item=key}
      <tr class="{if $j % 2==0}{else}odd{/if}" >
	  <td>{if $key.action eq '1'} Listings Under Minimum Visits {else if $key.action eq '2'} Notification Period (In Days) {/if}</td>
      <td><input class="saveinput" type="text" id="text{$key.action}" name="text{$key.action}" size="60" value="{$key.min_count}" readonly>
   	  
	  <td>
	  <a id="A{$key.action}" href="#" onClick="editList('{$key.action}');" ><font color="#CC3399"><b id="B{$key.action}">edit</b></font></a>
	  </td>
	  
	  
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
	document.getElementById("text"+ID).removeAttribute("readonly");
	document.getElementById("B"+ID).innerHTML="save";
	document.getElementById("A"+ID).setAttribute("onclick", "saveList("+ID+")");
	document.getElementById("text"+ID).setAttribute("class", "editinput");	
}
function saveList(ID)
{
    SaveConfigValue(ID, $F("text"+ID));
	document.getElementById("text"+ID).setAttribute("readonly", "true");
	document.getElementById("B"+ID).innerHTML="edit";
	document.getElementById("A"+ID).setAttribute("onclick", "editList("+ID+")");
	document.getElementById("text"+ID).setAttribute("class", "saveinput");
}
</script>
{/literal}
