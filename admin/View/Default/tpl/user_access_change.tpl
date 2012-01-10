	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Change Access</b></h4>
	
	<ul class="textfieldlist" >
	<form name="loginform1" action="{$action}={$smarty.get.localuser_id}" method="post">
	<input type="hidden" name="do" value="Admin" />
	<input type="hidden" name="action" value="updateAccess" /> 
			
			
				<li>
				<label>User Access:</label>
				<select name="access">
					<option value="admin" {if $localuser_access eq 'admin'} selected="selected" {/if} >Admin</option>
					<option value="Employee" {if $localuser_access eq 'Employee'} selected="selected" {/if} >Employee</option>
					<option value="SAcManager" {if $localuser_access eq 'SAcManager'} selected="selected" {/if} >Sales Account Manager</option>
			
				</select>
			</li>
			<li><font color="#FF0000" size="-2"><strong>(Note:-Change in Access will set all its permissions to default permissions.)</strong></font></li>
			
			
			<br />
			<ul class="">
			<div align="center"><input type="submit" name="submit" value="Update" class="controlgrey" /></div>
	</ul>
	</form>
	</ul>
	</div>
	</div>
