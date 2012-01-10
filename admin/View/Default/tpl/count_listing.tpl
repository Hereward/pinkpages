<div class="content">
<!--<table>
	<tr>
		<td class="active"><a href="{$sitePerformanceReport}" ><font color="#FF3399" size="-2">Site Performance</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$pagePopularityReport}" ><font color="#FF3399" size="-2">Page Popularity</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$fetchUniqueClients}"  ><font color="#FF3399" size="-2">Unique Clients list</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$classificationStats}" ><font color="#FF3399" size="-2">Classification Stats</font></a></td>
		<td>|</td>		
		<td ><a href="{$clients_in_specific_locality}"  ><font color="#FF3399" size="-2">Locality Based Client</font></a></td>
	</tr>
	<tr>
	    <td><a href="{$failed_searches}" ><font color="#FF3399" size="-2">Failed Searches</font></a></td> 
		<td>|</td>
		<td><a href="{$count_listing}"  >{if  $action eq 'count_listing'}<b><font color="#FF3399" size="-2">Count Listing</font></b></a>{/if}</td> 
	</tr>
</table><br /><br /> -->
<h3><center><b>Listings</b></center></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr class="h4reversed"><td><b>Based On</b></td></tr>
	 <tr class="odd"><td><a href="{$count_listings_in_vertical}"><font color="#FF3399">Count of Listings in Vertical</a></td></tr>
	 <tr><td><a href="{$count_listings_in_classification}"><font color="#FF3399">Count of Listings in Classification</a></td></tr>
	 <tr class="odd"><td><a href="{$count_listings_in_locality}"><font color="#FF3399">Count of Listings in Locality</a></td></tr> 
	 
      
     
	
	
   
	   
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
