<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Business Service</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="post" enctype="multipart/form-data" onsubmit="return checkValue();" >
<br />
<ul class="textfieldlist">

<li>
   <label>Business Service:  <font color="#FF0000">*</font></label>
    
   	 <input  id="service" type="text" name="service" value="{$service}"  class="textfieldshort" />
</li>	
</ul>

<ul class="controlbar"> 
<div align="center">
<input type="submit" name="submit" value="Add" class="controlgrey"  />
<!--<a href="{$cancel}" style="text-decoration:none"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a> -->
<!--<a href="{$view}" style="text-decoration:none"><font color="#CC3399">View Keywords</font></a> -->
</div>
</ul> 
 
</form>
</div>
</div>

 {literal}
<script type="text/javascript">

function checkValue()
{
	if(document.getElementById('service').value == '')
	{
		alert('Enter any Service');
		return false;	
	}else{
		return true;
	}
}
 function setPostCode(val)
 { 
   temp=val.split(';');
   document.loginForm.postcode.value = S=temp[0];
 
 }

function preview() 
{
document.loginForm.pic.src = document.loginForm.logo.value;
}
</script>
{/literal}
