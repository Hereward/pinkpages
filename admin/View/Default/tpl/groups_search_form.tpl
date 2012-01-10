<div class="content">
	<h3 class="h4reversed" align="center"><b>Search Verticals</b></h4>
	<br />

	<form name="loginform1" action="{$action}" method="get">
	<input type="hidden" name="do" value="Group" />
	<input type="hidden" name="action" value="searchGroup" /> 
	<div align="center">
		<label>Vertical Title:</label>
		<input type="text" name="name" id="name" value="" class="textfieldshort"/>
	</div>
<br />
	<ul class="">
	<div align="center"><input type="submit" name="submit" value="Search" class="controlgrey" onClick="return validate();" /></div>

	</ul>
	</form>
	
	</div>
	
{literal}
<script language="javascript">
function validate()
{

	if(document.loginform1.name.value == "")
	{
	alert('Please Enter the  Name for Searching ');
	document.loginform1.name.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}