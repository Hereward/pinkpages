<div class="adminDash">
<?php
include(VIEW_PATH."Menu.php");
?>
<table width="100%" align="center" border="0">
	  <tr>
		<td height="300">
			<form id="test" action="<?php echo SITE_PATH.CONTROLLER?>?do=User&action=changePassword" method="POST">
				<table width="50%" border="0" align="center" id="FormTable">
				  <tr>
					<th colspan="2">Change Password</th>
				  </tr>
				  <tr>
					<td align="right">Old Password</td>
					<td><input class="required" id="field2" type="password" name="OldPassword" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">New Password</td>
					<td><input class="required" id="field3" type="password" name="password" value="" /></td>
				  </tr>
				  <tr>
					<td align="right">Confirm Password</td>
					<td><input class="required" id="field3" type="password" name="Confpassword" value="" /></td>
				  </tr>
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
