<div class="content">
<!--<table>
	<tr>
		<td class="active"><a href="{$sitePerformanceReport}" ><font color="#FF3399" size="-2">Site Performance</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$pagePopularityReport}" ><font color="#FF3399" size="-2">Page Popularity</font></a></td>
		<td>|</td>		
		<td><a href="{$fetchUniqueClients}" >{if $action eq 'fetchUniqueClients'}<b><font color="#FF3399" size="-2">Unique Clients list</font></b>{/if}</a></td>
		<td>|</td>		
		<td class="active"><a href="{$classificationStats}" ><font color="#FF3399" size="-2">Classification Stats</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$clients_in_specific_locality}" ><font color="#FF3399" size="-2">Locality Based Client</font></a></td>
	</tr>
	<tr>
	    <td><a href="{$failed_searches}" ><font color="#FF3399" size="-2">Failed Searches</font></a></td> 
		<td>|</td>
		<td><a href="{$count_listing}" ><font color="#FF3399" size="-2">Count Listing</font></a></td> 
	</tr>
</table><br /><br /> -->
<h3  ><center><b>Unique Client List</b></center></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr class="h4reversed">
		 <td><b>Name</b></td>
		 <td><b>Email</b></td>
		 <td><b>Postcode</b></td>
		 <td><b>Phone</b></td>
		</tr>
       
	 {assign var="j" value=0}
     {foreach from=$values1 item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
	   <td>{$key.client_name}</td>
	   <td>{$key.email}</td>
	   <td>{$key.postcode}</td>
	   <td>{$key.phone}</td>
	</tr>
	 {assign var="j" value=$j+1}
    {/foreach}	
		 
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
