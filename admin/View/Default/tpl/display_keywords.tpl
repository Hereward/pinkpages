
<div class="content">
<link href="../Style/admin_stylesheet.css" rel="stylesheet" type="text/css" />
{if $msg eq '1'}
	<div class="er-message"> <img src="{$IMAGES_PATH}alert.png" alt="" />Classification Added Successfully</div><ul></ul>
     {elseif $msg eq '2'}	
	<div class="er-message"><img src="{$IMAGES_PATH}alert.png" alt="" />Classification Already Exists!! please try some other name</div>d<ul></ul>
	 {elseif $msg eq '3'}	
	 <div class="er-message"> <img src="{$IMAGES_PATH}alert.png" alt="" />Classification Deleted Successfully</div><ul></ul>
	 {elseif $msg eq '4'}	
	 <div class="er-message"> <img src="{$IMAGES_PATH}alert.png" alt="" />Can't delete! One or more business is associated with this classification!</div><ul></ul>
	 {/if}
<h3  align="center"><b>CLASSIFICATIONS</b></h3>

 
<table class="datatable">

 <tr>
    <td class="h4reversed"><b>Classification</b></td>
	 <td class="h4reversed"><b>Suppress</b></td>
	<!--<td class="h4reversed" style="margin-right:20px"><b>Edit</b></td>
	<td class="h4reversed"  style=" margin-right:10px"><b>Delete</b></td>-->
	 
 </tr>	
 
    {assign var="j" value=0}
    {foreach  from=$values item=key}
  <tr class="{if $j % 2==0}{else}odd{/if}" id="{$key.localclassification_id}">
      <td >{$key.localclassification_name}
	 <!-- <input class="saveinput" type="text" id="C_{$key.localclassification_id}" name="keyword{$key.localclassification_id}" value=            "{$key.localclassification_name}" size="60" readonly >-->
	  </td>
	  <td><a href="{$supressClassification}={$key.localclassification_id}">suppress</a></td>
	  
	  <!--<td align="">
			<a id="A_{$key.localclassification_id}" href="#" onClick="editList('{$key.localclassification_id}');" ><font color="#CC3399"><b id="B_{$key.localclassification_id}">edit</b></font></a>
	  </td>
	  
	  <td align="">
			<a href="#" onmousedown="del('{$delete}={$key.localclassification_id}')"> <font color="#CC3399"><b>Delete</b></font></a>
	  </td>-->
  </tr>	
    {assign var="j" value=$j+1} 
    {/foreach}
</table> 
  <div align="center"> {include file="pagination.tpl"}<!--<a href="{$addKeyword}"><font color="#CC3399">ADD CLASSIFICATION</font></a> --></div>
</div> 
