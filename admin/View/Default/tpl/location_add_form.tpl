<div class="content">
<form name="form1" action="{$action}" method="post">
<ul class="textfieldlist">
<li>
   <label>Shirename</label>
<input type="text" name="shirename" value="" />
</li>
<li>
   <label>State</label>
    {foreach from=$values2 item=key}
	<select name="state">
						  <option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
	</select>	
   	{/foreach}
</li>
<li>
   <label>Town Name</label>
<input type="text" name="townname" value="" />
</li>
<li>
   <label>Postcode</label>
<input type="text" name="postcode" value="" />
</li>
</ul>
<ul class="controlbar">
<div align="center">
<input type="submit" class="controlgrey" name="submit" value="Add">
</div>
</ul>
</form>
</div>