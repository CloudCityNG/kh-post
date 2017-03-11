<?php
    /*
    * open body tag inside the sub make it easy to call more script files or css individually to each page
    * and make it loads faster for other page which do not neccessary need the script files here
    */
    sub_head();


?>
    <link type="text/css" rel="stylesheet" href="application/login/login.css">
    <script type="text/javascript" src="application/login/check_login.js"></script>
<?php
    sub_head_end();
    sub_body_welcome();

    $home_page = $_SERVER['SERVER_NAME'] . $_SERVER["PHP_SELF"];
    $home_page = str_replace("index.php", "", $home_page);
    echo '<span style="display: none;" id="#home_page_url">' . $home_page . '</span>';
?>

<div style="width: 90%;border: none; top: 100px; left: 0;">
    <span class="login_tip"></span>
    <span class="_language" id="invalid_user" style="display: none;">Invalid Username or Password</span>
    <form action="application/login/checklogin.php" method="post">
    <table class="login"  border="0" align="center" style="float: right; margin: 50px auto;" height="30%" cellspacing="20">
     <tr>
      <td width="80">Username</td>
      <td> <input class="hover" type="text" id="txtuser_name" name="username" size="30%" autofocus="autofocus"/></td>
     </tr>
     <tr>
      <td>Password</td>
      <td><input class="hover" type="password" id="txtuser_password" name="password" size="30%"/></td>
     </tr>
     <tr>
      <td></td>
      <td align="right">
        <!-- <button class="active" type="submit" name="button" value="Login" onClick="return check()"/><p class="text"><font face="Tahoma" font-size:14px>Login</font></p></button> -->
        <div class="button" id="login_button" onclick="check_login()">Login</div>
      </td>
     </tr>
   </table>
 </form>
</div>


<?php
    sub_body_end();
?>