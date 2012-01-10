	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Search Towns</b></h4>
	
	<ul class="textfieldlist" >
	<form name="loginform1" action="{$action}" method="get">
	<input type="hidden" name="do" value="Location" />
	<input type="hidden" name="action" value="searchLocations" /> 
			<li>
				<label><b>Town Name:</b></label>
				<li><input type="text" name="name" id="name" value="" class="textfieldshort"/></li>
			</li>
			
			
			<br />
			<ul class="controlbar">
			<div align="center">
				<input type="submit" name="submit" value="Search" class="controlgrey" />
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
	alert('Please Enter the Town Name to Search');
	document.loginform1.name.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}