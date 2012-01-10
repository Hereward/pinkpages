<div class="adminDash">
<?php
include(VIEW_PATH."Menu.php");
?>
<table width="100%" align="center" border="0">
	  <tr>
		<td height="300">
			<form id="test" action="<?php echo $request->createURL("User","update")?>" method="POST">
				<table width="50%" border="0" align="center" id="FormTable">
				  <tr>
					<th colspan="2">User Profile Edit</th>
				  </tr>
				  <tr>
					<td align="right">First Name</td>
					<td><input class="required" id="field4" type="text" name="firstName" value="<?php echo $request->getAttribute('firstname')?>" /></td>
				  </tr>
				  <tr>
					<td align="right">Last Name</td>
					<td><input class="required" id="field5" type="text" name="lastName" value="<?php echo $request->getAttribute('lastname')?>" /></td>
				  </tr>
				  <tr>
					<td></td>
					<td align="left"><input type="submit" name="submit" value="Update" /></td>
				  </tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function formCallback(result, form) 
	{
		window.status = "valiation callback for form '" + form.id + "': result = " + result;
	}
	
	var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});

</script>

</div>
