<?php
    ob_start();
    if(!isset($_SESSION))@session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
    $user_id = getCurrentUser();
    $user_type = getUserType();
    if($user_type == ADMINISTRATOR){
        include($_SERVER['DOCUMENT_ROOT'] . "/biznavi/admin/admin.php");
        echo '
            <script type="text/javascript">
                init_admin();
            </script>
        ';
    }
    else{
        include($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/user/class/user.class.php");
        $user = new user($user_id);
?>
        <script type="text/javascript">
          init_profile();
        </script>
        <link rel="stylesheet" type="text/css" href="application/user/css/user.css" />
        <div id="user_profile">
<?php
        $user->show_profile();
    }
?>
        </div>

        <div id="user_account"></div>