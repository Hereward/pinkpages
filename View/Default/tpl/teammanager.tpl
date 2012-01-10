<div class="content">
<ul class="green"><span id="ctl00_CPHTitle_lblTaskTitle"> <h4>Profile Updated</h4></span></ul>
<table class="datatable" width="200" border="0" cellpadding="0" cellspacing="0" align="center">

    <tr class="odd">

        <td height="75" align="center" bgcolor="#FF99CC"><b>NAME</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>PHONE</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>EMAIL</b></td>
        <td height="75" align="center" bgcolor="#FF99CC"><b>POSTCODE</b></td> 
        <td height="75" align="center" bgcolor="#FF99CC"><b>ACCESS</b></td>

    </tr>
    {foreach from=$values item=key}
    <tr class="odd">

        <td height="75" align="center">{$key.client_name}</td>
        <td height="75" align="center">{$key.phone}</td>
        <td height="75" align="center">{$key.email}</td>
        <td height="75" align="center">{$key.postcode}</td>  
        <td height="75" align="center">{$key.client_access}</td> 

    </tr>
</table> 