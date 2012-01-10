<div class="content">
<!--<table>
	<tr>
		<td class="active"><a href="{$sitePerformanceReport}" ><font color="#FF3399" size="-2">Site Performance</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$pagePopularityReport}" ><font color="#FF3399" size="-2">Page Popularity</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$fetchUniqueClients}"  ><font color="#FF3399" size="-2">Unique Clients list</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$classificationStats}"  ><font color="#FF3399" size="-2">Classification Stats</font></a></td>
		<td>|</td>		
		<td ><a href="{$clients_in_specific_locality}"   >{if $action eq 'clients_in_specific_locality'}<b><font color="#FF3399" size="-2">Locality Based Client</font></b></a>{/if}</td>
	</tr>
	<tr>
	    <td><a href="{$failed_searches}" ><font color="#FF3399" size="-2">Failed Searches</font></a></td> 
		<td>|</td>
		<td><a href="{$count_listing}"  ><font color="#FF3399" size="-2">Count Listing</font></a></td> 
	</tr>
</table><br /><br /> -->
<h3><center><b>Locality Based Clients</b></center></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr class="h4reversed">
	      <td><b>Locality</b></td>
		 <td><b>Name</b></td>
		 <td><b>Email</b></td>
		 <td><b>Postcode</b></td>
		 <td><b>Phone</b></td>
	</tr>
     {if $count eq ''}
	    <tr class="{if $j % 2==0}{else}odd{/if}">
    	    <td><td><td>No Record Found.</td></td></td>
		</tr>
	 {else}  
	 {assign var="j" value=0}
     {foreach from=$values2 item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
	    <td>{$key.business_suburb}</td>
	   <td>{$key.client_name}</td>
	   <td>{$key.email}</td>
	   <td>{$key.postcode}</td>
	   <td>{$key.phone}</td>
	</tr>
	 {assign var="j" value=$j+1}
    {/foreach}	
	{/if}
	   
</table>
<div align="center"> {include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(val)
{
	var answer = confirm  ("Are you sure,you want to delete?");
	if (answer)
	 window.location.href=val;
	else
		{;}

}
</script>
{/literal}
