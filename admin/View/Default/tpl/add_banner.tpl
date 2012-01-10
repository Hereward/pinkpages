<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Banner</b></h4>
<form id="test" action="{$action}" name="bannerAdd" method="POST" enctype="multipart/form-data" >
<br />
	<ul class="textfieldlist">
		
		
	
		<li>
<font color="#FF66CC"><input class="hide1" type="radio" name="bannercheck" value="1" checked="checked" />Select any Image and its Attributes</font>
		</li>
		<div class="hide1">
		<li>
			<label>Select Banner:  <font color="#FF0000">*</font></label>
			<li><input type="file" name="banner" /></li>
		</li>
		
		<li>
			<label>Banner Width:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="width" value="{$width}" /></li>
		</li>
		
		<li>
			<label>Banner Height:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="height" value="{$height}" /></li>
		</li>
		
		<li>
			<label>Banner Alternate Text:</label>
			<li><input type="text" name="alttext" value="{$alttext}" /></li>
		</li>
		
		<li>
			<label>Banner Link:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="link" value="{$link}" /></li>
		</li>
		
	</div>
	
		<li>
			<font color="#FF66CC"><input class="hide2" type="radio" id="bannercheck" name="bannercheck" value="2" />Paste HTML code</font>
		</li>
	<div class="hide2" style="display:none;">
		<li>
			<label>HTML Code:  <font color="#FF0000">*</font></label>
			<li><textarea name="html" rows="10" cols="80"></textarea></li>
		</li>
	</div>
	
		<li>
			<label>Banner Title:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="title" value="{$title}" /></li>
		</li>
		
		<li>
			<label>Banner Description:  <font color="#FF0000">*</font></label>
			<li>
			<textarea name="description">{$description}</textarea>
			</li>
		</li>
		
		<li>
			<label>Banner Location:  <font color="#FF0000">*</font></label>
			<li><select name="page">
					<option value="SelectOne">--Select One--</option>
					<option value="0" {if $page eq '0'} selected="selected"{/if} >Home Page Footer</option>
					<option value="1" {if $page eq '1'} selected="selected"{/if} >Business Listing Page Right</option>
					<option value="9" {if $page eq '9'} selected="selected"{/if} >Business Listing Page Footer</option>
					<option value="2" {if $page eq '2'} selected="selected"{/if} >Category Listing Page Right</option>
					<option value="3" {if $page eq '3'} selected="selected"{/if} >Category Listing Page Footer</option>
					<option value="6" {if $page eq '6'} selected="selected"{/if} >Map Search Page Footer</option>
					<option value="7" {if $page eq '7'} selected="selected"{/if} >Browse By Category Page Right</option>
					<option value="8" {if $page eq '8'} selected="selected"{/if} >Browse By Category Page Footer</option>
					<option value="10" {if $page eq '10'} selected="selected"{/if} >Business in my Street</option>
					<option value="11" {if $page eq '11'} selected="selected"{/if} >Business Name Search</option>					
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



