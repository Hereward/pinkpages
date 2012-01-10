<div class="content">
<h4 class="h4reversed"><b>Affiliate Add Form</b></h4>
            

<form id="test" action="{$action}"  name="loginForm" method="POST">

<ul class="textfieldlist">
<br />
<br />
{if $values.email eq '' && $secret_text.email eq $values.email}
	<li>
		<label>Affiliate Email: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" value="{$email}" class="textfieldshort"  /></li>
	</li>
	{else}
		<li>
		<label>Affiliate Email:</label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="email" {if $values.email eq ''} value="{$email}" {else} value="{$values.email}" {/if} class="textfieldshort" readonly="true"  /></li>
	</li>
	{/if}
	
	<li>
    	<label>First Name: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="fname" {if $values.fname eq ''} value="{$fname}" {else} value="{$values.fname}" {/if} class="textfieldshort" /></li>
	</li>
	
  	<li>
		<label>Last Name: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="lname" {if $values.lname eq ''} value="{$lname}" {else} value="{$values.lname}" {/if} class="textfieldshort" /></li>
	</li>
	
  	<li>
		<label>URL: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="url" {if $values.url eq ''} value="{$url}"{else} value="{$values.url}" {/if} class="textfieldshort" /></li>
  	</li>
	
	{if $affiliate_id eq ''}
	  	<li>
		<label>Password: <font color="#FF0000">*</font></label>
		<li><input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="password" value="" class="textfieldshort" /></li>
	</li>
	
  	<li>
		<label>Confirm Password: <font color="#FF0000">*</font></label><li>
		<input id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="password" name="cpassword" value="" class="textfieldshort" /></li>
	</li>
	{/if}
	
	
	  	<li>
		<label>Company:</label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="company" {if $values.company_name eq ''} value="{$company}" {else} value="{$values.company_name}" {/if} class="textfieldshort" /></li>
  	</li>
  
    <li>
		<label>Address 1: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="address1" {if $values.address1 eq ''} value="{$address1}" {else} value="{$values.address1}" {/if} class="textfieldshort" /></li>
	</li>

    <li>
		<label>Address 2: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="address2" {if $values.address2 eq ''} value="{$address2}" {else} value="{$values.address2}" {/if} class="textfieldshort" /></li>
	</li> 
	
    <li>
		<label>City: <font color="#FF0000">*</font></label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="city" {if $values.city eq ''} value="{$city}" {else} value="{$values.city}" {/if} class="textfieldshort" /></li>
	</li>
 
    <li>
    <label>Zipcode</label>
	<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="zipcode" {if $values.zipcode eq ''} value="{$zipcode}" {else} value="{$values.zipcode}" {/if} class="textfieldshort" /></li>
	</li>
  
    <li>
		<label>State</label>
		<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="state" {if $values.state eq ''} value="{$state}" {else} value="{$values.state}" {/if} class="textfieldshort" /></li>
	</li>
  
       <li>
    <label>Country</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="country" {if $values.country eq ''} value="{$country}" {else} value="{$values.country }" {/if} class="textfieldshort" />
  </li></li>
  
       <li>
    <label>Phone</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="phone" {if $values.phone eq ''} value="{$phone}" {else} value="{$values.phone}" {/if} class="textfieldshort" />
  </li></li>
  
       <li>
    <label>Fax</label><li>
	<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="fax" {if $values.fax eq ''} value="{$fax}" {else} value="{$values.fax}" {/if} class="textfieldshort" />
  </li></li>
  
		<li>
		<label>Tax ID</label><li>
		<input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="tax_id" {if $values.tax_id eq ''} value="{$tax_id}"{else} value="{$values.tax_id}" {/if} class="textfieldshort" />
		</li></li>
		
		<li>
		<label>Time Zone</label><li>
		<select name="timezone" id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" >			
		<option value="Pacefic" {if $values.timezone eq ''} selected="selected"{else} selected="selected" {/if} >Pacefic</option>
		<option value="Asia" {if $values.timezone eq ''} selected="selected"{else} selected="selected" {/if}>Asia</option>
		</select>
		</li>
		<br />
		<br />
		{if $values.secret_text eq '' && $secret_text.secret_text eq ''}
			<li>
				<label>Secret Text <font color="#FF0000">*</font></label>
				<li><input  id="ctl00_CPHContent_ctlUpdateTask1_txtPctComplete" type="text" name="secrettext" value="" class="textfieldshort" />
				<label><font color="#FF0000" face="Geneva, Arial, Helvetica, sans-serif">(Please enter the secret text. This text should be remembered at the time when you forget your password.)</font></label>
				</li>
			</li>
			{/if}

		
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

