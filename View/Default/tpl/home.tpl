<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index">
    <div class="searchbox-front-left" >
    </div>
    <div class="searchbox-front-middle">
    <br />
    <span><a href="/main.php?do=Content&action=contactUs">Advertise with us</a></span>
    <p>Find businesses and organisations
    </p>
		<div class="searchbox-index-left-key">
         {* onsubmit="return check();" *}
		  <form id="test" action="main.php" name="Homepage" method="get" >
			<input type="hidden" id="testid" value="" disabled="disabled" />	
			<input type="hidden" id="do" name="do" value="Listing" />
			<input type="hidden" id="action" name="action" value="searchKeyword" />
		   <table class="searchbox-index-left" >
           <tr>
           <td class="title">
           </td>
           <td class="title">
           </td>
           <td>
           </td>
           </tr>
           
             <tr>
           <td >
           
           <p class="inputbox">
           <input type="text" name="Search1" id="Search1" required  />
           <label for="Search1" generated="true" class="error" style="background-color:#E9138F; font-weight:bold; color:black; padding:3px; border:1px solid #E9138F; top:-70px; position:relative; display: none;">Please enter a keyword or business name</label>
           </p>
           </td>
           <td><p class="inputbox"><input type="text" name="Search2" id="Search2" />
           
           </p>
           
           {*
           {if $smarty.get.p eq 's'}All Sydney
           {elseif $smarty.get.p eq 'n'}Newcastle Region
           {elseif $smarty.get.p eq 'c'}Canberra Region
           {elseif $smarty.get.p eq 'm'}All Melbourne
           {elseif $smarty.get.p eq 'all-brisbane'}All Brisbane
           {elseif $smarty.get.p eq 'gold-coast'}Gold Coast Region
           {elseif $smarty.get.p eq 'all-darwin'}All Darwin
           {elseif $smarty.get.p eq 'all-perth'}All Perth
           {elseif $smarty.get.p eq 'all-adelaide'}All Adelaide
           {elseif $smarty.get.p eq 'all-hobart'}All Hobart
           {else}All States{/if}
           *}
           </td>
         
           <td ><input class="btn" src="{$IMAGES_PATH}btn-search.gif" type="image" name="Submit" id="Submit" value="Search" />
           </td>
           </tr>
           <tr>
             <td><img src="{$IMAGES_PATH}keyword.gif" alt="Search Sydney Pink Pages for Products or Services, to search for a product or service type in a keyword such as TV or Hairdressers"  /></td>
             <td><img src="{$IMAGES_PATH}location.gif" alt="Search Sydney Pink Pages for Products or Services in a certain location, to search a location you nede to type it in for exmaple all sydney will search all sydney location and penrith will search penrith suburb" /></td>
             <td  style="vertical-align:bottom" rowspan="2">               <span class="pinkie"> <img src="{$IMAGES_PATH}pinkie.jpg" alt="Search Sydney Pink Pages for Products or Services in a certain location, to search a location you nede to type it in for exmaple all sydney will search all sydney location and penrith will search penrith suburb" /></span>		   		   		     </td>
           </tr>          		   <tr>		     <td colspan="2">               <div class="alpha_links" align="center">	             Business Types:	&nbsp;	             {foreach from=$alpha_links item=alpha key=key}		           {if $searchLetter eq $alpha.text}			         <span>{$alpha.text}</span>		           {else}			         <a href="{$alpha.link}">{$alpha.text}</a>  		           {/if} 		           {if $key < 25} |{/if} 	             {/foreach}               </div>		   		     </td>		   </tr>
           </table>
           </form>		
	  </div>
   </div>
      <div class="searchbox-front-right">
      </div>
          

	
  </div>
  
</div>


<div class="breaker"></div>

<!--Body End-->{if $smarty.get.p eq 's'} 
{include file="syd_list.tpl" } 
{elseif $smarty.get.p eq 'n'} {include file="newc_list.tpl" } 
{elseif $smarty.get.p eq 'c'} {include file="can_list.tpl" } 
{elseif $smarty.get.p eq 'm'} {include file="mel_list.tpl" } 
{elseif $smarty.get.p eq 'all-brisbane'} {include file="bris_list.tpl" } 
{elseif $smarty.get.p eq 'gold-coast'} {include file="gold_list.tpl" } 
{elseif $smarty.get.p eq 'central-coast-region'} {include file="central_coast_list.tpl" }
{elseif $smarty.get.p eq 'all-darwin'} {include file="darwin_list.tpl" }
{elseif $smarty.get.p eq 'all-perth'} {include file="perth_list.tpl" }
{elseif $smarty.get.p eq 'all-adelaide'} {include file="adelaide_list.tpl" }
{elseif $smarty.get.p eq 'all-hobart'} {include file="hobart_list.tpl" }
{else} {include file="city_list.tpl" } {/if}
{* include file="news.tpl" *}

<div style="margin-top:10px;"></div>{include facebook_url="http://www.facebook.com/pages/Pink-Pages/260077437340993" file="social_networking_footer.tpl" }</div>
 <!-- <div class="news_links" >
 <table width="100%" align="center">
<tr>
<td  >
	<table width="663px" height="250" bgcolor="#2695d2"  class="news_links_text" >
     <tr bgcolor="#2695d2" >
    <td colspan="3" height="40px">
    <p>&nbsp;</p>
    </td>
    </tr>
    
    <tr bgcolor="#FFFFFF" >
    <td style="padding:6px;">
    <img src="{$IMAGES_PATH}one.jpg" align="right" /> <b>Brydens Law Office</b>
    <p>
At Brydens we're committed to making a real difference for our clients, and we'll work tirelessly to deliver to you the maximum results. So, if your life has been turned upside down by someone else's negligence or actions, then Brydens Compensation Lawyers are the people to talk to.
<a href="http://www.brydens.com.au/">www.brydens.com.au</a></p>
    </td>
    <td style="padding:6px;">
    <img src="{$IMAGES_PATH}three.jpg" align="right" /> <b>Heading would go here</b>
     <p>The Party Place
Specialising in deliveries of balloons and balloon arrangements, the Party Place also supplies a range of fun & creative decorations and novelties to help your party really go off with a bang!
<a href="http://www.partyplacesydney.com">www.partyplacesydney.com</a> </p>
    </td>
    <td style="padding:6px;">
    <img src="{$IMAGES_PATH}two.jpg" align="right" /> <b>Heading would go here</b>
     <p>My Back Office
Hassle Free Bookkeeping, BAS and Tax for  less than you are paying now. On-line Books &amp; BAS is easy and affordable with guaranteed outcomes provided by your personal dedicated bookkeeper. 
<a href="http://www.mybackofficeonline.net.au/">www.mybackofficeonline.net.au</a></p>
    </td>
    </tr>
    </table>
</td>
<td width="10px"></td>
<td>
<img src="{$IMAGES_PATH}bannerfront.jpg" alt="banner ad" width="300" height="250" />
</td>
</tr>
</table>
<br />
</div>  -->

	
	
	
	
<!--{if $bannerArray[0].banner_name neq ''}	
	<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
	{elseif $bannerArray[0].html_code neq ''}
	<div class="sitebanner">{$bannerArray[0].html_code}</div>

	{/if}-->
	
<script language="javascript1.5" src="{$JS_PATH}search.js" type="text/javascript" >
</script>

{literal}
<script type="text/javascript">
// hello
$(function () {
		$("#Search1").watermark("What?");
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



	