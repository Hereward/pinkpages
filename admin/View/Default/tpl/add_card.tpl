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
<b>Edit Card Details</b>
</div>
<div align="right">
	<font size="-1">Company Name:<strong>{$values12.business_name|upper}</strong> &nbsp;{if $values12.account_id neq 'NULL'}Account Number:<strong>{$values12.account_id}</strong>{/if}</font>
</div>
</h4>
<form id="test" action="{$action}={$values12.business_id}"  name="cardform" method="POST" enctype="multipart/form-data">
<br />
<ul class="textfieldlist">


<li>
  <label>Business Name</label>
    
   	 <input  id="field1" type="text" name="name" {if $cardResult.business_name eq ''} value="{$name}"{else}value="{$cardResult.business_name}"{/if} class="textfieldshort"/>
</li>

<li>
    <label>Business Street1</label>
    
   	 <input  id="field1" type="text" name="street1" {if $cardResult.page_street1 eq ''} value="{$street1}"{else}value="{$cardResult.page_street1}"{/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Street2</label>
    
   	 <input  id="field1" type="text" name="street2" {if $cardResult.page_street2 eq ''} value="{$street2}"{else} value="{$cardResult.page_street2}" {/if} class="textfieldshort"/>
	
</li>

<li>
    <label>Business Phone STD</label>
    
   	 <input  id="field1" type="text" name="phonestd"  {if $cardResult.page_pstd eq ''} value="{$phonestd}"{else} value="{$cardResult.page_pstd}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Phone</label>
    
   	 <input  id="field1" type="text" name="phone" {if $cardResult.page_phone eq ''} value="{$phone}" {else} value="{$cardResult.page_phone}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Mobile</label>
   
   	 <input  id="field1" type="text" name="mobile"  {if $cardResult.page_mobile eq ''} value="{$mobile}" {else} value="{$cardResult.page_mobile}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Fax STD</label>
    
   	 <input  id="field1" type="text" name="faxstd" {if $cardResult.page_fstd eq ''} value="{$faxstd}" {else} value="{$cardResult.page_fstd}" {/if} class="textfieldshort"/>
</li>

<li>
   <label>Business Fax</label>
    
   	 <input  id="field1" type="text" name="fax" {if $cardResult.page_fax eq ''} value="{$fax}" {else} value="{$cardResult.page_fax}" {/if} class="textfieldshort"/>
</li>
<li>
  <label>Business Email</label>
    
   	 <input  id="field1" type="text" name="email" {if $cardResult.page_email eq ''}value="{$email}"{else}value="{$cardResult.page_email}" {/if} class="textfieldshort"/>
</li>

<li>
    <label>Business URL</label>
    
   	 <input  id="field1" type="text" name="url" {if $cardResult.page_url eq ''} value="{$url}" {else} value="{$cardResult.page_url}" {/if} class="textfieldshort"/>
</li>

<li><strong>Card Content</strong></li>
<li>
 <label>Image One</label>
 <input type="file" name="image1" size="55" />
 			{if $cardResult.page_image1 neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$cardResult.page_image1}" border="0" width="80" height="80" />
			{/if}
			
<label>Text One</label>
 <textarea name="text1" cols="35" rows="8">{if $cardResult.page_field1 eq ''}{$text1}{else}{$cardResult.page_field1}{/if}</textarea>
</li>
<li></li>
<li>
 <label>Image Two</label>
 <input type="file" name="image2" size="55" />
 			{if $cardResult.page_image2 neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$cardResult.page_image2}" border="0" width="80" height="80" />
			{/if}
			
<label>Text Two</label>
<textarea name="text2" cols="35" rows="8">{if $cardResult.page_field2 eq ''}{$text2}{else}{$cardResult.page_field2}{/if}</textarea>
</li>
<li></li>
<li>
 <label>Image Three</label>
 <input type="file" name="image3" size="55" />
 			{if $cardResult.page_image3 neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$cardResult.page_image3}" border="0" width="80" height="80" />
			{/if}
			
<label>Text Three</label>
 <textarea name="text3" cols="35" rows="8">{if $cardResult.page_field3 eq ''}{$text3}{else}{$cardResult.page_field3}{/if}</textarea>
</li>
<li></li>
<li>
 <label>Image Four</label>
 <input type="file" name="image4" size="55" />
 			{if $cardResult.page_image4 neq ''}
				<img src="{$CLIENT_IMAGES_PATH}{$cardResult.page_image4}" border="0" width="80" height="80" />
			{/if}
			
<label>Text Four</label>
 <textarea name="text4" cols="35" rows="8">{if $cardResult.page_field4 eq ''}{$text4}{else}{$cardResult.page_field4}{/if}</textarea>
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
