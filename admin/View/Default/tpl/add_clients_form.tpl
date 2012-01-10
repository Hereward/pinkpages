<div class="content">
<h4 class="h4reversed"><b>Add client</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="POST">
<ul class="textfieldlist">
<br />
<br />
	<li>
		<label>Business Name: <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="text" name="clientname" value="{$clientname}" class="textfieldshort"  />
	</li>
	
	<li>
		<label>Contact Name:</label>
	</li>
	<li>
		<input type="text" name="contactname" value="{$contactname}" class="textfieldshort"  />
	</li>
	
	<li>
		<label>Email: <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="text" name="email" value="{$email}" class="textfieldshort" />
	</li>	

	<li>
		<label>Password: <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="password" name="password" value="" class="textfieldshort" />
	</li>
	
	<li>
		<label>Confirm Password: <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="password" name="confpassword" value="" class="textfieldshort" />
	</li>

	<li>
		<label>Business Address:</label>
	</li>
	<li>
		<input type="text" name="address" value="{$address}" class="textfieldshort" />
	</li>

	<li>
		<label>Postcode:</label>
	</li>
	<li>
		<input type="text" name="postcode" value="{$postcode}" class="textfieldshort" />
	</li>

	<li>
		<label>Phone No.:</label>
	</li>
	<li>
		<input type="text" name="phone" value="{$phone}" class="textfieldshort" />
	</li>

	<li>
		<label>Fax:</label>
	</li>
	<li>
		<input type="text" name="fax" value="{$fax}" class="textfieldshort" />
	</li>

	<li>
		<label>Mobile:</label>
	</li>
	<li>
		<input type="text" name="mobile" value="{$mobile}" class="textfieldshort" />
	</li>

	<li>
		<label>Web Address:</label>
	</li>
	<li>
		<input type="text" name="webaddress" value="{$webaddress}" class="textfieldshort" />
	</li>

	<!--<li>
		<label>Account Number: <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="text" name="account_id" value="{$account_id}" class="textfieldshort" />
	</li>

	<li>    
		<label>Secret Text <font color="#FF0000">*</font></label>
	</li>
	<li>
		<input type="text" name="secrettext" value="" class="textfieldshort" />
		<label><font color="#FF0000" face="Geneva, Arial, Helvetica, sans-serif">(Please enter the secret text. This text should be remembered at the time when you forget your password.)</font></label>
	</li>
	
<br />-->	
</ul>
<ul class="controlbar">
<div align="center">
<input class="controlgrey" name="Save" type="submit" value="Save" />
<input class="controlgrey" name="Save" type="button" value="Back" onclick="javascript:window.location='{$back}'"/>
</div>
</ul>

</form>
</div>