<div class="content">
	<div align="center">
		<label><a href="{$edit_genaral}&ID={$smarty.get.ID}">Edit General Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a></label>
	</div>
<ul class="textfieldlist"> 
  <li>
     <label>
	<h3 class="h4reversed" align="center">Edit General Details</h3>
     </label>
  </li>
<form name="form1" action="{$action}={$values[0].group_id}" method="post">
<ul class="textfieldlist">
	<li>
		<label>Vertical Title<font color="#FF0000">*</font></label>
	</li>
	<li>
		<input  type="text" name="group_title" value="{$values[0].group_title}" />
	</li>
 
	<li>
		<label>Select parent vertical<font color="#FF0000">*</font></label>
	</li>
	<li>
		<select name="parent_group">
		<option value="0">--select--</option>
		{$viewGroupsForOption}
		</select>
	</li>

	<li>
		<label>Vertical Description</label>
	</li>
	<li>
		<textarea  id="field11" type="text" name="group_description" value="{$values[0].group_description}" class="textfieldshort" rows="5"/>{$values[0].group_description}</textarea>
	</li>
	
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Save" class="controlgrey" >
</div>
</ul>
</ul>
</form>
</div>