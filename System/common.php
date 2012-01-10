<?php
function pre($val) {
    echo "<pre>";
    var_dump($val);
    echo "</pre>";
}

function prexit($val) {
    pre($val);exit;
}

function myErrHandle($data) {
    pre($data);
}
?>