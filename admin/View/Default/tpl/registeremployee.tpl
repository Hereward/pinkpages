<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Employee</b></h4>
<form id="test" action="{$action}" method="POST">
<ul class="textfieldlist">
<li>
    <label>First Name: <font color="#FF0000">*</font></label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="firstname" value="{$firstname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Surname: <font color="#FF0000">*</font></label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="surname" value="{$surname}" class="textfieldshort"  />
  </li></li>
  
<li>
    <label>Username: <font color="#FF0000">*</font></label><li>
    <input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="username" value="{$username}" class="textfieldshort" />
  </li></li>  
    
  <li>
    <label>Password: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="password" value="" class="textfieldshort" />
  </li></li>
  
  <li>
    <label>Confirm Password:</label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="confpassword" value="" class="textfieldshort" />
  </li></li> 
  
  <li>
    <label>Email: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" value="{$email}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Address: <font color="#FF0000">*</font></label><li>
	<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="address" value="{$address}" class="textfieldshort" />
  </li></li>
  <li>
    <label>Phone No:</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" value="{$phone}" class="textfieldshort" />
  </li></li>
  
  <li>
    <label>Mobile: </label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="mobile" value="{$mobile}" class="textfieldshort" />
  </li></li>
  
 <!-- <li>
  <select name="access">
  	<option value="Employee">Employee</option>
  	<option value="SAcManager">Sales Account Manager</option>		
  </select>
  
  </li> -->
  
</ul>
<br />
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Add" class="controlgrey"/>
<a href="{$cancel}" ><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>

  
</ul>
</form> 
</div>