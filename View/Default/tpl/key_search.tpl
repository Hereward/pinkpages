<div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">
  <table class="topnotice" width="99%"><tr><td>
  	{if $total_recs > 0}
    <center>
      <h1>Results for <span>'{$smarty.get.Search1}'</span> category</h1></center>
      </td></tr><tr><td>
		{if $ambiguous}

			{if $smarty.get.c == 'r'}<b>
				Showing results under Region <span><b>{$location}</b></span></a></br>
				<a href="{$suburb_link}"><b>Click to see all results from Suburb <span>{$ambg_suburb_name}</span></b></a><br />
			{else}
				<b>Showing results under Suburb <span><b>{$location}</b></span></a></br>
				<a href="{$region_link}" ><b>Click to see all results from Region <span>{$ambg_region_name}</span></b></a><br />
			{/if}

		{/if}

	{else}
	Sorry, your search for <span><strong>{$keyword}</strong></span> in <span><strong>{$smarty.get.Search2}</strong></span> returned no results. <br />Please try again using a different keyword or location.<br />
    <a href="{$business_name_search}">Not what you were looking for?<br /> Try searching for <span><strong>{$smarty.get.Search1}</strong></span> in a business name instead</a>
	{/if}
	
    
	
  	</td></tr></table>

        	<br />
	<table class="datatable-classnew" >
		{section name=i loop=$values}
       
			<tr>

			<td> &nbsp;&nbsp;&nbsp;&nbsp;  <a style="font-size: 16px; font-weight: bold" href="{$values[i].link}{if $smarty.get.Suburb}&Suburb={$smarty.get.Suburb}{/if}"> {$values[i].localclassification_name}&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: normal;"> {$values[i].cnt} business results </span></a></td>
			</tr>
        
		{/section}
			</table>
			
			<div align="center">{include file="pagination.tpl"}</div>
			
			</br></br>

	
				 
		{if $bannerArray[0].banner_name neq ''}
		<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
		
		{elseif $bannerArray[0].html_code neq ''}
		<div class="sitebanner">{$bannerArray[0].html_code}</div>

		
		    {else}
		    <div class="sitebanner" align="center" width="468" height="60">
		{literal}
		    <script type="text/javascript"><!--
		google_ad_client = "pub-3947502494298555";
		/* 468x60, created 3/30/09 */
		google_ad_slot = "7650630311";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		{/literal}
		</div>
	{/if}
      
</div>


<!--Search box starts-->
{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div></div>