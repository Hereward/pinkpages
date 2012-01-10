<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Affiliate Banner</b></h4>
<form id="test" action="{$action}" name="affiliateBannerAdd" method="POST" enctype="multipart/form-data" >
<br />
	<ul class="textfieldlist">
		
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
			<label>Banner Title:  <font color="#FF0000">*</font></label>
			<li><input type="text" name="title" value="{$title}" /></li>
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



