<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Edit Banner</b></h4>
<form id="test" action="{$action}={$selectedListing[0].banner_id}" name="bannerAdd" method="POST" enctype="multipart/form-data" >
<br />
	<ul class="textfieldlist">
		
		<li>
		<font color="#FF66CC"><input class="hide1" type="radio" name="bannercheck" value="1" checked="checked" />Select any image and its attributes</font></li>
		
		<div class="hide1">
		<li>
			<label>Select Banner:  <font color="#FF0000">*</font></label>
			<li><input type="file" name="banner" value="{$selectedListing[0].banner_name}" /></li>
			{if $selectedListing[0].banner_name neq ''}<li><img src="{$BANNER_PATH}{$selectedListing[0].banner_name}" width="80" height="80" border="0" /></li>{/if}
			<li><div style="margin-left:100"><label><a href="{$removeBanner}={$selectedListing[0].banner_id}">Remove Banner</a></label></div></li>
		</li>
				
		<li>
			<label>Banner Width:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="width" value="{$selectedListing[0].banner_width}" /></li>
		</li>
		
		<li>
			<label>Banner Height:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="height" value="{$selectedListing[0].banner_height}" /></li>
		</li>
		
		<li>
			<label>Banner Alternate Text:</label>
			<li><input type="text" name="alttext" value="{$selectedListing[0].alt_text}" /></li>
		</li>
		
		<li>
			<label>Banner Link:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="link" value="{$selectedListing[0].banner_link}" /></li>
		</li>
	</div>
	
		<li>
			<font color="#FF66CC"><input class="hide2" type="radio" name="bannercheck" value="2" />Paste HTML code</font>
		</li>
		<div class="hide2" style="display:none;">
		<li>
			<label>HTML Code:  <font color="#FF0000">*</font></label>
			<li><textarea name="html" rows="10" cols="80">{$selectedListing[0].html_code}</textarea></li>
		</li>
	</div>
	
	<li>
			<label>Banner Title:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="title" value="{$selectedListing[0].banner_title}" /></li>
		</li>
		
		<li>
			<label>Banner Description:  <font color="#FF0000">*</font></label>
			<li>
			<textarea name="description" cols="30" rows="5">{$selectedListing[0].banner_desc}</textarea>
			</li>
		</li>
		
		<li>
			<label>Banner Location:  <font color="#FF0000">*</font></label>
<li><select name="page">
		<option value="0" {if $selectedListing[0].banner_page eq '0'} selected="selected" {/if}>Home Page Footer</option>
		<option value="1" {if $selectedListing[0].banner_page eq '1'} selected="selected" {/if} >Business Listing Page Right</option>
		<option value="9" {if $selectedListing[0].banner_page eq '9'} selected="selected" {/if} >Business Listing Page Footer</option>
		<option value="2" {if $selectedListing[0].banner_page eq '2'} selected="selected" {/if} >Category Listing Page Right</option>
		<option value="3" {if $selectedListing[0].banner_page eq '3'} selected="selected" {/if} >Category Listing Page Footer</option>
		
		<option value="6" {if $selectedListing[0].banner_page eq '6'} selected="selected" {/if} >Map Search Page Footer</option>
		<option value="7" {if $selectedListing[0].banner_page eq '7'} selected="selected" {/if} >Browse By Category Page Right</option>
		<option value="8" {if $selectedListing[0].banner_page eq '8'} selected="selected" {/if} >Browse By Category Page Footer</option>		
				</select>
			</li>			
	
	</ul>

	<ul class="controlbar">
		<div align="center">
			<input type="submit" name="submit" value="Save" class="controlgrey" />
			<a href="#" onclick="javascript:history.back();" ><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
		</div>
	</ul>
	
</form>
</div>
</div>



 {literal}
<script type="text/javascript">
$j('input.hide1').click(function() {


	$j('div.hide2').slideUp(500);
	$j('div.hide1').slideDown(500);
});

$j('input.hide2').click(function() {


	$j('div.hide1').slideUp(500);
	$j('div.hide2').slideDown(500);

});



function preview() 
{
document.loginForm.pic.src = document.loginForm.logo.value;
}

function openDiv(Val,ID){

		if(Val=="OpenNew"){
			document.getElementById("openNewDiv").style.display="block";		
		}
		if(Val=="CloseNew"){
			document.getElementById("openNewDiv").style.display="none";
		}
}
</script>
{/literal}



