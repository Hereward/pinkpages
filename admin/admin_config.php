<?php
define("ADMIN_ABS_PATH", APP_ROOT_ABS_PATH."admin/");
define("ADMIN_SITE_PATH", SITE_PATH."admin/");
define("ADMIN_JS_PATH", ADMIN_SITE_PATH."Js/");
define("JS_PATH", SITE_PATH."View/Default/Js/");
//define("SYSTEM_PATH", APP_ROOT_ABS_PATH."System/");

define("LOGO_PATH", SITE_PATH."View/Default/Images/");
define("ADMIN_VIEW_PATH", ADMIN_ABS_PATH."View/");
define("ADMIN_IMAGES_PATH", ADMIN_SITE_PATH."View/Default/Images/");
define("CLIENT_IMAGES_PATH", ADMIN_SITE_PATH."View/Default/Images/client_image/");
define("ADMIN_CSS_PATH", ADMIN_SITE_PATH."View/Default/Style/");

define("BANNER_UPLOAD_PATH", APP_ROOT_ABS_PATH."Templates/Uploads/banner/");
define("BANNER_PATH", SITE_PATH."Templates/Uploads/banner/");
/* PATHS SETTINGS */

/* APP SETTINGS */
define("ADMIN_APP_PATH", ADMIN_ABS_PATH."app/");
define("ADMIN_APP_CONTROL", ADMIN_APP_PATH."Control/");
define("ADMIN_APP_FACADE", ADMIN_APP_PATH."Facade/");
/* APP SETTINGS */

/* OTHER SETTINGS */
define("REWRITE_URL", 0);
define("DEFAULT_PAGING_SIZE", 10);
define("CONTROLLER", "main.php");

define("ADMIN_DEFAULT_CONTROL", "Admin");
define("ADMIN_DEFAULT_ACTION", "login");

define("ADMIN_DEFAULT_CONTROL_VS", "Admin");
define("ADMIN_DEFAULT_ACTION_VS", "showhomePageAdmin");

define("USERNAMESPACE", "admin_namespace");
/* OTHER SETTINGS */
?>