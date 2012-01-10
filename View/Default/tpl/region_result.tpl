<div class="navigation"><img src="{$BANNER_PATH}" alt="" width="" /></div>
<div class="content">
       
  <h2 class="black">All Searches</h2>
       
  <h4 class="h4reversed">{if $CountResult neq ''} {$CountResult} records found that matched '{$searchValue1}'.Please select the most appropriate classification to continue your search.{else} {$normalcount} records found that matched '{$searchValue1}'.Please select the most appropriate classification to continue your search.{/if}</h4>
        	
			  <table class="datatable">
		{assign var="j" value=0}
		{section name=i loop=$getRegionResult}
         
			<tr class="{if $j % 2==0}{else}odd{/if}">

	

			<td><a href="{$getRegionResult[i].link}">{$getRegionResult[i].localclassification_name}</a></td><td>[{$getRegionResult[i].count_localclassification_name}]</td>
			</tr>
		{assign var="j" value=$j+1}
		{/section}
			</table>
			{include file="pagination.tpl"}   
	 <div class="sitebanner"><a href="http://{$bannerArray1[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray1[0].banner_name}" alt="{$bannerArray1[0].alt_text}" width="{$bannerArray1[0].banner_width}" /></a> </div>
      
</div>
<!--<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>-->