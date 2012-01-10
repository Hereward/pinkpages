<div class="content">
<h3 align="left">Affiliate Report</h3>

		<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Date</b></td>
        <td class="h4reversed"><b>Total Clicks</b></td>
        <td class="h4reversed"><b>Total Views</b></td>
		 <td class="h4reversed"><b>CTR</b></td>		
		
      
 
	{assign var="j" value=0}
	{foreach from=$bannerArray item=key}  

     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td><a href="{$link_date}={$key.day}">{$key.day|date_format}</a></td>
		<td>{$key.click}</td>
        <td>{$key.view}</td>
		<td>{math equation="x/y" x=$key.click y=$key.view format="%.2f"}</td>
		   
    </tr>
	 {assign var="j" value=$j+1}
    {/foreach} 

</table>
		
</div>


