<div class="content">
<table width="100%" align="center" border="0">
	  <tr>
		<td height="300">
			<form id="test" action="{$action}" method="POST">
				<table width="50%" border="0" align="center" id="FormTable">
				  <tr>
					<th colspan="2">User Registration </th>
				  </tr>
				  <tr>
					<td align="right">User Name</td>
					<td><input class="required" id="field1" type="text" name="username" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">Password</td>
					<td><input class="required" id="field2" type="password" name="password" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">Confirm Password</td>
					<td><input class="required" id="field3" type="password" name="Confpassword" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">First Name</td>
					<td><input class="required" id="field4" type="text" name="firstName" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">Last Name</td>
					<td><input class="required" id="field5" type="text" name="lastName" value="" /></td>
				  </tr>
				  <tr>
					<td></td>
					<td align="left"><input type="submit" name="submit" value="Register" />
						&nbsp;&nbsp;&nbsp;<a href="{$login_url}">Login</a>
					</td>
				  </tr>
				</table>
			</form>
		</td>
	</tr>
</table>