<link rel="stylesheet" type="text/css" href="admin/css/admin.css" />
<link rel="stylesheet" type="text/css" href="application/_datatable/css/demo_table.css" />
<script type="text/javascript" src="admin/js/admin.js"></script>
<script type="text/javascript" src="application/_datatable/js/jquery.dataTables.js"></script>

<div class="admin_content" style="height: 100px; margin-top: 0;">
    <div class="head">
        User List
        <div style="float: right;" onclick="show_add_user();" class="icon add"></div>
    </div>

    <div class="user_table_wrapper">
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/user/class/user.class.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
    $user_rs = getResultSet("SELECT user_id FROM tbl_users WHERE user_id <> 1");
?>
    <table class="lst_user" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th><span class="_language">User</span></th>
                <th><span class="_language">Company</span></th>
                <th><span class="_language">Email</span></th>
                <th><span class="_language">User Type</span></th>
                <th width=70><span class="_language">Action</span></th>
            </tr>
        </thead>
        <tbody>
<?php
        while($r = mysql_fetch_array($user_rs)){
            $u = new user($r[0]);
            $u->row();
        }
?>
        </tbody>
    </table>

    </div>

    <div style="display: none;" id="admin_msg">
        <span id="confirm_delete_user" class="_language">Are you sure want to delete this?</span>
        <span id="confirm_invalid_username" class="_language">Invalid username</span>
        <span id="user_name_exist" class="_language">Username already registered</span>
        <span id="confirm_invalid_password" class="_language">Invalid password</span>
        <span id="confirm_password_not_match" class="_language">Password not match</span>
        <span id="new_user_title" class="_language">New User</span>
        <span id="edit_user_title" class="_language">Edit User</span>

        <center><div id="popup_1" style="width: 400px;"></div></center>
    </div>
</div>