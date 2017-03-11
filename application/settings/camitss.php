<?php
    ob_start();
    if(!isset($_SESSION))@session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
    echo check_session();
?>