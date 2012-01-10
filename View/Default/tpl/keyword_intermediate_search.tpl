<div class="white-sperater">
</div>
{include file="left_form.tpl"}
<div class="content">    

	

  <table class="topnotice" width="99%"><tr><td>
  <center>
      <h1>Please refine your search further</h1></center></td></tr><tr><td>
  	<b>{if $msg eq '0' OR $msg1 eq '2'}Sorry, your search for <span>'{$smarty.get.Search1|stripslashes}'</span> in <span>'{$smarty.get.Search2}'</span> returned no results<br />Please try again using a different keyword or location{else}
   Please select a location  to continue your search<br />The following locations were found that matched <span>'{$smarty.get.Search2}'</span>{/if}</b>
  	</tr></td></table>

        	
		<table class="datatable-classnew" align="center">
		{assign var="j" value=0}
		
		{foreach from=$all_regions item=i key=key}
         
			<tr>
               <td width="5px"></td>
			<td>
				<a href="{$i.region_link}"><strong>{$i.region_name}</strong></a><br />
				{foreach from=$i.suburbs item=suburb}
				<span class="width300"><a href="{$suburb.suburb_link}">{$suburb.shiretown_townname}</a></span>
				<span>{$suburb.shiretown_postcode} {$suburb.localstate_name} </span><br />
				{/foreach}
				
			</td>
			</tr>
		{assign var="j" value=$j+1}
		{/foreach}
		</table>
		
    <br />		  	
	 {if $bannerArray[0].banner_name neq ''}
	<a href="http://{$bannerArray1[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray1[0].banner_name}" alt="{$bannerArray1[0].alt_text}" width="{$bannerArray1[0].banner_width}" /></a>
	
	{elseif $bannerArray1[0].html_code neq ''}
	<div class="sitebanner">{$bannerArray1[0].html_code}</div>

	
	
    {else}
    <div class="sitebanner" align="center">
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

	<!--<script type="text/javascript">initializetabcontent("maintab")</script>-->
<!--Search box starts-->
{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div>
{if $bannerArray[0].banner_name neq ''}
<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray[0].banner_name}" border="0" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
{/if}
