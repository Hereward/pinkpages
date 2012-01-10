<div class="content">
	<h4 class="h4reversed"><b>Edit Client Profile</b></h4>
	<form id="test" action="{$action}={$values1[0].client_id}" method="POST">
		<ul class="textfieldlist">
		<br />
			<li>
				<label><b>Account Number: {$values1[0].client_id}</b></label>
			</li>
			
			<li>
				<label>Business Name: <font color="#FF0000">*</font></label>
			</li>
			<li>
				<input type="text" name="clientname" value="{$values1[0].client_name}" class="textfieldshort"  />
			</li>
			
			<li>
				<label>Contact Name:</label>
			</li>
			<li>
				<input type="text" name="contactname" value="{$values1[0].contact_name}" class="textfieldshort"  />
			</li>			
			<li>
				<label>Email: <font color="#FF0000">*</font></label>
			</li>
			<li>
				<input type="text" name="email" value="{$values1[0].email}" class="textfieldshort" readonly="{$values1.email}" />
			</li>
			<li>
				<label>Password: <font color="#FF0000">*</font></label>
			</li>
			<li>
				<input type="text" name="password" value="" class="textfieldshort"  />
			</li>
			<li>
				<label>Confirm Password: <font color="#FF0000">*</font></label>
			</li>
			<li>
				<input type="text" name="confpassword" value="" class="textfieldshort"  />
			</li>						
			
			<li>
				<label>Business Address:</label>
			</li>
			<li>
				<input type="text" name="address" value="{$values1[0].business_address}" class="textfieldshort" />
			</li>

			<li>
				<label>Fax:</label>
			</li>
			<li>
				<input type="text" name="fax" value="{$values1[0].fax}" class="textfieldshort" />
			</li>
		
			<li>
				<label>Mobile:</label>
			</li>
			<li>
				<input type="text" name="mobile" value="{$values1[0].mobile}" class="textfieldshort" />
			</li>
		
			<li>
				<label>Web Address:</label>
			</li>
			<li>
				<input type="text" name="webaddress" value="{$values1[0].web_address}" class="textfieldshort" />
			</li>
						
			<li>
				<label>Postcode:</label>
			</li>
			<li>
				<input type="text" name="postcode" value="{$values1[0].postcode}" class="textfieldshort" />
			</li>
	
			<li>
				<label>Phone No.:</label>
			</li>
			<li>
				<input type="text" name="phone" value="{$values1[0].phone}" class="textfieldshort" />
			</li>
		
<br />

</ul>

<ul class="controlbar">
<div align="center">
<input class="controlgrey" name="Save" type="submit" value="Save" />
<a href="{$back}"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>
</ul>

</form>
</div>