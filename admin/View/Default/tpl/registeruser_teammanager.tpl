<div class="content0left">
<div class="content">
 <h4 class="h4reversed" >
            
<b>Add Member </b>

</h4>
<form id="test" action="{$action}" method="POST">
<ul class="textfieldlist" >
<li>
    <label>First Name: <font color="#FF0000">*</font></label><li>
    <input   type="text" name="firstname" value="{$firstname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Surname: <font color="#FF0000">*</font></label><li>
    <input   type="text" name="surname" value="{$surname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Username: <font color="#FF0000">*</font></label><li>
    <input   type="text" name="username" value="{$username}" class="textfieldshort"  />
  </li></li>  
    
  <li>
    <label>Password: <font color="#FF0000">*</font></label><li>
	<input  type="password" name="password" value="" class="textfieldshort" />
  </li></li>
  <li>
    <label>Confirm Password: <font color="#FF0000">*</font></label><li>
	<input  type="password" name="confirmPassword" value="" class="textfieldshort" />
  </li></li>  
  <li>
    <label>Email: <font color="#FF0000">*</font></label><li>
	<input  type="text" name="email" value="{$email}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Address: </label><li>
	<input  type="text" name="address" value="{$address}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Phone No:</label><li>
	<input   type="text" name="phone" value="{$phone}" class="textfieldshort" />
  </li></li>
  
  <li>
    <label>Mobile:</label><li>
	<input   type="text" name="mobile" value="{$mobile}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Access: <font color="#FF0000">*</font></label><li>
	<select name="access" id="type" >			
					  <option value="admin" >Admin</option>
					  <option value="SAcManager" >Sales Account Manager</option>
					  <option value="Employee" > Employee</option>
    			    </select>
  </li></li>
</ul>
<ul class="controlbar" >
  <div align="center">
    <input type="submit" name="submit" value="save"   class="controlgrey"/>
						
  </div>
</ul>
</form> 
</div>
</div>