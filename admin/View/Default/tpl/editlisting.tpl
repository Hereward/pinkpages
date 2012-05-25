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
  <label>Account ID  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="account_id" {if $values12.account_id eq ''} value="{$account_id}"{else}value="{$values12.account_id}"{/if} class="textfieldshort"/>
</li>
<li>
  <label>Business Name  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="name" {if $values12.business_name eq ''} value="{$name|stripslashes}"{else}value="{$values12.business_name|stripslashes}"{/if} class="textfieldshort"/>
</li>

<li>
  <label>URL Alias - Lowercase alpha numeric characters only, no spaces  <font color="#FF0000">*</font></label>
    
   	 <input type="text" name="url_alias" {if $values12.url_alias eq ''} value="{$url_alias|stripslashes}"{else}value="{$values12.url_alias|stripslashes}"{/if} class="textfieldshort"/>
</li>

<li>
		<label>Business Listing page</label>
		<a target="_blank" href='http://www.pinkpages.com.au/{$smarty.get.ID}/{$smarty.get.ID}/listing'>Visit {$values12.business_name|upper} Listing Page<a/></td>
		{* <a href='http://www.pinkpages.com.au/main.php?do=Listing&action=boldListing&ID={$smarty.get.ID}'>Visit {$values12.business_name|upper} Listing Page<a/></td> *}
	</li>

<li>
    <label>Business Street1 </label>
    
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
			              <option id="postcode1" value="{$key.shiretown_postcode},{$key.shiretown_townname}" {if $key.shiretown_townname|upper eq $values12.business_suburb|upper} selected="selected" {/if}>                                                     
			              {$key.shiretown_townname|upper}
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

	<select name="state">
    {foreach from=$values21 item=key}	
	  <option value="{$key.localstate_name}" {if $key.localstate_name eq $values12.business_state} selected="selected" {/if}>{$key.localstate_name}</option>
	{/foreach}						  
	</select>	
   	 <!--<input  id="field12" type="file" name="logo" value="" class="textfieldshort" size='47'/> -->
</li>
	 
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



<li>
   <label>Business Description</label>
  <li> <textarea size='37' id="field11" type="text" name="description" class="textfieldlong" rows="5"/>{if $values12.business_description eq ''}{$description}{else}{$values12.business_description}{/if}</textarea></li>
	<div><div><font color="#FF0000" size="-6">(Please Enter a Brief Description for know how of your business)</font></div></div>
	
</li>


<li>
	<table width="300" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td><label>Business Logo</label></td>
	  </tr>
	  <tr>
        <td>
		  <input  id="field12" type="file" name="logo" value="{$values12.business_logo}" class="textfieldshort" size='37'/> 	
		</td>		
		<td>
			{if $values12.business_logo neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$values12.business_logo}" border="0" width="80" height="80" />
			{/if}
		</td>		
	  </tr>
	</table>
	<div><font color="#FF0000" size="-6">(Please select logo)</font></div> 
	<div><font color="#FF0000" size="-6">(Logo is for ranked clients only)</font></div> 
	<div><font color="#FF0000" size="-6">(Image can not be uploaded from network - local drive upload only)</font></div> 
	<div><font color="#FF0000" size="-6">(the blue colour used for ranked listing image background is RGB = 195, 211, 244)</font></div>      	 
</li>

<li>
	<table width="500" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td><label>Business Image</label></td>
	  </tr>
	  <tr>
        <td>
		  <input  id="field12" type="file" name="image" value="{$values12.business_image}" class="textfieldshort" size='37'/> 	
		</td>		
		<td>
			{if $values12.business_image neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$values12.business_image}" border="0" width="407" />
			{/if}
		</td>		
	  </tr>
	</table>
	<div><font color="#FF0000" size="-6">(Please select logo)</font></div> 
	<div><font color="#FF0000" size="-6">(Logo is for ranked clients only)</font></div> 
	<div><font color="#FF0000" size="-6">(Image can not be uploaded from network - local drive upload only)</font></div> 
	<div><font color="#FF0000" size="-6">(the blue colour used for ranked listing image background is RGB = 195, 211, 244)</font></div>      	 
</li>

<li>
   <label>Live/Archived</label>

   	 <select name="archived">
						  <option value="0" {if $values12.archived eq '0'} selected="selected" {/if}>Live</option>
						  <option value="1" {if $values12.archived eq '1'} selected="selected" {/if}>Archived</option> 
	</select>			
	<div><font color="#FF0000" size="-6">When a client no longer wants to list on pinkpages.com they should be archived, if they want to re-list with Pinkpages.com at a later date the account can be put back to Live and there listing will re-appear on the site.</font></div> 		  
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