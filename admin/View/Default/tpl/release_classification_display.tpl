
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
	  {elseif $msg eq '7'}	
	 <div class="er-message"> <img src="{$IMAGES_PATH}alert.png" alt="" />Classification release successfully!!</div><ul></ul>
	 {/if}
<h3  align="center"><b>CLASSIFICATIONS</b></h3>

 
<table class="datatable">

 <tr>
    <td class="h4reversed"><b>Classification</b></td>
	 <td class="h4reversed"><b>Release</b></td>

	 
 </tr>
 
 	{if $count eq '0'}
	
	<tr><td align="center" colspan="2">No records</td></tr>
		
	{/if}
 
    {assign var="j" value=0}
    {foreach  from=$values item=key}
  <tr class="{if $j % 2==0}{else}odd{/if}" id="{$key.localclassification_id}">
      <td >{$key.localclassification_name}</td>
	  <td><a href="{$releaseClassification}={$key.localclassification_id}">release</a></td>
	  
	 
  </tr>	
    {assign var="j" value=$j+1} 
    {/foreach}
</table> 
  <div align="center"> {include file="pagination.tpl"}</div>
</div> 
