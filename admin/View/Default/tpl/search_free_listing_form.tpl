	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Search Listings</b></h4>
	
	<ul class="textfieldlist" >
	<form name="loginform1" action="{$action}" method="get">
	<input type="hidden" name="do" value="SalesAccountManager" />
	<input type="hidden" name="action" value="searchListings" /> 
			<li>
				<label><b>Business Name:</b></label>
			 <li><input type="text" name="businessname" id="name" value="" class="textfieldshort"/></li>
			</li>
			<li>
				<label><b>Search type:</b></label>
				<li><select name="type">
				 <option  value="1">Multiple Listing</option>
				 <option value="0">Free Listing</option>
				</select></li>
			</li>
			
			<br />
			<ul class="controlbar">
			<div>&nbsp;<input type="submit" name="submit" value="SEARCH" class="controlgrey" onClick="return validate();" /></div>
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
