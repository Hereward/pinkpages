<?php
include("../System/Config/config.php");
include("admin_config.php");
include("admin_boot.php");

//another comment
$adminFacade = new AdminFacade($GLOBALS['conn']);
$admincontrol= new AdminControl(new Request());
$result=$adminFacade->activate();
$admincontrol->activateUser();
?> 
