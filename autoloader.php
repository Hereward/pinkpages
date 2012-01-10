<?php

/**
 *  autoloader
 *
 *  Replacement for __autoload
 *
 *  @param      string      class   name of the class we want to load
 *  @return     bool                True/False
 */
function autoloader($class) {
    
    $classPaths = array(
                        APP_CONTROL_PATH,
                        APP_FACADE_PATH,
                        UTILS_PATH,
                        SHARED_FACADE_PATH,
                        THIRD_PARTY_LIB
                        );
    foreach ($classPaths as $path) {
        if ( file_exists($path . $class . ".class.php") ) {
            if (include_once($path .$class . ".class.php")) {
                return true;
            }
        }
    }
    // debug: class file does not exist
    global $request;
    $indexControl = new IndexControl($request);
    $indexControl->PageNotFound();
    exit();
}/* End autoloader */

/* Register the autoloader function as a replacement for __autoload */
spl_autoload_register("autoloader");
?>