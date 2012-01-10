<h2>New Listing </h2>
<table class="datatable" width="212" border="1" cellpadding="0" cellspacing="0" align="center">
       
        <!--<td height="75" align="center" style="background-color:#FF99CC;"><b>business_initials</b></td> -->
        <td  align="center" class="h4reversed"><b>Business Name</b></td>
        <td  align="center" class="h4reversed"><b>Business Suburb</b></td>
        <td  align="center" class="h4reversed"><b>Shiretown ID</b></td>
        
        <td  align="center" class="h4reversed"><b>Business Postcode</b></td>
        <td  align="center" class="h4reversed"><b>Business Phonestd</b></td>
        <td  align="center" class="h4reversed"><b>Business Phone</b></td>
       <!-- <td height="75" align="center" style="background-color:#FF99CC;"><b>Action</b></td> -->
        <!--<td height="75" align="center" style="background-color:#FF99CC;"><b>business_email</b></td> -->
       <!-- <td height="75" align="center" style="background-color:#FF99CC;"><b>business_url</b></td>
		<td height="75" align="center" style="background-color:#FF99CC;"><b>business_origin</b></td>
		<td height="75" align="center" style="background-color:#FF99CC;"><b>business_mobile</b></td>
		<td height="75" align="center" style="background-color:#FF99CC;"><b>business_contact</b></td>
		<td height="75" align="center" style="background-color:#FF99CC;"><b>bold_listing</b></td>
 -->
<!--<td height="75"align="center"><b>STATE</b></td>
<td height="75" align="center"><b>COUNTRY</b></td>
<td height="75" align="center" ><b>FAX</b></td>
<td height="75" align="center"><b>TAX ID</b></td> 
<td height="75"align="center"><b>ADDRESS</b></td>-->

	{assign var="j" value=0}
    {foreach from=$values item=key}
   <tr class="{if $j % 2==0}{else}odd{/if}">

        <!--<td height="75" align="center">{$key.business_initials}</td> -->
        <td  align="center">{$key.business_name}</td>
        <td  align="center">{$key.business_suburb}</td>
        <td  align="center">{$key.shiretown_id}</td>
        
        <td  align="center">{$key.business_postcode}</td>
        <td  align="center">{$key.business_phonestd}</td>
        <td  align="center">{$key.business_phone}</td>
        <!--<td height="75" align="center">{$key.business_faxstd}</td>
		<td height="75" align="center">{$key.business_fax}</td>
		<td height="75" align="center">{$key.business_email}</td>
		<td height="75" align="center">{$key.business_url}</td>
		<td height="75" align="center">{$key.business_origin}</td> -->
		<!--<td height="75" align="center">{$key.shiretown_id}</td> -->
		<!--<td height="75" align="center">{$key.business_mobile}</td>
		<td height="75" align="center">{$key.business_contact}</td>
		<td height="75" align="center">{$key.bold_listing}</td> -->
        
        <!--<td height="75" align="center"><a href="{$edit_url}={$key.business_id}" >edit</a>/<a href="{$delete}={$key.business_id}" onClick="alert('want to de-activate user?');" >Delete</td> -->
       <!-- <td height="75" align="center">{if $key.localuser_status eq 'A'}Active{else}Inactive{/if}</td> -->

        <!--<td height="75"align="center">{$key.state}</td>
        <td height="75" align="center">{$key.country}</td>
        <td height="75" align="center" >{$key.fax}</td>
        <td height="75" align="center">{$key.taxid}</td> 
        <td height="75"align="center">{$key.address}</td>--> 
    </tr>
	{assign var="j" value=$j+1}
    {/foreach}
</table>
<!--<table border=1 cellpadding="2" cellspacing="0">
    <tr><td><a href="{$back}"/>Back</td></tr>
</table> -->