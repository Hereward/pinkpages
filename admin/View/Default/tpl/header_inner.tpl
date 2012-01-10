<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<Meta name="description" content="{$meta_description}">
<meta name="keywords" content="{$meta_keywords}">

<title>{$page_title}</title>
{$js_files}
{$css_files}

</head>

<body>
<div class="container">
<div class="header">
    
   <h1><img class="png" src="{$IMAGES_PATH}logo1.gif" alt="Sydneypinkpages" /></h1>
   <div class="tabTop-inner">
  
     <ul id="tabsNav">
       	  <li><a href="main.php?do=Listing&action=mapSearch" {if $action eq 'mapSearchResult '} class="active"{else} class="inactive"{/if} ><span>Map Search</span></a></li>
       	  <li><a href="main.php?do=Index&action=home" {if $action eq 'mapSearchResult '} class="inactive"{else} class="active"{/if}><span>Simple Search</span></a></li>
       	  </ul>
    </div>
   
  </div>