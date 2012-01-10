<div class="content">
<h4 class="h4reversed"><b>Affiliate Edit Details</b></h4>
<form id="test" action="{$action}={$values1[0].affiliate_id}"  name="loginForm" method="POST">

<ul class="textfieldlist">
<br />
<br />

		<li>
		<label>Affiliate Email:</label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email"  value="{$values1[0].email}"  class="textfieldshort" readonly="true"  /></li>
	</li>

	
	<li>
    	<label>First Name: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="fname"  value="{$values1[0].fname}"  class="textfieldshort" /></li>
	</li>
	
  	<li>
		<label>Last Name: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="lname"  value="{$values1[0].lname}"  class="textfieldshort" /></li>
	</li>
	
  	<li>
		<label>URL: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="url"  value="{$values1[0].url}"  class="textfieldshort" /></li>
  	</li>
	
	<li>
		<label>Company:</label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="company"  value="{$values1[0].company_name}"  class="textfieldshort" /></li>
  	</li>
  
    <li>
		<label>Address 1: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="address1" value="{$values1[0].address1}"  class="textfieldshort" /></li>
	</li>

    <li>
		<label>Address 2: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="address2" value="{$values1[0].address2}"  class="textfieldshort" /></li>
	</li> 
	
    <li>
		<label>City: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="city" value="{$values1[0].city}"  class="textfieldshort" /></li>
	</li>
 
    <li>
    <label>Zipcode</label>
	<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="zipcode" value="{$values1[0].zipcode}"  class="textfieldshort" /></li>
	</li>
  
    <li>
		<label>State</label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="state" value="{$values1[0].state}"  class="textfieldshort" /></li>
	</li>
  
       <li>
    <label>Country</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="country" value="{$values1[0].country }" class="textfieldshort" />
  </li></li>
  
       <li>
    <label>Phone</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" value="{$values1[0].phone}" class="textfieldshort" />
  </li></li>
  
       <li>
    <label>Fax</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="fax" value="{$values1[0].fax}"  class="textfieldshort" />
  </li></li>
  
		<li>
		<label>Tax ID</label><li>
		<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="tax_id" value="{$values1[0].tax_id}"  class="textfieldshort" />
		</li></li>
		
		<li>
		<label>Time Zone</label><li>
		<select name="timezone" id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" >			
		<option value="Pacefic" {if $values1[0].timezone eq ''} selected="selected"{else} selected="selected" {/if} >Pacefic</option>
		<option value="Asia" {if $values1[0].timezone eq ''} selected="selected"{else} selected="selected" {/if}>Asia</option>
		</select>
		</li>
		<br />
		<br />
			
		</li></li>
		</li></li>
		</li></li>
</ul>
<ul></ul>
<ul></ul>
<ul></ul>
<ul class="controlbar">
    <li><input class="controlgrey" name="Save" type="submit" value="Save" /></li>
    <li><input class="controlgrey" name="Save" type="button" value="Back" onclick="javascript:history.back();"/></li>
</ul>

</form>
</div>

