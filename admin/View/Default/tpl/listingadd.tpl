<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Business</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="POST" enctype="multipart/form-data" >
<br />
<ul class="textfieldlist">



<li>

   <label>Account Number  <font color="#FF0000">*</font></label>    
   <input  id="field1" type="text" name="AccNo" value="{$AccNo}"  class="textfieldshort" />

</li>

	

<li>
   <label>Business Name  <font color="#FF0000">*</font></label>
    
   	 <input  id="field2" type="text" name="name" value="{$name | strip}" class="textfieldshort"/>
</li>

<li>
   <label>URL Alias - Lowercase alpha numeric characters only, no spaces  <font color="#FF0000">*</font></label>
    
   	 <input type="text" name="url_alias" value="{$url_alias | strip}" class="textfieldshort"/>
</li>

<li>
   <label>Business Street1</label>
    
		<input  id="field3" type="text" name="street1" value="{$street1}" class="textfieldshort"/>
		<input type="checkbox" name="Add1" value="1" {if $values12.street1_status eq '1'} checked="checked" {/if}  />
		<span><font color="#FF0000" size="-6">(Tick to supress address 1 on the site)</font></span>
</li>

<li>
   <label>Business Street2</label>
    
		<input  id="field4" type="text" name="street2" value="{$street2}" class="textfieldshort"/>
		<input type="checkbox" name="Add2" value="1" {if $values12.street2_status eq '1'} checked="checked" {/if} />
		<span><font color="#FF0000" size="-6">(Tick to supress address 2 on the site)</font></span>
</li>

<li>
  <label>Business Region  <font color="#FF0000">*</font></label>
    
	 <select name="region" id="type1" onchange=setSuburb(this.value,'{$ADMIN_SITE_PATH}') >
	               <option selected="selected"><h4>--Select One--</h4></option>
					{foreach from=$regionValue item=key}			
			              <option id="region" value="{$key.shirename_id};{$key.shirename_shirename}">                                                     {$key.shirename_shirename}
						  </option>
					  {/foreach}
					</select>
					<div><font color="#FF0000" size="-6">(Please Select your Region to get Suburbs)</font></div>
					</li>
	 					
<li>

<li>
  <label>Business Suburb  <font color="#FF0000">*</font></label>
    <div id="tesJs1"></div>
	 <select name="suburb" id="type" onchange=setPostCode(this.value) ></select>
	<div><font color="#FF0000" size="-6">(Please Select your Suburb to get Postcode)</font></div>
</li>
	 					
<li>
   <label>Business Postcode  <font color="#FF0000">*</font></label>
    
   	 <input  id="field5" type="text" name="postcode" value="{$postcode}" class="textfieldshort" readonly=""/>
</li>

<li>
   <label>Business State</label>

	<select name="state">
      {foreach from=$values2 item=key}	
	    <option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
      {/foreach}						  
	</select>	

	 

</li>

<li>
   <label>Map</label>
    	<input type="checkbox" name="Add3" value="1" {if $values12.map_status eq '1'} checked="checked" {/if} />
		<span><font color="#FF0000" size="-6">Tick to supress map</font></span>
</li>


<li>
   <label>Business Phone STD</label>
    
   	 <input  id="field6" type="text" name="phonestd" value="{$phonestd}" class="textfieldshort"/>
</li>

<li>
   <label>Business Phone</label>
    
   	 <input  id="field7" type="text" name="phone" value="{$phone}" class="textfieldshort"/>
</li>

<li>
   <label>Business Mobile</label>
   
   	 <input  id="field13" type="text" name="mobile" value="{$mobile}" class="textfieldshort"/>
</li>

<li>
   <label>Business Fax STD</label>
    
   	 <input  id="field8" type="text" name="faxstd" value="{$faxstd}" class="textfieldshort"/>
</li>

<li>
   <label>Business Fax</label>
    
   	 <input  id="field9" type="text" name="fax" value="{$fax}" class="textfieldshort"/>
</li>
<li>
   <label>Business Email</label>
    
   	 <input  id="field10" type="text" name="email" value="{$email}" class="textfieldshort"/>
</li>

<li>
  <label>Reporting Email</label>
    
   	 <input  id="field1" type="text" name="reporting_email" value="{$reporting_email}" class="textfieldshort"/>
</li>

<li>
   <label>Business URL</label>
    
   	 <input  id="field11" type="text" name="url" value="{$url}" class="textfieldshort"/>
</li>




<li>
   <label>Business Description  </label>
   	<li> <textarea  id="field11" type="textarea" name="description" class="textfieldlong" value="{$description}" rows="5"/>{$description}</textarea>
	<div><font color="#FF0000" size="-6">Please enter a brief description of your business</font></div>
	</li>
	
</li> 
<li>
    <label>Business Logo </label>  
    
   	 <input  id="field12" type="file" name="logo" value="" class="textfieldshort" size='62'  /> 
	 <div><font color="#FF0000" size="-6">Please select logo</font></div> 
	  <div><font color="#FF0000" size="-6">Logo is for ranked clients only</font></div> 
	   <div><font color="#FF0000" size="-6">Image can not be uploaded from network - local drive upload only</font></div> 
	    <div><font color="#FF0000" size="-6">(the blue colour used for ranked listing image background is RGB = 195, 211, 244)</font></div> 
	 
	 
</li>

<li>
    <label>Business Image </label>  
    
   	 <input  id="field14" type="file" name="image" value="" class="textfieldshort" size='62'  /> 
	 <div><font color="#FF0000" size="-6">Please select image</font></div> 
	  <div><font color="#FF0000" size="-6">Image is for ranked clients only</font></div> 
	   <div><font color="#FF0000" size="-6">Image can not be uploaded from network - local drive upload only</font></div> 
	    <div><font color="#FF0000" size="-6">(the blue colour used for ranked listing image background is RGB = 195, 211, 244)</font></div> 
	 
	 
</li>

<li>
   <label>Live/Archived</label>

   	 <select name="archived">
						  <option value="0" selected="selected">Live</option>
						  <option value="1">Archived</option> 
	</select>		
		<div><font color="#FF0000" size="-6">When creating a new business listing you need to tell the system that the listing is LIVE this means it will appear on www.pinkpages.com.au  if a Listing is Archived it will not appear on the site.</font></div> 				  
</li>




</ul>
<ul class="controlbar">
		<div align="center">
		<input type="submit" name="submit" value="Add Business" class="controlgrey" />
		<a href="{$cancel}"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
		</div>
</ul>
 </form>
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
   	temp=val.split(';');
	var url = PATH+'main.php?do=SalesAccountManager&action=getSuburblisting&ID='+val;
		  
var myAjax = new Ajax.Updater(
	{success:'type'},
	url,
	{
		method: 'get',
		parameters: ''
//        ,onComplete: GetVal(PrimerID)
		
    });
 
 }
function openDiv(Val,ID){

		if(Val=="OpenNew"){
			document.getElementById("openNewDiv").style.display="block";		
		}
		if(Val=="CloseNew"){
			document.getElementById("openNewDiv").style.display="none";
		}
}

function openPopup(Action,Val){

		if(Action=="OpenPopup"){
			document.getElementById("openNewPopup").style.display="block";
			document.getElementById("td"+Val).setAttribute("style","font-weight:bold");		
		}
		if(Action=="ClosePopup"){
			document.getElementById("openNewPopup").style.display="none";
		}
}
</script>
{/literal}



