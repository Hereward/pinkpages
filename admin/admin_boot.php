<?php
include(SYSTEM_PATH."mainboot.php");
/*$arr = mysql_fetch_array(mysql_query("SELECT * FROM cms"));
var_dump($arr);*/
include(ADMIN_ABS_PATH."AdminPage.class.php");

$request = new Request(ADMIN_SITE_PATH);
$fr = isset($_GET['fr'])?$_GET['fr']:0;
$pagingSize = isset($_REQUEST['pagingSize'])?$_REQUEST['pagingSize']:DEFAULT_PAGING_SIZE;

$request->setAttribute("fr", $fr);
$request->setAttribute("pagingSize", $pagingSize);
$do = (isset($_GET['do']))?$_GET['do']:ADMIN_DEFAULT_CONTROL;
$action = (isset($_GET['action']))?$_GET['action']:ADMIN_DEFAULT_ACTION;

$ignoreSessionCheck = array(
                        "Admin"=>array("doLogin", "loggedOut", "login","registration","lostPassword","passwordSent")
                        );
?>