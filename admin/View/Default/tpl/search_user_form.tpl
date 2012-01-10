	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Search Users</b></h4>
	
	<ul class="textfieldlist" >
	<form name="loginform1" action="{$action}" method="get">
	<input type="hidden" name="do" value="Admin" />
	<input type="hidden" name="action" value="searchUsers" /> 
			<li>
				<label>User Name:</label>
				<input type="text" name="name" id="name" value="" class="textfieldshort"/>
			</li>
			
				<li>
				<label>User Access:</label>
				<select name="access">
					<option value="admin" >Admin</option>
					<option value="Employee">Employee</option>
					<option value="SAcManager">Sales Account Manager</option>
					<option value="All"selected="selected">All</option>					
				</select>
			</li>
			
			
			<br />
			<ul class="">
			<div align="center"><input type="submit" name="submit" value="SEARCH" class="controlgrey" onClick="return validate();" /></div>
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
	alert('Please Enter the  Name for Searching ');
	document.loginform1.name.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}