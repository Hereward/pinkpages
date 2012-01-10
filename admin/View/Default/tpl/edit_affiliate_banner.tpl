<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Edit Affiliate Banner</b></h4>
<form id="test" action="{$action}={$selectedListing[0].banner_id}" name="bannerAdd" method="POST" enctype="multipart/form-data" >
<br />
	<ul class="textfieldlist">
		

		<li>
			<label>Select Banner:  <font color="#FF0000">*</font></label>
			<li><input type="file" name="banner" value="{$selectedListing[0].banner_name}" /></li>
			<li><img src="{$BANNER_PATH}{$selectedListing[0].banner_name}" width="80" height="80" /></li>
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
			<label>Banner Title:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="title" value="{$selectedListing[0].banner_title}" /></li>
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

function preview() 
{
document.loginForm.pic.src = document.loginForm.logo.value;
}
</script>
{/literal}



