{if $msg eq '1'}
	 <div class="er-message">   <img src="{$IMAGES_PATH}alert.png" alt="" /> Added Successfully</div><ul></ul>
     {elseif $msg eq '2'}	
	<div class="er-message">	<img src="{$IMAGES_PATH}alert.png" alt="" /> Already Exists!! please try some other name</div>        <ul></ul> 
	 {elseif $msg eq '3'}	
	 <div class="er-message">   <img src="{$IMAGES_PATH}alert.png" alt="" /> Deleted Successfully</div><ul></ul>
	 {elseif $msg eq '4'}	
	<div class="er-message">   <img src="{$IMAGES_PATH}alert.png" alt="" /> Updated Successfully</div><ul></ul>	
	 {/if}
<div class="content">
<!--<h4 class="h4reversed" align="center"><b>Locations</b></h4> -->
<h3 align="left">LOCATIONS</h3> 

<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     
        <td class="h4reversed"><b>Shire Name</b></td>
        <td class="h4reversed"><b>Shire Town</b></td>
        <td class="h4reversed"><b>Postcode</b></td>
        <td class="h4reversed"><b>Edit</b></td>
        <td class="h4reversed" align="right"><b>Delete Town</b></td>
	 {if $count eq '0'}
	<tr><td></td><td>No records found</td><td></td><td></td></tr>
	{else}	
    {assign var="j" value=0}
    {foreach from=$values item=key}
    <tr class="{if $j % 2==0}{else}odd{/if}">
        <td>{$key.shirename_shirename}</td>
        <td>{$key.shiretown_townname}</td>
        <td>{$key.shiretown_postcode}</td>
        <td>
			<a href="{$edit_url}={$key.shiretown_id}" > <font  color="#CC3399"><b>Edit</b></font></a>
		</td>
		<td align="right">
			<a href="{$deleteTown}={$key.shiretown_id}" ><font color="#CC3399"><b>Delete</b></font></a>
		</td>
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







<!--<div class="content">
<table class="datatable"  border="0" cellpadding="0" cellspacing="0">
 <tr> -->
    <!--<td class="h4reversed">SHIRES</td> -->
    <!--<td class="h4reversed">TOWNS</td>
	 {if $msg eq '1'}
	    <div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Added Successfully</div><ul></ul> -->
    <!-- {elseif $msg eq '2'}	
		<div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Already Exists!! please try some other name</div>        <ul></ul>
	 {elseif $msg eq '3'}	
	    <div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Deleted Successfully</div><ul></ul> 
	 {/if}
 </tr>	
</table>
<table class="datatable" border="0">
    {assign var="j" value=0}
    {foreach  from=$values item=key}
  <tr class="{if $j % 2==0}{else}odd{/if}" id="{$key.shirename_id}">
      <td ><input type="text" id="C_{$key.shirename_id}" name="keyword{$key.shirename_id}" value=            "{$key.shiretown_townname}" readonly>
	  
	  <td><a id="A_{$key.shirename_id}" href="#" onClick="editList('{$key.shirename_id}');" ><font color="#CC3399"><b id="B_{$key.shirename_id}">edit</b></font></a>/<a href="{$delete}={$key.shirename_id}" onClick="alert('want to delete?');" ><font color="#CC3399"><b>Delete</b></font>
	  </td>
  </tr>	
    {assign var="j" value=$j+1} 
    {/foreach}
   <td>
 </tr>
</table>
<div align="center"> {include file="pagination.tpl"}<a href="{$LocationFormShow_shirenames}">ADD SHIRES</a>
</div>
{literal}
<script language="javascript">
function editList(ID)
{   
    document.getElementById("C_"+ID).removeAttribute("readonly");
	document.getElementById("B_"+ID).innerHTML="save";
	document.getElementById("A_"+ID).setAttribute("onclick", "saveList("+ID+")");
}
function saveList(ID)
{
    SaveLocations(ID, $F('C_'+ID));
	document.getElementById("C_"+ID).setAttribute("readonly", "true");
	document.getElementById("B_"+ID).innerHTML="edit";
	document.getElementById("A_"+ID).setAttribute("onclick", "editList("+ID+")");	
}

</script>
{/literal}-->

<!--<div class="content">
<table class="datatable"  border="0" cellpadding="0" cellspacing="0">
 <tr>
    <td class="h4reversed">LOCATIONS</td>
	 {if $msg eq '1'}
	    <div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Added Successfully</div><ul></ul>
     {elseif $msg eq '2'}	
		<div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Already Exists!! please try some other name</div>        <ul></ul>
	 {elseif $msg eq '3'}	
	    <div class="er-image"><img src="{$IMAGES_PATH}alert.png" alt="" />Keyword Deleted Successfully</div><ul></ul>
	 {/if}
 </tr>	
</table>
 
<table class="datatable"  border="0" cellpadding="0" cellspacing="0">
    {assign var="j" value=0}
    {foreach  from=$values item=key}
  <tr class="{if $j % 2==0}{else}odd{/if}" id="{$key.localclassification_id}">
      <td ><input type="text" id="C_{$key.localclassification_id}" name="keyword{$key.localclassification_id}" value=            "{$key.localclassification_name}" readonly>
	  </td>
	  <td><a id="A_{$key.localclassification_id}" href="#" onClick="editList('{$key.localclassification_id}');" ><font color="#CC3399"><b id="B_{$key.localclassification_id}">edit</b></font></a>/<a href="{$delete}={$key.localclassification_id}" onClick="alert('want to delete?');" ><font color="#CC3399"><b>Delete</b></font>
	  </td>
  </tr>	
    {assign var="j" value=$j+1} 
    {/foreach}
</table> 
  <div align="center"> {include file="pagination.tpl"}<a href="{$addKeyword}"><font color="#CC3399">ADD KEYWORD</font></a></div>
</div> -->

 