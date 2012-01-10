<div class="content">
<ul class="textfieldlist"> 
  <li>
     <label>
	<h4 class="h4reversed" align="center"><b>Edit Details</b></h4>
     </label>
  </li>
 <form name="form1" action="{$action}={$values.shiretown_id}" method="post">
  <ul class="textfieldlist">
    <li>
      <label>Shirename <font color="#FF0000">*</font></label>
        <input type="text" name="shirename" value="{$values.shirename_shirename}" />
    </li>
 
    <li>
        <label>Region code <font color="#FF0000">*</font></label>
          <input type="text" name="regioncode" value="{$values.region_code}" />
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
      <label>Town Name <font color="#FF0000">*</font></label>
        <input type="text" name="townname" value="{$values.shiretown_townname}" />
   </li>
   <li>
      <label>Postcode <font color="#FF0000">*</font></label>
        <input type="text" name="postcode" value="{$values.shiretown_postcode}" />
   </li>
   </ul>
   <ul class="controlbar">
   <div align="center">
        <input type="submit" class="controlgrey" name="submit" value="Save">
	</div>
  </ul>
 </form>
</div>
{literal}
<script language="javascript">
function isNum(str)
{
 var reEmail=/^[0-9]+$/;
 if(!reEmail.test(str))
       {
               return false;
       }
       return true; 
 }
function validate(res)
{
      var re=/^[0-9]+$/;
	if(document.form1.townname.value == "")
	{
	alert('Please Enter the Town Name ');
	document.form1.townname.focus();
	return false;
	}
	
	if(document.form1.postcode.value ==""||!isNum(document.form1.postcode.value))
	{
	alert('Please Enter the Valid postcode ');
	document.form1.postcode.focus();
	return false;
	}
	
	if(document.form1.shirename.value =="")
	{
	alert('Please Select the Shire Name ');
	document.form1.shirename.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}