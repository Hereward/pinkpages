<div class="content">
<h3 align="left">Classification Display </h3>
<form name="list" action="{$action}" method="post">
<table class="datatable" width="50%" border="0" cellpadding="0" cellspacing="0" align="center" >
   <tr>
      <td class="h4reversed" colspan="">Classification Name</td>
   </tr>
   {assign var="j" value=1}
 {section name=listing loop=$values start=1 step=1}
 <input type="hidden" name="total" value="{$j}" />
 <!-- <tr><td colspan=""><input type="checkbox" name="insert_{$j}" id="insert" value="1" />
		  
  </td> -->
    <td colspan="">{$values[listing].0}<input type="hidden" name="classificationName{$j}" value="{$values[listing].0}" /></td>
	
</tr>
   {assign var="j" value=$j+1}
  {/section}
</table>
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Import" class="controlgrey" />
</div>
</ul>
</div>




















