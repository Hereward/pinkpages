<?php
include("../System/Config/config.php");
include("admin_config.php");          
include("admin_boot.php");          
// Check Session

// Check Session
if ( !isValidSession() ) {
    
    $do		=	ADMIN_DEFAULT_CONTROL;
    $action	=	ADMIN_DEFAULT_ACTION;
}
//echo $do, $action;
$do = $do."Control";
$obj = new $do($request);
$obj->$action();
?>