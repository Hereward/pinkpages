<div class="content">
<ul class="textfieldlist"> 
  <li>
     <label>
	<h4 class="h4reversed" align="center"><strong>Add Shire</strong></h4>
     </label>
  </li>
  <form name="form1" action="{$action}" method="post">
    <ul class="textfieldlist">
      <li>
        <label>Shirename <font color="#FF0000">*</font></label>
          <input type="text" name="shirename" value="" />
      </li>
	  
	  <li>
        <label>Region code <font color="#FF0000">*</font></label>
          <input type="text" name="regioncode" value="" />
      </li>
	  
      <li>
        <label>State</label>
	      <select name="state">		
          {foreach from=$values2 item=key}
			<option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
   	      {/foreach}
	      </select>			  
      </li>
	  </ul>
	  <ul class="controlbar">
	  <div align="center">
           <input type="submit" class="controlgrey" name="submit" value="Add" onClick="return validate();">
	</div>
    </ul>
  </form>
</div>
<!--{literal}
<script language="javascript">
function validate()
{

	if(document.form1.shirename.value == "")
	{
	alert('Please Enter the Shire Name ');
	document.form1.shirename.focus();
	return false;
	}
	return true;
}  
</script>
{/literal} -->