<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<Meta name="description" content="{$meta_description}">
<meta name="keywords" content="{$meta_keywords}">
<title>{$page_title}</title>
{$css_files}
{$js_files}
 <script>
     var $j = jQuery.noConflict();
     

	 </script>
</head>
<body>
<div class="container">
<div class="header-index">    
   <h1><a href="{$home_url}"><img src="{$IMAGES_PATH}logo1.gif" alt="Pinkpages Admin" border="0" /></a></h1>
</div>
<div align="right">{if ($do eq 'Admin' && $action1 eq 'login')||($do eq 'Admin' && $action1 eq 'loggedOut')||($do eq 'Admin' && $action1 eq 'doLogin')||($do eq 'Admin' && $act eq 'activateUser')}
   {else}
 {if getSession("username") neq ''}<font size="-1" class="er-message-display"> User {php}echo "<b>".ucfirst(getSession("username"))."</b>";{/php} currently logged in with {php}echo "<b>".getSession("localuser_access")."</b>";{/php} permission.</font>{/if}
{/if}
 </div>
    
 