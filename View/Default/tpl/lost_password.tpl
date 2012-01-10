<div class="content-big">
<h4 class="h4reversed"><b>Recover your password</b></h4>
<form id="test" action="{$action}" method="POST" name="loginform">
<input type="hidden" id="do" name="do" value="Business" />
<input type="hidden" id="action" name="action" value="passwordSent" />
<ul class="textfieldlist">
		<br />
		<br />
	<li>
		<label>Please enter your Email to send your lost password</label>
		<input name="email" type="text" id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" class="textfieldshort" />
	</li>
	
	<li>
		<label>Login Type</label><li>
		<select name="type" id="ctl00_CPHContent_ctlUpdateTask1_cmbTaskStatus" onchange="classChange(this.value);">
		
		<option value="business" >Business</option>
		<option value="affiliate" >Affiliate</option>
		</select>
	</li>
		
	<li>
		<label>Secret Text</label>		
		<input name="secrettext" type="text" id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" class="textfieldshort" />
		<label><font color="#FF0000" face="Geneva, Arial, Helvetica, sans-serif">(Please enter the secret text that you have entered at the time of registration.)</font></label>
	</li>
	<br />
</ul>

<ul class="controlbar">
    <li><input class="controlgrey" name="Save" type="submit" value="Send"  /></li>
    <li><input class="controlgrey" name="Back" type="button" value="Back" onclick="javascript:history.go(-1)" /></li>
</ul>

</form>
</div>

{literal}
<script language="javascript">
function classChange(val)
{
	if(val =='business')
	{
	document.getElementById('do').value='Business';
	document.getElementById('action').value='passwordSent';
	}else{
	document.getElementById('do').value='Affiliate';
	document.getElementById('action').value='passwordSent';
	}

}

function validate()
{

	if(document.loginform.email.value == "")
	{
	alert('Please Enter the Email id for Searching ');
	document.loginform.name.focus();
	return false;
	}
	
} 
</script>
{/literal}