<div class="content">
<h3 align="left">Hourly Banner Report</h3>
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      <td class="h4reversed"><b>Date</b></td>
        <td class="h4reversed"><b>Hour</b></td>
		 <td class="h4reversed"><b>Total Clicks</b></td>
        <td class="h4reversed"><b>Total Views</b></td>
{assign var="j" value=0}
{section name=i loop=$bannerArray}
     <tr class="{if $j % 2==0}{else}odd{/if}">

		<td>{$bannerArray[i].day|date_format}</td>
		<td>{$bannerArray[i].hour}</td>
		<td>{$bannerArray[i].click}</td>
		<td>{$bannerArray[i].view}</td>
  
    </tr>
{assign var="j" value=$j+1}
{/section}
</table>
</div>