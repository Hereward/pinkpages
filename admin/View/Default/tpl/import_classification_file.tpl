<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Upload Classification</b></h4>
	<ul class="textfieldlist" >
	<br />
		<form name="importCSV" action="{$action}" method="post" enctype="multipart/form-data">
			<label>&nbsp;<b>Select CSV file:</b></label>
			<li><input type="file" name="csvfileName" id="csvfileName" value="" class="textfieldshort" size="47"/></li>
		<br />
		<br />
		
		<ul class="controlbar">
			<div >
				&nbsp;<input type="submit" name="submit" value="Upload" class="controlgrey" onClick="return validate();" />
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

	if(document.importCSV.csvfileName.value == "")
	{
	alert('Please Select the File for Uploading');
	document.importCSV.csvfileName.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}