	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Market Manager</b></h4>
	
	<ul class="textfieldlist" >
	<br />
		<form name="upload1" action="{$action}" method="post" enctype="multipart/form-data">
			<label>&nbsp;<b>Select CSV file for Markets table:</b></label>
			<li><input type="file" name="csvfile" id="name" value="" class="textfieldshort" size="47"/></li>
		
		<ul class="controlbar">
			<div align="center">
				<input type="submit" name="submit" value="Upload" class="controlgrey" onClick="return validate();" />
			</div>
		</ul>
		</form>
	</ul>
	
	<br />
	<br />	
	
	
	<ul class="textfieldlist" >
	<br />
		<form name="upload2" action="{$action1}" method="post" enctype="multipart/form-data">
			<label>&nbsp;<b>Select CSV file for MarketsToShires table:</b></label>
			<li><input type="file" name="csvfile" id="name2" value="" class="textfieldshort" size="47"/></li>
	
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

	if(document.upload1.name.value == "" && document.upload2.name2.value == "")
	{
	alert('Please select a file ');
	document.upload1.name.focus();
	return false;
	}
	return true;

}  
</script>
{/literal}