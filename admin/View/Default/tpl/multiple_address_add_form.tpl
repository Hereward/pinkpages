<div class="content0left">
<div class="content">
	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit Brands & Services</a> | </label>
		<label><a href="{$manageHoursDays}&ID={$smarty.get.ID}">Edit Hours and Payment</a></label>
	</div>

<h4 class="h4reversed" align="Left">Add address<label><a href="{$manageAddress}={$smarty.get.ID}" style="color:#FFFFFF; margin-left:480px;">Manage Address</a></label></h4>
<form id="test" action="{$action}={$values12.business_id}"  name="loginForm" method="POST" enctype="multipart/form-data">
<br />
<ul class="textfieldlist">
<li>
    <label>Business Street1  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="street1"  class="textfieldshort" value="{$street1}"/>
	 <input type="checkbox" name="Add1" value="1"   />
	 <span><font color="#FF0000" size="-6">(Tick to supress address 1 on the site)</font></span>
</li>

<li>
   <label>Business Street2</label>
    
   	 <input  id="field1" type="text" name="street2"  class="textfieldshort" value="{$street2}"/>
	 <input type="checkbox" name="Add2" value="1"  />
 	 <span><font color="#FF0000" size="-6">(Tick to supress address 2 on the site)</font></span>
</li>

<li>
   <label>Business Region  <font color="#FF0000">*</font></label>
    
	 <select name="region" id="type1" onchange=setSuburb(this.value,'{$ADMIN_SITE_PATH}') >
	               <option selected="selected"><h4>--Select One--</h4></option>
					{foreach from=$regionValue item=key}			
			              <option id="region" value="{$key.shirename_id},{$key.shirename_shirename}" >                                                     {$key.shirename_shirename}
						  </option>
					  {/foreach}
					</select>
					<div><font color="#FF0000" size="-6">(Please Select your Region to get Suburs)</font></div>
  </li>
	 					
<li>
<li>
   <label>Business Suburb  <font color="#FF0000">*</font></label>
    <div id="tesJs1"></div>
	 <select name="suburb" id="type" onchange=setPostCode(this.value) >
	               <option selected="selected">--Select One--</option>
					 {foreach from=$values item=key1}			
			              <option id="suburb" value="{$key1.shiretown_postcode},{$key1.shiretown_id}" >                                                     {$key1.shiretown_id}{$key1.shiretown_townname}
						  </option>
					  {/foreach} 
					</select> 
					<div><font color="#FF0000" size="-6">(Please Select your Suburb to get Postcode)</font></div>
</li>

<li>
  <label>Business Postcode  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="postcode" value="" class="textfieldshort" readonly="{$values12.business_postcode}"/>
</li>

<li>
  <label>Business State</label>
    {foreach from=$values21 item=key}
	<select name="state">
						  <option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
	</select>	
   	 <!--<input  id="field12" type="file" name="logo" value="" class="textfieldshort" size='47'/> -->
	 {/foreach}</li>
	 
</li>
</ul>
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Add" class="controlgrey" />
<a href="#" onclick="javascript:history.back();" ><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>
</ul>
</div>
</div>	 
{literal}
<script type="text/javascript">
 function setPostCode(val)
 {
   temp=val.split(',');
   document.loginForm.postcode.value = S=temp[0];
 
 }
 
  function setSuburb(val,PATH)
 {
   	temp=val.split(',');
	var url = PATH+'main.php?do=SalesAccountManager&action=getSuburb&ID='+val;
  
var myAjax = new Ajax.Updater(
	{success:'type'},
	url,
	{
		method: 'get',
		parameters: ''
//        ,onComplete: GetVal(PrimerID)
		
    });
 
 }	
 </script>
{/literal}  