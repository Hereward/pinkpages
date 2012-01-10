<?php
		/**
		* @desc This file is used for increasing the count of vies and clicks and to display the banner that has been copied by the affiliate user.
		*/	
		
include("System/Config/config.php");
include("app_config.php");
include("app_boot.php");

$affiliatefacade 	= new AffiliateFacade($GLOBALS['conn']);
$affiliatecontrol	= new AffiliateControl(new Request());


$affiliatefacade->view_count_banner($_GET['banner_id'],$_GET['affiliate_id']);

$affiliatefacade->affiliate_view_count_banner($_GET['banner_id'],$_GET['affiliate_id']);

$affiliatefacade->view_count_banner_hourley($_GET['banner_id'],$_GET['affiliate_id']);

$affiliatefacade->affiliate_view_count_banner_hourley($_GET['banner_id'],$_GET['affiliate_id']);

$result=$affiliatefacade->show_banner($_GET['banner_id'],$_GET['affiliate_id']);

$path 				= BANNER_PATH.$result[0]['banner_name'];
$encBannerId=base64_encode($_GET['banner_id']);
$banner_hit	=SITE_PATH."hit_count.php?banner_id={$encBannerId}&affiliate_id={$_GET['affiliate_id']}";

echo "document.write('<a href=\"$banner_hit\" style=\"text-decoration:none\"><img src=\"".$path."\"></a>')";


?> 
