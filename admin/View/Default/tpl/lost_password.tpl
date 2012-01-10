<div class="content-big">
<h4 class="h4reversed" align="center"><b>Recover your password</b></h4>
<form id="test" action="{$action}" method="POST" name="loginform">
<ul class="textfieldlist">

	<li>
		<label>User Name</label>
		<input name="username" type="text" id="" class="textfieldshort" />
		<div><font size="-1" color="#FF0000">(Please enter your User Name to send your lost password)</font></div>
	</li>
	<li>
		<label>Login Type</label><li>
		<select name="type" id="ctl00_CPHContent_ctlUpdateTask1_cmbTaskStatus">
		<option value="Admin" >Admin</option>
		<option value="SalesAccountManager" >Sales Account Manager</option>
		<option value="Employee" >Employee</option>
		</select>
	</li>
</ul>

<ul class="controlbar">
    <div align="center">
		<input class="controlgrey" name="Save" type="submit" value="Send" />
		<input class="controlgrey" name="Back" type="button" value="Back" onclick="javascript:history.go(-1)" />
	</div>
   
</ul>

</form>
</div>
