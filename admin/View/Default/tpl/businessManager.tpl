<div class="content-big">
<table width="212" border="1" cellpadding="0" cellspacing="0" align="center">
<h1>{php} if($_GET['action'] == 'adminBusinessManager'){echo "Business Manager";}{/php} </h1>
<tr><td width="70"></td>
<td width="67"></td>
<td width="67"></td>
</tr>


<tr>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><input type="checkbox"></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>First Name</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Last Name</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Website</b></td>

<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Email Address</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Telephone No.</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Mobile No.</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Fax</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Contract Start Date</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Contract End Date</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Edit/Add fields</b></td>
<td height="75" align="center" style="background-color:#FF99CC; width:100px"><b>Delete</b></td>
</div>

<!--<td height="75"align="center"><b>STATE</b></td>
<td height="75" align="center"><b>COUNTRY</b></td>
<td height="75" align="center" ><b>FAX</b></td>
<td height="75" align="center"><b>TAX ID</b></td> 
<td height="75"align="center"><b>ADDRESS</b></td>-->
</tr>
{foreach from=$values item=key}
<tr>

<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>
<td height="75" align="center"></td>



</tr>
{/foreach}
</table>
<table border=1 cellpadding="2" cellspacing="0">
<tr><td><a href="{$reg_url}"/>Add User</td></tr>
</table>
