<div class="content-big">
<h4 class="h4reversed"><b>Business Registration Form</b></h4>

<form id="test" action="{$action}"  name="loginForm" method="POST">
<ul class="textfieldlist">
<br />
<br />
<li>
    <label>Name: <font color="#FF0000">*</font></label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="clientname" value="{$clientname}" class="textfieldshort"  />
	
  </li></li>
  <li>
    <label>Password: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="password" value="" class="textfieldshort" />
  </li></li>
  <li>
    <label>Confirm Password: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="confpassword" value="" class="textfieldshort" />
  </li></li>
  <li>
    <label>Email: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" value="{$email}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Postcode: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="postcode" value="{$postcode}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Phone No.: <font color="#FF0000">*</font></label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" value="{$phone}" class="textfieldshort" />
  </li></li>
  <li>
				<label>Secret Text <font color="#FF0000">*</font></label>
				<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="secrettext" value="" class="textfieldshort" />
				<label><font color="#FF0000" face="Geneva, Arial, Helvetica, sans-serif">(Please enter the secret text. This text should be remembered at the time when you forget your password.)</font></label>
				</li>
			</li>
  <br />
</ul>
<ul class="controlbar">
    <li><input class="controlgrey" name="Save" type="submit" value="Save" /></li>
    <li><input class="controlgrey" name="Save" type="button" value="Back" onclick="javascript:window.location='{$back}'"/></li>
</ul>

</form>
</div>
<!--<table width="100%" align="center" border="0">
	  <tr>
		<td height="300"><div class="datatable">
			<form id="test" action="{$action}"  name="loginForm" method="POST">
				<table width="50%" border="0" align="center" id="FormTable">
				  <tr>
					<th colspan="2">Registration Form</th>
				  </tr>
				  <tr>
					<td align="right"><h3> Name</h3></td>
					<td><input class="required" id="field1" type="text" name="clientname" value="" size="40"/></td>
				  </tr>
				  
				  <tr>
					<td align="right"><h3>Password</h3> </td>
					<td><input class="required" id="field4" type="password" name="password" value="" size="40"/></td>
				  </tr>
				  <tr>
					<td align="right"><h3>Email</h3></td>
					<td><input class="required" id="field5" type="text" name="email" value="" size="40"/></td>
				  </tr>
				  <tr>
					<td align="right"><h3>postcode</h3></td>
					<td><input class="required" id="field6" type="text" name="postcode" value="" size="40"/></td>
				  </tr>
                   <tr>
					<td align="right"><h3>Phone No.</h3></td>
					<td><input class="required" id="field7" type="text" name="phone" value="" size="40"/></td>
				  </tr>
                  <tr>
					<td align="right"><h3>Access</h3></td>
					<td><select name="access" id="type" >			
					  <option value="Business" >Business</option>
					  <option value="Affiliate" >Affiliate</option>
					    </select> </td>
				  </tr>
				  
				  <tr>
					<td></td>
					<td align="left"><input type="submit" name="submit" value="save" />
						&nbsp;&nbsp;&nbsp;<a href="{$back}">Back</a>
					</td>
				  </tr>
				</table>
			</form>
		</td>
	</tr>
</table> -->

