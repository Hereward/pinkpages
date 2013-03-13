<?php
//test comment
// another test comment (git dev branch)
// another test comment (git dev branch - 2nd test!)
include("System/Config/config.php");
dev_log::write("index.php"); 
include("app_config.php");
include("app_boot.php");



if ( isValidSession() ) {
	$do = DEFAULT_CONTROL_VS;
	$action = DEFAULT_ACTION_VS;

}
elseif(isset($_GET['page']) && $_GET['page']!='')
{
$do='Content';
$action='viewPage';
}
else 
{
	$do = DEFAULT_CONTROL;
	$action = DEFAULT_ACTION;
}



$do .= "Control";
dev_log::write("Index [$do] [$action]");
$obj = new $do($request);
$obj->$action();
?>
