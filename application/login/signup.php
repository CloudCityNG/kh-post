<?php
    /*
    * open body tag inside the sub make it easy to call more script files or css individually to each page
    * and make it loads faster for other page which do not neccessary need the script files here
    */
    sub_head();


?>
    <link type="text/css" rel="stylesheet" href="application/login/login.css">
    <script type="text/javascript" src="application/login/js/check.js"></script>
<?php
    sub_head_end();
    sub_body_welcome();

    $home_page = $_SERVER['SERVER_NAME'] . $_SERVER["PHP_SELF"];
    $home_page = str_replace("index.php", "", $home_page);
    echo '<span style="display: none;" id="#home_page_url">' . $home_page . '</span>';
?>

<div style="width: 90%;border: none;">
    <span class="login_tip"></span>
    <span class="_language" id="invalid_user" style="display: none;">Invalid Username or Password</span>
    <form action="application/login/checklogin.php" method="post" id="form_signup">
    <table class="login"  border="0" align="center" style="float: right; margin: 50px auto;" height="30%" cellspacing="20">
     <tr>
        <td></td>
        <td style="height: 20px;">
            <span class="tip_text" id="signup_result"></span>
        </td>
     </tr>
     <tr>
      <td width="150">Username</td>
      <td> <input class="hover" type="text" id="txtuser_name" name="username" size="30%"/></td>
     </tr>
     <tr>
      <td>Password</td>
      <td><input class="hover" type="password" id="txtuser_password" name="password" size="30%"/></td>
     </tr>
     <tr>
      <td>Confirm Password</td>
      <td><input class="hover" type="password" id="txtuser_con_password" name="password" size="30%"/></td>
     </tr>
     <tr>
      <td></td>
      <td align="right">
        <!-- <button class="active" type="submit" name="button" value="Login" onClick="return check()"/><p class="text"><font face="Tahoma" font-size:14px>Login</font></p></button> -->
        <div class="button" id="login_button" onclick="check_singup()">Signup</div>
      </td>
     </tr>
   </table>
 </form>
</div>


<?php
    sub_body_end();
?>