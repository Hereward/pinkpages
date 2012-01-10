<div class="content-big"  >
<h4 class="h4reversed" align="center"><b>Admin login</b></h4>
<form id="test" name="loginForm" action="{$action}" method="post">
	<ul class="textfieldlist">
	<br />
		<li>
			<label>User Name:</label>
			<input name="username" type="text"  class="textfieldshort" tabindex="1" />
		</li>
		
		<li>
			<label>Password:</label>
			<input name="password" type="Password"  class="textfieldshort" tabindex="2"  />
		</li>
		
		<li>
		<label>Login As:</label>
		<li>
		<select name="type" id="type" tabindex="3" >			
		<option value="admin" >Admin</option>
		<option value="SAcManager" >Sales Account Manager</option>
		<option value="Employee" >Employee</option>
		</select>
		</li>
		<li><a href="{$lostpass}" tabindex="5">Forgot Password?</a></li>
		</li>

	</ul>
	
	<ul class="controlbar">
	<div align="left">
	  <input class="controlgrey" type="submit" name="submit" value="Login" tabindex="4"  />
	</div>
	</ul>
</form>	    
</div>
