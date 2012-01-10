<div class="content">
<ul class="textfieldlist"> 
  <li>
     <label>
	<h3 class="h4reversed" align="center"><b>Add Vertical</b></h3>
     </label>
  </li>
<form name="form1" action="{$action1}" method="post" enctype="multipart/form-data">
<ul class="textfieldlist">
<li>
   <label>Vertical Title<font color="#FF0000">*</font></label>
<input type="text" name="group_title" value="{$group_title}" />
</li>
<li>
   <label>Select parent vertical<font color="#FF0000">*</font></label>
  <select name="parent_group">
<option value="0">--select--</option>
{$viewGroupsForOption}
</select>
</li>
<li>
   <label>Vertical Description</label>
<textarea  id="field11" type="text" name="group_description" value="{$group_description}" class="textfieldshort" rows="5"/>{$group_description}</textarea>
</li>
<li>
   <label>Classifications<h5>(Press and Hold ctrl to select many)</h5></label>
 
	<select name="classification[]" id="type1" multiple="multiple" size="6" >
	                <option value="" selected="selected">--Select--</option>
					 {foreach from=$values1 item=key}			
			              <option id="postcode1" value="{$key.localclassification_id}" {if $classification eq $key.localclassification_name} selected="selected" {/if}>{$key.localclassification_name}
						  </option>
					  {/foreach} 
					</select>
   	
	
</li>
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Add" class="controlgrey" >
</div>
</form></ul>
</div>