<div class="content-big"  >
    
   <!-- <h2 class="black">LOGIN</h2> -->
    <h4 class="h4reversed"><b>Login</b></h4>
    <form id="test" name="loginForm" action="main.php" method="post">
	<input type="hidden" id="do" name="do" value="Business" />
	<input type="hidden" id="action" name="action" value="doLogin" />

        <ul class="textfieldlist">
            <li>
                <label>Email:</label>
                <input name="email" type="text" class="textfieldshort"  tabindex="1"/>
            </li>
            <li>
                <label>Password:</label>
                <input name="password" type="Password" class="textfieldshort" tabindex="2" />
            </li>
            <li>
                <label>Login As</label><li>
                <select name="type"  onchange="classChange(this.value);" tabindex="3" >
                
                <option value="business" >Business</option>
                <option value="affiliate" >Affiliate</option>
                </select>
            </li>
			<br />
			<br />
        </ul>
        
        <ul class="textfieldlist">
            <li>
                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$reg_url}" tabindex="5"><b>Business Register</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$reg_affiliate}" tabindex="6"><b>Affiliate Register</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$lostpass}" tabindex="7"><b>Lost Password</b></a></label>
            </li>
            
        </ul>
        
        <ul class="controlbar">
            <li><input class="controlgrey" name="Save" type="submit" value="Login" tabindex="4" /></li>
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
	document.getElementById('action').value='doLogin';
	}else{
	document.getElementById('do').value='Affiliate';
	document.getElementById('action').value='doLogin';
	}

}
</script>
{/literal}