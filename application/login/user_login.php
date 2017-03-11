<?php
    ob_start();
    if(!isset($_SESSION))session_start();
    $user_name = $_GET['___u'];
    $pass      = md5($_GET['___p']);

    require_once($_SERVER["DOCUMENT_ROOT"] . "/biznavi/module/module.php");

    $result = getValue("SELECT user_id FROM tbl_users WHERE user_name = '$user_name' AND user_password='$pass'");

    if($result != ""){
        $_SESSION['_user_09_09_2011_id'] = $result;
        $result = 1;
    }
    else{
        $result = 0;
    }

    echo $result;

?>