<div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">
<a name="top"></a>


  <table class="topnotice" width="99%"><tr><td>
<h1>Business category result for the letter <span>'{$smarty.get.search|capitalize}'</span></h1>
  	</tr></td></table>

<br />

	<table class="datatable-classnew">
		{foreach from=$values key=j item=classification}
		<tr >
		<td width="5px"></td>
			<td ><a href="{$classification.link}">{$classification.localclassification_name} &nbsp;&nbsp;&nbsp;&nbsp;  <span>{$classification.count_localclassification_name} results</span></a></td>
			
		</tr>
		{/foreach}
		{if count($values) < 1}
		<tr class="{if $j % 2==0}{else}odd{/if}">
			<td colspan="2">No Records Found</td>
		</tr>
		{/if}
	</table><br /><br />
	  <center>	<a href="#top" class="alpha_links_small">Return to top of page</a></center>
	<div align="center">{include file="pagination.tpl"}</div>
    <div class="alpha_links_small" align="center"><br />
<table class="alpha_links_small">
<tr><td width="80px">
Search Business Categories:	&nbsp;</td><td>
	{foreach from=$alpha_links item=alpha key=key}
		{if $searchLetter eq $alpha.text}
			<span>{$alpha.text}</span>
		{else}
			<a href="{$alpha.link}">{$alpha.text}</a>
		{/if}
		{if $key < 25} |{/if} 
	{/foreach}
	</td></tr></table>
	
	</div>
</br>
{if $bannerArray[0].banner_name neq ''}	
	 <div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
	 {else}
	 
	  <div class="sitebanner">
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
	</br>


	  
</div>



{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div>