<?php
include("../System/Config/config.php");
include("admin_config.php");
include("admin_boot.php");

if ( getSession("userid") ) {
    $do = ADMIN_DEFAULT_CONTROL_VS;
    $action = ADMIN_DEFAULT_ACTION_VS;
}
else {
    $do = ADMIN_DEFAULT_CONTROL;
    $action = ADMIN_DEFAULT_ACTION;
}
$do .= "Control";
$obj = new $do($request);
$obj->$action();

?>