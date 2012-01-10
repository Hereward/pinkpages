<?php

include(SYSTEM_PATH."mainboot.php");
include(APP_ROOT_ABS_PATH."MainPage.class.php");

$request = new Request();
$fr = isset($_GET['fr'])?$_GET['fr']:0;
$pagingSize = isset($_REQUEST['pg_size'])?$_REQUEST['pg_size']:DEFAULT_PAGING_SIZE;

$request->setAttribute("fr", $fr);
$request->setAttribute("pg_size", $pagingSize);
$do = (isset($_REQUEST['do']))?$_REQUEST['do']:DEFAULT_CONTROL;
$action = (isset($_REQUEST['action']))?$_REQUEST['action']:DEFAULT_ACTION;

/* Session Check ignored for these actions */
$ignoreSessionCheck = array(
                        "Business"=>array("login","doLogin","registrationAdd", "loggedOut","busaddition","showhomePage","lostPassword","lostpasswordgain"),
						"Listing"=>array("Search"),
						"Classification"=>array("loadAjax")
                        );
						
?>