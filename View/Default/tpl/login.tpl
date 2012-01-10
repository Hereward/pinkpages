<table width="100%" align="center" border="0">
	  <tr>
		<td height="300">
			<form id="test" action="{$SearchAction}" name="Homepage" method="post">
			 
				<table width="50%" border="0" align="center" id="FormTable">
				  
				 <!-- <tr>
					<td align="right">User Name</td>
					<td><input class="required" id="field1" type="text" name="username" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">Password</td>
					<td><input class="required" id="field2" type="password" name="password" value="" /></td>
				  </tr>
				  
				  <tr>
					<td></td>
					<td align="left"><input type="submit" name="submit" value="Login" />
						&nbsp;&nbsp;&nbsp;<a href="{$reg_url}">Register</a>
					</td>
				  </tr> -->
				  
				  <tr>
				  <td><h1>Search for....</h1></td><td><h1>In....</h1></td>
				 </tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr> 
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr> 
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				
				 <tr>
				 <td>(keyword, name or product)</td>><td>(Postcode, Suburb, or State)</td>
				 </tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr><td><label><input type="radio" name="SearchOption" value="0" />Keywords</label>
				<label><input type="radio" name="SearchOption" value="1" />Business Name</label></td></tr>

				  <tr>
				  <tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr><a href="main.php?do=Business&action=login">Business Login</a></tr>
				
				 <td><input type="text" name="Search1" /></td><td><input type="text" name="Search2" /></td><td></td>
				 
				 <td><input type="Submit" name="Submit" value="Submit" /></td>
				 </tr>
				 
				</table>
			</form>
		</td>
	</tr>
</table>
{literal}
<script type="text/javascript">
	function formCallback(result, form) 
	{
		window.status = "valiation callback for form '" + form.id + "': result = " + result;
	}
	
	var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});
</script>
{/literal}
