<?php
//include('../../config/config.php');
include('../../module/module.php');
?>
<?php
  
  $name=$_POST['username'];
  $passwd=$_POST['password'];
  
  
  
  
  if(getValue("SELECT user_name user_password FROM tbl_users WHERE user_name = '" . $name . "' and user_password='".$passwd."'")){	       
    echo 'Login successful.........................!';	
    }
else{
    echo "!Invalid username and password";
    }
  
?>
