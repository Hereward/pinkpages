<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>

<link rel="shortcut icon" href="http://www.pinkpages.com.au/View/Default/Images/favicon.ico"  /> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="{$meta_description}" />

{if $meta_keywords}<meta name="keywords" content="{$meta_keywords}" />{/if}  
{if $meta_tags}{foreach from=$meta_tags key=name item=content}<meta name="{$name}" content="{$content}" />{/foreach}
{/if}
{if $canonical}{$canonical}
{/if}
<title>{$page_title}</title>
{foreach from=$css_files item=css}
    {$css}
{/foreach}
{foreach from=$js_files item=js}
    {$js}
{/foreach}
	<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3756460-3");
pageTracker._trackPageview();
</script>



</head>

<body>
	<div class="container">
<div class="header-index">    
   	<h1>
   		<a href="{$SITE_PATH}"><img  src="{$IMAGES_PATH}logo1.gif" alt="SydneyPinkpages" /></a>
	</h1>   
  <table class="tabsNav" height="65px" width="100%">
  <tr>
  <td style="border-color:#c3cde2; border-style:solid; border-width:0 2px 0 0; ">
 &nbsp;&nbsp;&nbsp;&nbsp; <a href="/main.php?do=Index&action=home" rel="tcontent1" {if ($do eq 'Listing' AND $action eq 'search'  AND $smarty.get.t neq 'tab' AND $smarty.get.SearchOption neq 1)||  ($do eq 'Listing' AND $action eq 'categorySearch')||($do eq 'Listing' AND $action eq 'searchKeyword')||($do eq 'Listing' AND $action eq 'getSuburbResult')} class="active" {/if}>Keyword Search</a>
  </td>
  <td style="border-color:#c3cde2; border-style:solid; border-width:0 2px 0 0; ">
 <a href="/main.php?do=Listing&action=searchStreetForm" rel="tcontent2" {if $smarty.get.action eq 'searchStreet' || $smarty.get.action eq 'searchStreetBusiness'} class="active" {/if} >Street Search</a>
  </td>
  <td style="border-color:#c3cde2; border-style:solid; border-width:0 2px 0 0; ">
 <a href="/main.php?do=Listing&action=businessNameSearch" {if ($smarty.get.do eq 'Listing' AND $smarty.get.action eq 'search' AND $smarty.get.t eq 'tab') ||  ($do eq 'Listing' AND $action eq 'mapSearchResult') || ($do eq 'Listing' AND $action eq 'googleMapView') || $smarty.get.SearchOption eq 1} class="active" {/if} >Business Search</a>
  </td>
  <td >
 <a href="{$SITE_PATH}main.php?do=Content&action=contactUs" {if $smarty.get.action eq 'contactUs'} class="active" {/if}>Contact</a>
  </td>
  </tr>
  </table>
 
  </div>

<!--header end-->