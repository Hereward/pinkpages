<!--<link href="../Style/default.css" rel="stylesheet" type="text/css" />
<div class="navigation">
<ul class="navbar">
    <li><a href="{$logout_url}"><b>Logout<b></a></li>
    <li><a href="{$edit}">Edit Profile</a></li>
    <li><a href="{$listing}">Add Business Listing</a></li> 
	<li><a href="{$viewlisting}">View Listing</a></li>
</ul>
</div> -->
<div class="content0left">
<form id="test" action="{$action}"  name="loginForm" method="POST" >
<ul class="green">
 <span id="ctl00_CPHTitle_lblTaskTitle">Businesses Listing Form </span>
</ul>

<ul class="textfieldlist" >
<li>
   <label>BUSINESS INITIALS</label>
    
   	 <input  id="field1" type="text" name="initials" value=""  class="textfieldshort" />
	
</li>	

<li>
   <label>NAME</label>
    
   	 <input  id="field2" type="text" name="name" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>STREET ADDRESS-1</label>
    
   	 <input  id="field3" name="street1" type="text" onKeyDown="limitText(this.form.limitedtextfield,this.form.countdown,15);" 
onKeyUp="limitText(this.form.limitedtextfield,this.form.countdown,15);" maxlength="15"  class="textfieldshort"><br>
<font size="1">(Maximum characters: 15)<br>
You have <input readonly type="text" name="countdown" size="3" value="15"> characters left.</font>

	
</li>

<li>
   <label>STREET ADDRESS-2</label>
    
   	 <input  id="field4" type="text" name="street2" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>SUBURB<h6 style="color:#FF0033">(*Please select Suburb to get the Postcode)</h6></label>
    
	 <select name="suburb" id="type" onchange=setPostCode(this.value) >
					 {foreach from=$values item=key}			
			              <option id="postcode1" value="{$key.shiretown_postcode};{$key.shiretown_townname}">                                                     {$key.shiretown_townname}
						  </option>
					  {/foreach} 
					</select>

<li>
   <label>POSTCODE</label>
    
   	 <input  id="field5" type="text" name="postcode" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>PHONESTD</label>
    
   	 <input  id="field6" type="text" name="phonestd" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>PHONE</label>
    
   	 <input  id="field7" type="text" name="phone" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>FAXSTD</label>
    
   	 <input  id="field8" type="text" name="faxstd" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>FAX</label>
    
   	 <input  id="field9" type="text" name="fax" value="" class="textfieldshort"/>
	
</li>
<li>
   <label>E-MAIL</label>
    
   	 <input  id="field10" type="text" name="email" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>URL</label>
    
   	 <input  id="field11" type="text" name="url" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>ORIGIN</label>
    
   	 <input  id="field12" type="text" name="origin" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>MOBILE</label>
   
   	 <input  id="field13" type="text" name="mobile" value="" class="textfieldshort"/>
	
</li>

<li>
   <label>CONTACT</label>
    
   	 <input  id="field14" type="text" name="contact" value="" class="textfieldshort"/>
	
</li>



</ul>
<ul class="controlbar">
<li  ><input type="submit" name="submit" value="save" onclick=setName(this.value) 
						  class="controlgreen" />&nbsp;&nbsp;&nbsp;<a href="{$back}">Back</a></li>
</ul>
</div>  
</form>
 {literal}
<script type="text/javascript">
 function setPostCode(val)
 { 
   temp=val.split(';');
   document.loginForm.postcode.value = S=temp[0];
 
 }

function setName(val)
 {
   temp=val.split(';');
   document.loginForm.suburb.postcode1.value = S=temp[1];
 
 }
</script>
{/literal}




 
