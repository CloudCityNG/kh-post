<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();


    //config preset function and configuration
    require_once("module/module.php");

    $page = "";
    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
        if(!array_key_exists($page, $path)){
            $page = "index";
        }
    }
    else $page = "index";


    if(getCurrentUser() == 0 && $page != "signup"){
        $page= "welcome";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    index_head();
?>
    <title>BizNavi</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8; charset=iso-8859-1" />
    <!-- default style -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/template.css">
    <link rel="stylesheet" type="text/css" href="css/menu_head_footer.css">
    <!-- default style -->


    <!-- jquery -->
    <script type="text/javascript" src="js/jquery-1.6.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="js/events.js"></script>

    <script type="text/javascript" src="js/jquery.ba-hashchange.js"></script>


    <link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css">
    <!-- jquery -->

    <!-- language changing -->
    <script type="text/javascript" src="application/language/js/jquery.language.js"></script>
    <link rel="stylesheet" type="text/css" href="application/language/css/language.css">
    <!-- language changing -->

    <!-- js module -->
    <script type="text/javascript" src="js/module.js"></script>
    <script type="text/javascript" src="admin/js/admin.js"></script>
    <script type="text/javascript" src="application/user/js/user.js"></script>
    <script type="text/javascript" src="js/active_menu_tag.js"></script>
    <!-- js module -->


    <!-- date pick: http://keith-wood.name/datepick.html -->
    <script type="text/javascript" src="application/_jquery.datepick/jquery.datepick.js"></script>
    <script type="text/javascript" src="application/_jquery.datepick/jquery.datepick.lang.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="application/_jquery.datepick/redmond.datepick.css">
    <!-- date pick -->

    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            load_home();
            $("table#menu_tab").LoadLanguage({
                language: current_language
            });
        });
    </script>


<?php
    index_head_end();

    $include_path = $path[$page];
    include($include_path);
?>


</html>
