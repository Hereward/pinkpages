<div class="content0left">
<div class="content">

	<div align="center">
		<label><a href="{$edit_url}&ID={$smarty.get.ID}">Edit Details</a> | </label>
		<label><a href="{$edit_classification}&ID={$smarty.get.ID}">Edit Classification</a> | </label>
		<label><a href="{$edit_rank}&ID={$smarty.get.ID}">Edit rank</a> | </label>
		<label><a href="{$add_keyword}&ID={$smarty.get.ID}">Edit Brands & Services</a> | </label>
		<label><a href="{$manageHoursDays}&ID={$smarty.get.ID}">Edit Hours and Payment</a></label>
	</div>
<h4 class="h4reversed" >
<div align="left">
<b>Edit Business Listing</b>
</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div>
</h4>
<form id="test" action="{$action}={$values12.business_id}"  name="loginForm" method="POST" enctype="multipart/form-data">
<br />
<ul class="textfieldlist">


<li>
  <label>Business Name  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="name" {if $values12.business_name eq ''} value="{$name}"{else}value="{$values12.business_name}"{/if} class="textfieldshort"/>
</li>

<li>
    <label>Business Street1  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="street1" {if $values12.business_street1 eq ''} value="{$street1}"{else}value="{$values12.business_street1}"{/if} class="textfieldshort"/>
	 <input type="checkbox" name="Add1" value="1" {if $values12.street1_status eq '1'} checked="checked" {/if}  />
	 <span><font color="#FF0000" size="-6">(Tick to supress address 1 on the site)</font></span>
</li>

<li>
   <label>Business Street2</label>
    
   	 <input  id="field1" type="text" name="street2" {if $values12.business_street2 eq ''} value="{$street2}"{else} value="{$values12.business_street2}" {/if} class="textfieldshort"/>
	 <input type="checkbox" name="Add2" value="1" {if $values12.street2_status eq '1'} checked="checked" {/if} />
 	 <span><font color="#FF0000" size="-6">(Tick to supress address 2 on the site)</font></span>
</li>

<li>
   <label>Business Region  <font color="#FF0000">*</font></label>
    
	 <select name="region" id="type1" onchange=setSuburb(this.value,'{$ADMIN_SITE_PATH}') >

					{foreach from=$regionValue item=key}			
			              <option id="region" value="{$key.shirename_id},{$key.shirename_shirename}" {if $key.shirename_shirename eq $values12.shire_name} selected="selected" {/if}>                                                     {$key.shirename_shirename}
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
	 				{if $values12.business_suburb eq ''}
	                <option selected="selected">--Select One--</option>
					{else}
					 {foreach from=$values item=key}			
			              <option id="postcode1" value="{$key.shiretown_postcode},{$key.shiretown_townname}" {if $key.shiretown_townname eq $values12.business_suburb} selected="selected" {/if}>                                                     {$key.shiretown_townname}
						  </option>
					  {/foreach} 
					  {/if}
					</select> 
					<div><font color="#FF0000" size="-6">(Please Select your Suburb to get Postcode)</font></div>
</li>

<li>
  <label>Business Postcode  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="postcode" value="{$values12.business_postcode}" class="textfieldshort" readonly="{$values12.business_postcode}"/>
</li>

<li>
  <label>Business State</label>
    {foreach from=$values21 item=key}
	<select name="state">
						  <option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
	</select>	
   	 <!--<input  id="field12" type="file" name="logo" value="" class="textfieldshort" size='47'/> -->
	 {/foreach}</li>
	 
	<li> 
	  <label><a href="{$addMoreAddresses}={$values12.business_id}">Add more Addressess</a>&nbsp;&nbsp;&nbsp;
	  <a href="{$manageAddress}={$values12.business_id}">Manage Address</a></label>
  </li>


<li>
   <label>Map</label>
    	<input type="checkbox" name="Add3" value="1" {if $values12.map_status eq '1'} checked="checked" {/if} />
		<span><font color="#FF0000" size="-6">(Tick to supress map)</font></span>
</li>


<li>
    <label>Business Phone STD</label>
    
   	 <input  id="field1" type="text" name="phonestd"  {if $values12.business_phonestd eq ''} value="{$phonestd}"{else} value="{$values12.business_phonestd}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Phone</label>
    
   	 <input  id="field1" type="text" name="phone" {if $values12.business_phone eq ''} value="{$phone}" {else} value="{$values12.business_phone}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Mobile</label>
   
   	 <input  id="field1" type="text" name="mobile" value="{$values12.business_mobile}" class="textfieldshort"/>
</li>

<li>
   <label>Business Fax STD</label>
    
   	 <input  id="field1" type="text" name="faxstd" {if $values12.business_faxstd eq ''} value="{$faxstd}" {else} value="{$values12.business_faxstd}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Fax</label>
    
   	 <input  id="field1" type="text" name="fax" {if $values12.business_fax eq ''} value="{$fax}" {else} value="{$values12.business_fax}" {/if} class="textfieldshort"/>
</li>
<li>
  <label>Business Email</label>
    
   	 <input  id="field1" type="text" name="email" {if $values12.business_email eq ''} value="{$email}"{else} value="{$values12.business_email}" {/if} class="textfieldshort"/>
</li>

<li>
    <label>Business URL</label>
    
   	 <input  id="field1" type="text" name="url" {if $values12.business_url eq ''} value="{$url}" {else} value="{$values12.business_url}" {/if} class="textfieldshort"/>
</li>

<!--<li>
   <label>Business Brand</label>
   
    <select name="brand" >
	               
					{foreach from=$brandResult item=key}			
			              <option value="{$key.brand_id}-{$key.brand_name}" {if $key.brand_id eq $businessBrand[0].brand_id} selected="selected" {/if}>{$key.brand_name}</option>
					  {/foreach}
					</select>
					<div><font color="#FF0000" size="-6">(Please Select your Brand)</font></div>
</li>-->


<li>
   <label>Business Description  <font color="#FF0000">*</font></label>
  <li> <textarea  id="field11" type="text" name="description" value="{$values12.business_description}" class="textfieldshort" rows="5"/>{if $values12.business_description eq ''}{$description}{else}{$values12.business_description}{/if}</textarea></li>
	<div><div><font color="#FF0000" size="-6">(Please Enter a Brief Description for knowhow of your business)</font></div></div>
	
</li>


<li>
	<table width="300" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td><label>Business Logo  <font color="#FF0000">*</font></label></td>
		<td><input  id="field12" type="file" name="logo" value="{$values12.business_logo}" class="textfieldshort" size='37'/>
		<div><font color="#FF0000" size="-6">(Please Select Logo)</font></div> 
		</td>
		
		<td>
			{if $values12.business_logo neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$values12.business_logo}" border="0" width="80" height="80" />
			{/if}
		</td>
		
	  </tr>
	</table>
     	 
</li>


<!--<li>
   <label>Business Origin</label>
    
   	 <input  id="field1" type="text" name="origin" value="{$values12.business_origin}" class="textfieldshort"/>
</li>-->

<li>

<!--   <label>Bold Listing</label>
   	 <select name="listing">
						  <option value="1" {if $values12.bold_listing eq '1'} selected="selected" {/if}>YES</option>
						  <option value="0" {if $values12.bold_listing eq '0'} selected="selected" {/if}>NO</option> 
	</select>					  

  </li>-->
	 <div><font color="#FF0000" size="-6">(Please Selet 'YES' For paid and 'NO' for free listing)</font></div>

<li>
   <label>Live/Archived</label>

   	 <select name="archived">
						  <option value="1" {if $values12.archived eq '1'} selected="selected" {/if}>Live</option>
						  <option value="0" {if $values12.archived eq '0'} selected="selected" {/if}>Archived</option> 
	</select>					  
</li>

</ul>
<br />
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Update" class="controlgrey" />
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


 
 function openDiv(Val,ID){

		if(Val=="OpenNew"){
			document.getElementById("openNewDiv").style.display="block";		
		}
		if(Val=="CloseNew"){
			document.getElementById("openNewDiv").style.display="none";
		}
}

function preview() 
{
document.loginForm.pic.src = document.loginForm.logo.value;
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