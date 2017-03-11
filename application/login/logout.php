<?php
    ob_start();
    if(!isset($_SESSION))session_start();

    unset($_SESSION['_user_09_09_2011_id']);
    $home_page = $_SERVER['SERVER_NAME'];
    $home_page = $home_page . "/biznavi/";
    header("location:http://" . $home_page);
?>