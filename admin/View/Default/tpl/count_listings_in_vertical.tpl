<div class="content">
<!--<table>
	<tr>
		<td class="active"><a href="{$sitePerformanceReport}" ><font color="#FF3399" size="-2">Site Performance</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$pagePopularityReport}" ><font color="#FF3399" size="-2">Page Popularity</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$fetchUniqueClients}" ><font color="#FF3399" size="-2">Unique Clients list</font></a></td>
		<td>|</td>		
		<td class="active"><a href="{$classificationStats}" ><font color="#FF3399" size="-2">Classification Stats</font></a></td>
		<td>|</td>		
		<td ><a href="{$clients_in_specific_locality}"  ><font color="#FF3399" size="-2">Locality Based Client</font></a></td>
	</tr>
	<tr>
	    <td><a href="{$failed_searches}" ><font color="#FF3399" size="-2">Failed Searches</font></a></td> 
		<td>|</td>
		<td><a href="{$count_listing}"  >{if $action eq 'count_listings_in_vertical'}<b><font color="#FF3399" size="-2">Count Listing</font></b>{/if}</a></td> 
	</tr>
</table><br /><br /> -->
<h3><center><b>Listings In verticals</b></center></h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">
     <tr class="h4reversed">
		<td><b>Vertical Title</b></td>
		<td><b>Ranked Listing Count</b></td>
		<td><b>Free Listing Count</b></td>
		<td><b>Total Listing Count</b></td>		  
    </tr>
       
	 {assign var="j" value=0}
     {foreach from=$values1 item=key}
	 <tr class="{if $j % 2==0}{else}odd{/if}">
		<td>{$key.vertical_title}</td>
		<td>{$key.ranked_cnt[0]}</td>
		<td>{$key.free_cnt[0]}</td>
		<td>{$key.ranked_cnt[0]+$key.free_cnt[0]}</td>
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
