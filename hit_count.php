<?php
include("System/Config/config.php");
include("app_config.php");
include("app_boot.php");


$affiliatefacade = new AffiliateFacade($GLOBALS['conn']);
$affiliatecontrol= new AffiliateControl(new Request());
$result=$affiliatefacade->hit_count($_GET['banner_id'],$_GET['affiliate_id']);
$affiliatefacade->hit_count_banner($_GET['banner_id'],$_GET['affiliate_id']);
$affiliatefacade->affiliate_hit_count_banner($_GET['banner_id'],$_GET['affiliate_id']);
$affiliatefacade->affiliate_hit_count_banner_hourley($_GET['banner_id'],$_GET['affiliate_id']);
$affiliatefacade->hit_count_banner_hourley($_GET['banner_id'],$_GET['affiliate_id']);
$affiliatecontrol->displayHomePage();
?> 
