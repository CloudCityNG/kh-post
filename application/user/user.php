<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/user/class/user.class.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");

    $cmd = $_GET['cmd'];

    if($cmd == "list"){
        //display_all_user();
    }  //list

    else if($cmd == "admin_edit"){// edit from administrator
        $user_id = $_GET['id'];
        if(isset($_GET['savv'])){
            $user_type = $_GET['type'];
            $enable = $_GET['enable'];
            $user = new user($user_id);
            if($enable == "1")$user->enable();
            else $user->disable();

            runSQL("UPDATE tbl_users SET user_type_id = " . $user_type . " WHERE user_id = " . $user_id);
            //display_all_user();
            echo getValue("SELECT user_type_name FROM tbl_user_type WHERE user_type_id = " . $user_type);
        }
        else{
            $user = new user($user_id);
            $user->form_edit();
        }
    } //save edit

    else if($cmd == "updatepic"){
        $user_id = $_GET['id'];
        $file_path = "../../user_files/user_profile/" . $user_id . "/";

        $result=upload( "user_profile_picture",$file_path);
        $tem=explode(";",$result);
        $result=$tem[0];
        $target_path=$tem[1];

        //delete old picture
        $old_pic = getValue("SELECT user_picture FROM tbl_users WHERE user_id = " . $user_id);
        if($result=="0"){
            $target_path = substr($target_path,3,strlen($target_path));
            $target_path = str_replace("../", "", $target_path);
            $target_path = str_replace("//", "/", $target_path);
            $sql="UPDATE tbl_users SET user_picture = '" . $target_path . "' WHERE user_id = " . $user_id;
            runSQL($sql);
            ?>
            <script language="javascript">
                window.top.window.finish_save_profile_picture("<?php echo $target_path; ?>");
            </script>
            <?php
        }
    }

    else if($cmd == "update"){//user themselve updated information
        $user_id = $_GET['id'];

        $profile_name = $_POST['pn'];
        $address = $_POST['ad'];
        $company = $_POST['comp'];
        $email = $_POST['em'];

        if($email != "" && getValue("SELECT COUNT(*) FROM tbl_users WHERE user_email = '" . $email . "' AND user_id <>" . $user_id) != 0){
            echo "1";
        }
        else{
            runSQL("UPDATE tbl_users SET
                user_profile_name = '" . $profile_name . "',
                user_address = '" . $address . "',
                user_email = '" . $email . "',
                user_company = '" . $company . "'
                WHERE user_id = " . $user_id . "
                ");
                echo "0";
        }

    }

    else if($cmd == "checkexist"){
        //called in signup
        $value = $_GET['val'];
        $sql = "SELECT user_id FROM tbl_users WHERE user_name= '" . $value . "'";

        if(getValue($sql) != ""){
            echo "true";
        }
        else echo "false";

    }

    else if($cmd == "edit_form"){
        $user_id = $_GET['id'];
        $user = new user($user_id);
        $user->editForm();
    }// show edit form

    else if($cmd == "delete"){
        $user_id = $_GET['id'];
        runSQL("DELETE FROM tbl_users WHERE user_id = " . $user_id);
        //display_all_user();
    }

    else if($cmd == "add_user"){
        if(isset($_GET['save'])){
            $un = $_GET['___un'];
            $ps = md5($_GET['___ps']);
            $t  = $_GET['___t'];

            if(getValue("SELECT COUNT(*) FROM tbl_users WHERE user_name = '" . $un . "'") != 0){
                echo "1";
            }
            else{
                require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
                runSQL("INSERT INTO tbl_users(user_name, user_profile_name , user_password, user_type_id) VALUES('$un', '$un', '$ps', $t)");
                display_all_row();
            }
        }
        else{
            if(getUserType() == ADMINISTRATOR){
                $user = new user(0);
                $user->add_user();
            }
        }
    }

    else if($cmd == "profile"){
        $user = new user($_GET['id']);
        $user->show_profile();
    }

    else if($cmd == "edit_account"){
        $user = new user($_GET['id']);

        $user->show_edit_account();
    }

    else if($cmd == "save_account"){
        $id = $_POST['id'];
        $un = $_POST['un'];
        $ps = md5($_POST['ps']);
        $np = md5($_POST['new_ps']);

        $user = new user($id);
        if($user->getPassword() != $ps){
            echo "1";//1 for invalid password
        }
        else if(getValue("SELECT COUNT(*) FROM tbl_users WHERE user_name = '" . $un . "' AND user_id <>" . $id) != 0){
            echo "2";
        }
        else{
            runSQL("UPDATE tbl_users SET user_name = '$un', user_password = '$np' WHERE user_id = $id");
        }
    }


    function display_all_row(){
        $user_rs = getResultSet("SELECT user_id FROM tbl_users WHERE user_id <> 1");
        echo '
        <table class="lst_user" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th><span class="_language">User</span></th>
                <th><span class="_language">Company</span></th>
                <th><span class="_language">Email</span></th>
                <th><span class="_language">User Type</span></th>
                <th><span class="_language">Action</span></th>
            </tr>
        </thead>
        <tbody>
        ';
        while($user_info = mysql_fetch_array($user_rs)){
            $user = new user($user_info[0]);
            $user->row();
        }
        echo '</tbody></table>';
    }//function display all user
?>