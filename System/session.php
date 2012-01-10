<?php
function isValidSession() {
    global $do, $action, $ignoreSessionCheck;
    if(isset($_SESSION[NAMESPACE]['userid'])) {
        return true;
    }
    elseif(isset($ignoreSessionCheck[$do]) && is_array($ignoreSessionCheck[$do])) {
        if(in_array($action, $ignoreSessionCheck[$do])) {
            return true;
        }
    }
    return false;
}

function getSession($key) {
    if(isset($_SESSION[NAMESPACE][$key])) {
        return $_SESSION[NAMESPACE][$key];
    }
    return "";
}

function setSession($key, $val) {
    $_SESSION[NAMESPACE][$key] = $val;
}

function unset_session() {
    unset($_SESSION[NAMESPACE]);
}
?>