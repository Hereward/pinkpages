<?php
include("System/Config/config.php");
include("app_config.php");
include("app_boot.php");
dev_log::cur_url();

// Check Session
/*if ( !isValidSession() ) {

    $do		= DEFAULT_CONTROL;
    $action	= DEFAULT_ACTION;
}*/

$do = $do."Control";
$obj = new $do($request);
$obj->$action();
?>