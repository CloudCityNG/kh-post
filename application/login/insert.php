<?php
    ob_start();
    if(!isset($_SESSION))session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
?>

<?php
  

    $name=$_POST['username'];
    if(getValue("SELECT COUNT(*) FROM tbl_users WHERE user_name = '" . $name. "'")){
        echo "1";
    }
    else{
	    $ps=$_POST['password'];
        $pass = md5($ps);
        runSQL("INSERT INTO tbl_users(user_name, user_profile_name, user_password, user_type_id) VALUES('$name', '$name', '$pass'," . CUSTOMER . ")");
        $_SESSION['_user_09_09_2011_id'] = mysql_insert_id();
        echo "/biznavi/";
    }

?>