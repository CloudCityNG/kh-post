<?php
    ob_start();
    if(!isset($_SESSION))session_start();
    //this class is used to manipulate user for administrator
    class user{
        private $id;
        private $name;

        public function __construct($id){
            $this->id = $id;
        }

        private function init_db(){
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        }

        public function getEnable(){
            $this->init_db();
            return getValue("SELECT enable FROM tbl_users WHERE user_id = " . $this->id);
        }

        public function enable(){
            $this->init_db();
            runSQL("UPDATE tbl_users SET enable = 1 WHERE user_id = " . $this->id);
        }//enable user

        public function disable(){
            $this->init_db();
            runSQL("UPDATE tbl_users SET enable = 0 WHERE user_id = " . $this->id);
        }//disable user

        //get user id
        public function getId(){return $this->id;}

        //set user id
        public function setId($id){$this->id = $id;}

        //getAddress
        public function getAddress(){
            $this->init_db();
            return getValue("SELECT user_address FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get profile name
        public function getProfileName(){
            $this->init_db();
            return getValue("SELECT user_profile_name FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get user name
        public function getUserName(){
            $this->init_db();
            return getValue("SELECT user_name FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get company
        public function getCompanyName(){
            $this->init_db();
            return getValue("SELECT user_company FROM tbl_users WHERE user_id = " . $this->id);
        }

        public function getPassword(){
            $this->init_db();
            if(getCurrentUser() != $this->id)return "Don't hack.";
            else
                return getValue("SELECT user_password FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get user type id
        public function getUserTypeId(){
            $this->init_db();
            return getValue("SELECT user_type_id FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get user type text
        public function getUserTypeName(){
            $this->init_db();
            return getValue("SELECT user_type_name FROM tbl_user_type WHERE user_type_id = " . $this->getUserTypeId());
        }

        //get email
        public function getEmail(){
            $this->init_db();
            return getValue("SELECT user_email FROM tbl_users WHERE user_id = " . $this->id);
        }

        //get profile picture
        public function getProfilePicture(){
            $this->init_db();
            return getValue("SELECT user_picture FROM tbl_users WHERE user_id = " . $this->id);
        }

        //save profile picture


        //save profile name
        public function saveProfileName($value){
            $this->init_db();
            runSQL("UPDATE tbl_users SET user_profile_name = '" . $value . "' WHERE user_id = " . $this->id);
        }

        //save user name
        public function saveUsername($value){
            $this->init_db();
            if(getValue("SELECT COUNT(*) FROM tbl_users WHERE user_name = '" . $value . "'") != 0){
                echo "Username exist. Please choose another one.";
            }
            else{
                runSQL("UPDATE tbl_users SET user_name = '" . $value . "' WHERE user_id = " . $this->id);
            }
        }

        //save Email
        public function saveEmail($value){
            $this->init_db();
            if(getValue("SELECT COUNT(*) FROM tbl_users WHERE user_email = '" . $value . "'") != 0){
                echo "Email has registered. Please choose another one.";
            }
            else{
                runSQL("UPDATE tbl_users SET user_email = '" . $value . "' WHERE user_id = " . $this->id);
            }
        }

        //save address
        public function saveAdress($value){
            $this->init_db();
            runSQL("UPDATE tbl_users SET user_address = '" . $value . "' WHERE user_id = " . $this->id);
        }

        public function row(){
            $name = $this->getProfileName();
            if($name == ""){
                $name = $this->getUserName();
            }
            echo '
                <tr>
                    <td>' . $name . '</td>
                    <td>' . $this->getCompanyName() . '
                    <td>' . $this->getEmail() . '</td>
                    <td>
                        <div class="_language" style="display: block; width: 70px;">' . $this->getUserTypeName() . '</td>
                    <td>
                        <div style="display: block; width: 70px;">
                        <span id="' . $this->id . '"></span>
                        <span class="" onclick="admin_show_edit_user(' . $this->id . ');"><div class="icon edit" style="margin-right: 10px;"></div></span><!-- Edit -->
                        <span class=""><div class="icon delete"></div></span><!-- Delete -->
                        </div>
                    </td>
                </tr>
            ';
        }//row

    public function form_edit(){
        $this->init_db();
        $select_type = '<select id="edit_user_type" style="width: 100%;">';

        $select_rs = getResultSet("SELECT user_type_id, user_type_name FROM tbl_user_type");
        $user_id = 0;


        while($select = mysql_fetch_array($select_rs)){
            $user_id = $select[0];
            $select_type .= '<option class="_language" value="' . $select[0] . '" ';
            if(strcmp($select[0], $this->getUserTypeId()) == 0) $select_type .= " selected='selected' ";
            $select_type .= '>' . $select[1] . '</option>';
        }

        $select_type .= '</select>';
        $enable = "";
        if($this->getEnable() == "1") $enable = " checked ";
        $name = $this->getProfileName();
        if($name == ""){
            $name = $this->getUserName();
        }

        echo '
                <div style="width: 300px; padding-top: 15px; padding-bottom: 40px; font-size: 13px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 100px;">
                               <span class="_language">Profile Name</span>
                            </td>
                            <td>
                                <span style="color: #758DAE">' . $this->getProfileName() . '</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="_language">Username</span>
                            </td>
                            <td>
                                <span style="color: #758DAE">' . $this->getUserName() . '</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="_language">Company</span>
                            </td>
                            <td>
                                <span style="color: #758DAE">' . $this->getCompanyName() . '</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="_language">User Type</span>
                            </td>
                            <td>
                                <span style="color: #758DAE">
                                    ' . $select_type . '
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="_language">
                                <span class="_language"></span>Enable
                            </td>
                            <td>
                                <input type="checkbox" id="user_enable" name="user_enable" value="true" ' . $enable . '>
                            </td>
                        </tr>
                    </table>
                    <div style="background: #ffffff;">
                        <div class="button bClose _language" style="float: right;">Cancel</div>
                        <div class="button _language" style="float: right;" onclick="save_user(' . $this->id . ')">Save</div>
                    </div>
                </div>
        ';
        }//form edit


        public function add_user(){
            $this->init_db();

            $select_type = '<select id="add_user_type" style="width: 100%;">';

            $select_rs = getResultSet("SELECT user_type_id, user_type_name FROM tbl_user_type");
            $user_id = 0;

            while($select = mysql_fetch_array($select_rs)){
                $user_id = $select[0];
                $select_type .= '<option class="_language"x value="' . $select[0] . '" ';
                if(strcmp($select[0], $this->getUserTypeId()) == 0) $select_type .= " selected='selected' ";
                $select_type .= '>' . $select[1] . '</option>';
            }

            $select_type .= '</select>';
            $enable = "";
            if($this->getEnable() == "1") $enable = " checked ";

            echo '
                    <div style="width: 300px; padding-top: 20px; padding-bottom: 40px; font-size: 13px;">
                          <table>
    							<tr>
    								<td style="width: 150px;">
    									<span class="_language">New User</span>
    								</td>
    								<td>
    									<input type="text" id="txt_new_user" style="width: 130px;"/>
    								</td>
    							</tr>

    							<tr>
    								<td>
    									<span class="_language">Password</span>
    								</td>
    								<td>
    									<input type="password" id="txt_new_password" style="width: 130px;" />
    								</td>
    							</tr>
    							<tr>
    								<td>
    									<span class="_language">Confirm Password</span>
    								</td>
    								<td>
    									<input type="password" id="txt_new_confirm_password" style="width: 130px;" />
    								</td>
    							</tr>

                                <tr>
    								<td>
    									<span class="_language">User Type</span>
    								</td>
    								<td>
    										<span style="color: #758DAE">
    											' . $select_type . '
    										</span>
                                	</td>
    						    </tr>
                        </table>
                        <div style="background: #ffffff;">
                        <div class="button bClose _language" style="float: right;">Cancel</div>
                        <div class="button _language" style="float: right;" onclick="save_new_user()">Save</div>
                    </div>
                 </div>
            ';
        } //add user from admin page


        //form display profile
        public function show_profile(){
            if(getCurrentUser() == $this->id) $editable = true;
            else $editable = false;
            $edit_info_btn = '';
            $form_upload_pic = '';

            if($editable){
                $edit_info_btn = '<div class="icon edit" style="float: right;" onclick="show_edit_profile(' . $this->id . ');"></div>';
                $form_upload_pic = '
                    <form id="form_upoad_picture" method="post" enctype="multipart/form-data" target="here" action="application/user/user.php?cmd=updatepic&id=' . $this->id . '">
                        <input type="hidden" value="2000000" name="MAX_FILE_SIZE" />
                        <input type="file" class="fakefile" size=1 style="float: left;" id="user_profile_picture" name="user_profile_picture"/>
                        <input type="hidden" id="user_id" value="' . $this->id . '" />
                    </form>
                    <iframe id="here" name="here" style="display: none;"></iframe>
                ';
            }

            echo '
                <div class="user_detail">
                    <div style="display: none;">
                        <span id="password_not_match" class="_language">Password not match</span>
                        <span id="invalid_password" class="_language">Invalid password</span>
                        <span id="username_exist" class="_language">Username already registered</span>
                    </div>
                    <div class="head">
                    <span class="_language">Account Information</span>
                    ' . $edit_info_btn . '
                    <span class="message _language" style="display: none;">Email already registered</span>
                    </div>

                    <table class="info" cellspacing=0 cellpadding=5>
                        <tr>
                            <td id="image_part" width=150 valign="top">
                                <img id="profile_image" src="' . $this->getProfilePicture() . '" />

                            </td>
                            <td id="detail_part">
                                <table class="detail_info"  cellspacing=0 cellpadding=5>
                                    <tr valign="top"><td colspan=2 align="left" class="profile">' . $this->getProfileName() . '</td></tr>
                                    <tr valign="top"><td class="label _language">Company</td><td class="info">' . $this->getCompanyName() . '</td></tr>
                                    <tr valign="top"><td class="label _language">E-mail</td><td class="info">' . $this->getEmail() . '</td></tr>
                                    <tr valign="top"><td class="label _language">Address</td><td class="info">' . $this->getAddress() . '</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div class="head" style="display: none;">
                        <div class="button bClose" style="float: left; width: 110px; height: 25px; margin-top: -3px; padding:0;"><!--onclick="choose_profile_pic();"-->
                        <span class="_language" style="position: relative; top: 2px; left: 15px;">Change Picture</span>
                        ' . $form_upload_pic . '
                        </div>

                        <div class="button bClose _language" style="float: right; margin-top: -3px;" onclick="update_user(' . $this->getId() . ')">Save</div>
                        <div class="button bClose _language" style="float: right; margin-top: -3px;" onclick="show_account_settings(' . $this->getId() . ');">Account Settings</div>
                    </div>
                </div>
            ';
        }//display profile picture

        //display edit form
        public function editForm(){
            echo '
                <form id="form_edit_user_info" method="post">
                  <table class="detail_info"  cellspacing=0 cellpadding=5>
                      <tr valign="top"><td colspan=2 align="left" class="profile"><input type="text" value="' . $this->getProfileName() . '" name="pn"/></td></tr>
                      <tr valign="top"><td class="label _language">Company</td><td class="info"><input type="text" value="' . $this->getCompanyName() . '" name="comp"/></td></tr>
                      <tr valign="top"><td class="label _language">E-mail</td><td class="info"><input type="text" value="' . $this->getEmail() . '" name="em"/></td></tr>
                      <tr valign="top"><td class="label _language">Address</td><td class="info"><input type="text" value="' . $this->getAddress() . '" name="ad"/></td></tr>
                  </tabel>
                </form>
            ';
        }
        //display edit form

        //display edit account: username, password
        public function show_edit_account(){
            echo '
            <form id="form_edit_account" method="post">
                <div class="edit_account">
                    <table>
                        <tr><td width=200 class="_language">Username</td><td><input type="text" name="un" id="username" value="' . $this->getUserName() . '"/></td></tr>
                        <tr><td width=200 class="_language">Password</td><td><input type="password" name="ps" id="password" value=""/></td></tr>
                        <tr><td width=200 class="_language">New Password</td><td><input type="password" name="new_ps" id="new_password" value=""/></td></tr>
                        <tr><td width=200 class="_language">Confirm Password</td><td><input type="password" name="con_ps" id="con_password" value=""/></td></tr>
                    </table>
                    <input type="hidden" name="id" value="' . $this->getId() . '" />
                    <div style="margin: 10px;">
                        <div class="button bClose _language" style="float: right; margin-top: -3px;">Cancel</div>
                        <div class="button _language" style="float: right; margin-top: -3px;" onclick="save_account();">Save</div>
                    </div>
                </div>
            </form>
            ';
        }

    }
?>
