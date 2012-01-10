<div class="content">
<ul class="textfieldlist"> 
  <li>
     <label>
	<h3 class="h4reversed" align="center"><b>Edit Vertical</b></h3>
     </label>
  </li>
<form name="form1" action="{$action}={$values[0].vertical_id}" method="post">
<ul class="textfieldlist">
 <li>
   <label>VERTICAL TITLE</label>
      <input  type="text" name="vertical_title" value="{$values[0].vertical_title}" />
 </li>
 <li>
   <label>VERTICAL DESCRIPTION</label>
     <textarea  id="field11" type="text" name="vertical_description" value="{$values[0].vertical_description}" class="textfieldshort" rows="5"/>{$values[0].vertical_description}</textarea>
 </li>
  <li>
    <label>CLASSIFICATIONS</label>
    
	<select name="classification[]" id="type1" multiple="multiple" size="6">
	                <option value="select" ><b>--Select--</b></option>
					   
					 {$optionInput}
					</select>
   	
 </li>
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="SUBMIT" class="controlgrey" >
</div>
</ul>
</ul>
</form>
</div>