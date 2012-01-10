<div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">


  <table class="topnotice" width="99%">
  {$msg} {$msg1}
  	<b>{if $msg eq '0' OR $msg1 eq '2'}<tr><td>
  <center>
      <h1>No results found</h1></center></td></tr><tr><td><b>Sorry, your search for <strong>{$smarty.get.Search1|stripslashes}</strong> in <strong>{$smarty.get.Search2}</strong> returned no results <br />Please try a different street name in the street name search box</b>
  	
  	{else}
    <tr><td>
  <center>
      <h1>Please refine your search further</h1></center></td></tr><tr><td>
  <b>	The following suburbs were found that matched <span>'{$smarty.get.Search2}'</span><br />
   Please select a suburb  to continue your search</b>
   {/if}
  	</tr></td></table>

        	
		<table class="datatable-classnew" align="center">
		{assign var="j" value=0}
		
		{foreach from=$all_regions item=i key=key}
         
			<tr>
<td width="5px"></td>
			<td>
				<strong>{$i.region_name}</strong><br />
				{foreach from=$i.suburbs item=suburb}
				<span class="width300"><a href="{$suburb.suburb_link}">{$suburb.shiretown_townname}</a></span>
				<span>{$suburb.shiretown_postcode}</span><br />
				{/foreach}
				
			</td>
			</tr>
		{assign var="j" value=$j+1}
		{/foreach}
		</table>
		

		
	 <div class="sitebanner"><a href="http://{$bannerArray1[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray1[0].banner_name}" alt="{$bannerArray1[0].alt_text}" width="{$bannerArray1[0].banner_width}" /></a> </div>
  
    
</div>

<!--Search box starts-->
{include file="side_street_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div>
  	
{if $bannerArray[0].banner_name neq ''}
<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray[0].banner_name}" border="0" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
</div>
{/if}</div>