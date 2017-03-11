<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "module/module.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "application/like/class/like.class.php");

    $action = $_GET['action'];
    if($action == "display"){
        $like_display = new like;
        $like_display->show_like_box();
    }

?>