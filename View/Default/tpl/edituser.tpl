<div class="content">
<h4 class="h4reversed"><b>Edit Profile</b></h4>

<ul class="textfieldlist">
<form id="test" action="{$action}={$values1.client_id}" method="POST">
<ul class="textfieldlist">
<br />
<li>
    <label>Name:</label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="clientname" value="{$values1.client_name}" class="textfieldshort"  />
  </li></li>

<li> 
    <label>Email:</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" value="{$values1.email}" class="textfieldshort" readonly="{$values1.email}" />
  </li></li>
  <li>
    <label>Postcode:</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="postcode" value="{$values1.postcode}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Phone No.:</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" value="{$values1.phone}" class="textfieldshort" />
  </li></li>
  <br />
  
</ul>
<ul class="controlbar">
<div align="center">
    <input class="controlgrey" name="Save" type="submit" value="Save" />
	<a href="{$cancel}" ><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>
</ul>
</form>
</div>