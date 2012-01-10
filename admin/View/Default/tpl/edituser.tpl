<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Edit User</b></h4>
<form id="test" action="{$action}={$values1.localuser_id}" method="POST">
<ul class="textfieldlist">
<li>
    <label>First Name:&nbsp;<font color="#FF0000">*</font></label><li>
    <input  type="text" name="firstname" value="{$values1.localuser_firstname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Surname:&nbsp;<font color="#FF0000">*</font></label><li>
    <input  type="text" name="surname" value="{$values1.localuser_surname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Username:&nbsp;<font color="#FF0000">*</font></label><li>
    <input  type="text" name="username" value="{$values1.localuser_username}" class="textfieldshort" readonly="{$values1.localuser_username}"  />
  </li></li>  
    
<li>
  <label>Password:&nbsp;<font color="#FF0000">*</font></label><li>
<input type="password" name="password" value="" class="textfieldshort" />
  </li></li>
  <li>
  
  <li>
  <label>Confirm Password:&nbsp;<font color="#FF0000">*</font></label><li>
<input type="password" name="confpassword" value="" class="textfieldshort" />
  </li></li> 
  <li>
    <label>Email:&nbsp;<font color="#FF0000">*</font></label><li>
	<input type="text" name="email" value="{$values1.localuser_email}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Address:&nbsp;</label><li>
	<input type="text" name="address" value="{$values1.localuser_address}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Phone No.&nbsp;</label><li>
	<input  type="text" name="phone" value="{$values1.localuser_phone}" class="textfieldshort" />
  </li></li>
  
  <li>
    <label>Mobile&nbsp;</label><li>
	<input  type="text" name="mobile" value="{$values1.localuser_mobile}" class="textfieldshort" />
  </li></li>
  
  
  </li></li>
  <!--<li>
    <label>Access</label><li>
	<select name="access" id="type" >			
					  <option value="Admin" >Admin</option>
					  <option value="SAcManager" >Sales Account Manager</option>
					  <option value="Employee" > Employee</option>
    			    </select>
  </li></li> -->
  
  <ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Save" class="controlgrey" />
<a href="{$back}" ><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>
</ul>

</form> 
</div>

