<div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">
  <table class="topnotice" width="99%"><tr><td>
  	{if $total_recs > 0}
    <center>
      <h1 style="margin:0px; padding:0px; line-height:auto;">Please choose a Category for <span>'{$smarty.get.Search1|lower|capitalize}'</span> from the list below</h1></center>
      </td></tr>
  	</table>
  	
  	

        	<br />
	<table style="margin-top:0px; padding-top:0px; border-top:2px solid gray;" class="datatable-classnew" >
		{section name=i loop=$values}
       
			<tr>

			<td onmouseover="this.style.backgroundColor='#FCEDF6';" onmouseout="this.style.backgroundColor='#FFFFFF';" style="background-color:#FFFFFF; border-bottom:1px solid gray;"> &nbsp;&nbsp;&nbsp;&nbsp;  
			<a style=" font-size: 16px; font-weight: normal" 
			href="{$values[i].link}{if $smarty.get.Suburb}&Suburb={$smarty.get.Suburb}{/if}"> 
			{$values[i].localclassification_name|lower|capitalize}&nbsp; <span style="color:gray; font-weight: bold;">
			({$values[i].cnt})</span>
			<span style="float:right;">View Listings</span></a></td>
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
{*
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
*}
	{/if}
	
	
	
	<table class="topnotice" width="99%">
      
      <tr><td>
		{if $ambiguous}

			{if $smarty.get.c == 'r'}<b>
				Showing results under Region <span><b>{$location}</b></span></a></br>
				<a href="{$suburb_link}"><b>Click to see all results from Suburb <span>{$ambg_suburb_name}</span></b></a><br />
			{else}
				<b>Showing results under Suburb <span><b>{$location}</b></span></a></br>
				<a href="{$region_link}" ><b>Click to see all results from Region <span>{$ambg_region_name}</span></b></a><br />
			{/if}

		{/if}
     </td></tr>
  	</table>
	{else}
	Sorry, your search for <span><strong>{$keyword}</strong></span> in <span><strong>{$smarty.get.Search2}</strong></span> returned no results. <br />Please try again using a different keyword or location.<br />
    <a href="{$business_name_search}">Not what you were looking for?<br /> Try searching for <span><strong>{$smarty.get.Search1}</strong></span> in a business name instead</a>
    </td></tr>
  	</table>
  	
  	 <form id="test" action="main.php" name="Homepage" method="get" >
			<input type="hidden" id="testid" value="" disabled="disabled" />	
			<input type="hidden" id="do" name="do" value="Listing" />
			<input type="hidden" id="action" name="action" value="searchKeyword" />
  	
  	
  	<div class="product-search">
	<ul class="search">
      	<li>
        	<h2>Product or Service</h2>
            <br>
			<p class="sideinput"><input type="text" value="{if ($default_keyword)}{$default_keyword|stripslashes}{else}{$keyword|stripslashes}{/if}"  class="largeinputbox" size="17"  id="Search1" name="Search1" required></p>	
		
		</li>
      	<li>
        	<h2>Location</h2>
            <br>
			<p class="sideinput"><input type="text" class="largeinputbox" size="17" id="Search2" name="Search2"></p>
        </li>
        <li>
        {* <input type="image" hspace="10" value="Search" id="Submit" name="Submit" class="search-button" src="{$IMAGES_PATH}sidesearch.gif"> *}
        <input class="search-button" hspace="10" src="{$IMAGES_PATH}sidesearch.gif" type="image" name="Submit" id="Submit" value="Search" />
        </li>
	</ul>
				<label for="Search1" generated="true" class="error" style="background-color:#E9138F; font-weight:bold; color:black; padding:3px; border:1px solid #E9138F; left:25px; top:-30px; position:relative; display: none;">Please enter a keyword or business name</label>				  					
	
   </div>
   </form>
   
   <form id="test2" onsubmit="" method="get" action="main.php" novalidate="novalidate">
<input id="testid" type="hidden" disabled="disabled" value="">
<input id="do" type="hidden" value="Listing" name="do">
<input id="action" type="hidden" value="search" name="action">
   
   <div class="product-search">
	<ul class="search">
      	<li>
        	<h2>Business Name</h2>
            <br>
			<p class="sideinput-long"><input type="text" class="largeinputbox" size="17"  id="Search1" name="Search1" autocomplete="off"></p>					  					
		</li>
      	
        <li>
        <input type="image" hspace="10" value="Search" id="Submit" name="Submit" class="search-button" src="{$IMAGES_PATH}sidesearch.gif">
        </li>
	</ul>
   </div>
 </form>
   
   {literal}
<script type="text/javascript">
// hello
$(function () {
		//$("#Search1").watermark("What?");
		$("#Search1Focus").click(
			function () {
				$("#Search1")[0].focus();
			}
		);
});

$(function () {
	$("#Search2").watermark("Where?");
	$("#Search2Focus").click(
		function () {
			$("#Search2")[0].focus();
		}
	);
});

$().ready(function() {
   // $('#test').validate( {invalidHandler: $.watermark.showAll} );


    $("#test").validate({
		rules: {
    	    Search1: "required"
		},
		messages: {
			Search1: "Please enter a keyword or business name"
		}
	});
});

</script>
{/literal}
	
	{/if}
	
    
	
  	
      
</div>


<!--Search box starts-->
{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div></div>

<script language="javascript1.5" src="{$JS_PATH}search.js" type="text/javascript" >
</script>
