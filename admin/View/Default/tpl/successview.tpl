<h2>sucess..</h2><!--.click here to view details<a href="{$back}" >view</a> -->
<table width="212" border="1" cellpadding="0" cellspacing="0" align="center">

    <tr>
        <td width="70"></td>
        <td width="67"></td>
        <td width="67"></td>
    </tr>


    <tr>

        <td height="75" align="center" bgcolor="#FF99CC" ><b>FIRST NAME</b></td>
        <td height="75" align="center" bgcolor="#FF99CC" ><b>LAST NAME</b></td>
        <td height="75" align="center" bgcolor="#FF99CC" ><b>PHONE NUMBER</b></td>
        <td height="75" align="center" bgcolor="#FF99CC" ><b>MOBILE NUMBER</b></td>
        
        <td height="75" align="center" bgcolor="#FF99CC"><b>EMAIL</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>USERNAME</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>ACCESS</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>ADDRESS</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>Action</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>Status</b></td>

<!--<td height="75"align="center"><b>STATE</b></td>
<td height="75" align="center"><b>COUNTRY</b></td>
<td height="75" align="center" ><b>FAX</b></td>
<td height="75" align="center"><b>TAX ID</b></td> 
<td height="75"align="center"><b>ADDRESS</b></td>-->
    </tr>
    {foreach from=$values1 item=key}
    <tr>

        <td height="75" align="center">{$key.localuser_firstname}</td>
        <td height="75" align="center">{$key.localuser_surname}</td>
        <td height="75" align="center">{$key.localuser_phone}</td>
        <td height="75" align="center">{$key.localuser_mobile}</td>
        
        <td height="75" align="center">{$key.localuser_email}</td>
        <td height="75" align="center">{$key.localuser_username}</td>
        <td height="75" align="center">{$key.localuser_access}</td>
        <td height="75" align="center">{$key.localuser_address}</td>
        
        <td height="75" align="center"><a href="{$edit_url}={$key.localuser_id}" >edit</a>/<a href="main.php?do=Admin&action=delete&ID={$key.localuser_id}" onClick="alert('want to de-activate user?');" >Delete</td>
        <td height="75" align="center">{if $key.localuser_status eq 'A'}Active{else}Inactive{/if}</td>

        <!--<td height="75"align="center">{$key.state}</td>
        <td height="75" align="center">{$key.country}</td>
        <td height="75" align="center" >{$key.fax}</td>
        <td height="75" align="center">{$key.taxid}</td> 
        <td height="75"align="center">{$key.address}</td>--> 
    </tr>
    {/foreach}
</table>
<table border=1 cellpadding="2" cellspacing="0">
    <tr><td><a href="{$reg_url}"/>Add User</td></tr>
</table>
