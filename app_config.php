<?php

/* Local application setting constants */

define("VIEW_PATH", APP_ROOT_ABS_PATH."View/");
define("ADMIN_SITE_PATH", SITE_PATH."admin/");
define("UPLOADS_PATH", APP_ROOT_ABS_PATH."Uploads/");
define("IMAGES_PATH", SITE_PATH."View/Default/Images/");
define("BANNER_PATH", SITE_PATH."Templates/Uploads/banner/");
define("CSS_PATH", SITE_PATH."View/Default/Style/");
define("JS_PATH", SITE_PATH."View/Default/Js/");
define("ADMIN_EMAIL_ADDR", "gcattley@dawsonmedia.com.au");
define("CLIENT_IMAGES_PATH", ADMIN_SITE_PATH."View/Default/Images/client_image/");

/* OTHER SETTINGS */
define("REWRITE_URL", 1);
define("DEFAULT_PAGING_SIZE", 20);
define("DEFAULT_RANK_LIMIT", 5);
define("CONTROLLER", "main.php");

define("DEFAULT_CONTROL", "Index");
define("DEFAULT_ACTION", "home");
/* OTHER SETTINGS */

define("DEFAULT_CONTROL_VS", "Index");//VS-Varified session
define("DEFAULT_ACTION_VS", "home");//VS-Varified session

/* APP SETTINGS */
define("APP_PATH", APP_ROOT_ABS_PATH."app/");
define("APP_CONTROL_PATH", APP_PATH."Control/");
define("APP_FACADE_PATH", APP_PATH."Facade/");
define("USERNAMESPACE", "user_namespace");
/* APP SETTINGS */
?>