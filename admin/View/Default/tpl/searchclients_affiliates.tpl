	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Search Clients</b></h4>
	<br />
	<table align="center">
	<form name="loginform1" action="{$action}" method="get">
	<input type="hidden" name="do" value="Admin" />
	<input type="hidden" name="action" value="searchclients_affiliates" />
	<tr>
		
		<td><label><strong>Business Name:</strong></label></td>
		<td><input type="text" name="name" id="name" value="" class="textfieldshort"/></td>
	
	</tr>
	
<!--	<tr>
		
			<td><label><strong>User type:</strong></label></td>
			<td align="center"><label>Client</label><input type="radio" name="user" value="clients" checked="checked" /> |
			<label>Affiliate</label><input type="radio" name="user" value="affiliates" /></td>
		
	</tr>-->
	</table>

<ul class="">
<div align="center">
 	<input type="submit" name="submit" value="Search" class="controlgrey" onClick="return validate();" />
</div>
</ul>
	</form>
	</div>
	</div>
{literal}
<script language="javascript">
function validate()
{

	if(document.loginform1.name.value == "")
	{
	alert('Please Enter the Business Name for Searching ');
	document.loginform1.name.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}