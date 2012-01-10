<div class="content0left">
<div class="content"> 
 <span id="ctl00_CPHTitle_lblTaskTitle">Profile Updated Successfully </span> 
 <h2 class="green">
          
<span id="ctl00_CPHTitle_lblTaskTitle">Edit Profile Form </span>

</h2>
<ul class="textfieldlist">
<form id="test" action="{$action}={$values1[0].client_id}" method="POST">
<ul class="textfieldlist">
<li>
    <label> Name</label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="clientname" value="{$values1[0].client_name}" class="textfieldshort" readonly="{$values1[0].client_name}"  />
  </li></li>
  <li>
    <label>Password</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="password" value="{$values1[0].passwd}" class="textfieldshort" readonly="{$values1[0].passwd}"/>
  </li></li>
  <li>
    <label>Email</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" value="{$values1[0].email}" class="textfieldshort" readonly="{$values1[0].email}" />
  </li></li>
  <li>
    <label>Postcode</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="postcode" value="{$values1[0].postcode}" class="textfieldshort" readonly="{$values1[0].postcode}"/>
  </li></li>
  <li>
    <label>Phone No.</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" value="{$values1[0].phone}" class="textfieldshort" readonly="{$values1[0].phone}"/>
  </li></li>
  <li>
    <label>Access</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="access" value="{$values1[0].client_access}" class="textfieldshort" readonly="{$values1[0].client_access}" />
  </li></li>
</ul>
<ul class="controlbar" >
 
    <input type="submit" name="submit" value="save"  id="ctl00_CPHContent_ctlUpdateTask1_btnUpdateTask" class="controlgreen"/>
						&nbsp;&nbsp;&nbsp;
</ul>
</form> 
</div>
</div>
{literal}
<script type="text/javascript">
	function formCallback(result, form) 
	{
		window.status = "valiation callback for form '" + form.id + "': result = " + result;
	}
	
	var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});

</script>
{/literal}