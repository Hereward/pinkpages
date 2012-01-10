<?php
include("System/Config/config.php");
include("app_config.php");
include("app_boot.php");

//another comment
$businessFacade = new BusinessFacade($GLOBALS['conn']);
$businescontrol= new BusinessControl(new Request());
$result=$businessFacade->activate();
$businescontrol->activateUser();
?> 
