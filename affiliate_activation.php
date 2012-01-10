<?php
include("System/Config/config.php");
include("app_config.php");
include("app_boot.php");

//another comment
$affiliatefacade = new AffiliateFacade($GLOBALS['conn']);
$affiliatecontrol= new AffiliateControl(new Request());
$result=$affiliatefacade->activate();
$affiliatecontrol->activateUser();
?> 
