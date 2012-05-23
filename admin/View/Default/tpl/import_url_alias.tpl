<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Import URL Alias</b></h4>
	<ul class="textfieldlist" >
	<br />
		<form name="loginform1" action="{$import_url_alias_action}" method="post" enctype="multipart/form-data">
			<label>&nbsp;<b>Select CSV file:</b></label>
			<li><input type="file" name="csvfile" id="name" value="" class="textfieldshort" size="47"/></li>
		<br />
		<br />
		
		<ul class="controlbar">
			<div align="center">
				<input type="submit" name="submit" value="Upload" class="controlgrey" onClick="return validate();" />
			</div>
		</ul>
		</form>
	</ul>
</div>
</div>
{literal}
<script language="javascript">
function validate()
{

	if(document.loginform1.name.value == "")
	{
	alert('Please Select the File for Uploading');
	document.loginform1.name.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}