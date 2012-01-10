<?php
/* put settings & include those files which are required on each pages of application */
include("autoloader.php");
include(SYSTEM_PATH."DBTables.php");
include(SYSTEM_PATH."session.php");
include(SYSTEM_PATH."common.php");
include(FACADE_PATH."MainFacade.class.php");
include(CONTROL_PATH."MainControl.class.php");
require_once 'MDB/QueryTool.php';
$GLOBALS['conn'] = new MyDB(DSN, array('errorCallback'=>'myErrHandle'), 2);
?>