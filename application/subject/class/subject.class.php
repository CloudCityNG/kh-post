<?php
    /*
    * This class is used to design and access to database for tbl_subjects
    * Creator: Loch Khemarin
    * Date Created: Sep-07-2011
    */

    class subject{
        private $id;
        private $title;
        private $summary;
        private $user_id;
        private $created_date;
        private $due_date;
        private $is_shared;
        private $report_status;

        public function __construct($id = ""){
            $this->id = $id;
            $this->title = "";
            $this->summary = "";
            $this->user_id = 0;
            $this->created_date = "";
            $this->due_date = "";
            $this->is_shared = "";
            $this->report_status = "";
        }

        private function initDb(){
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        }

        //get subject title from db
        public function getTitle(){
            $this->initDb();
            if($this->id != ""){
                $this->title = (getValue("SELECT subject_title FROM tbl_subjects WHERE subject_id = " . $this->id));
            }
            return $this->title;
        }

        //get subject title with brief order in each month from db
        public function getTitleSummary(){
            $this->initDb();
            $date = $this->getCreatedDate();
            $date = explode("-", $date);
            if($this->id != ""){
                $sum_rs = getResultSet("SELECT subject_id FROM tbl_subjects WHERE YEAR(subject_created_date)='" . $date[0] . "' AND MONTH(subject_created_date) = '" . $date[1] . "' ORDER BY subject_created_date DESC");
                $i = 0;
                while($r = mysql_fetch_array($sum_rs)){
                    $i++;
                    if($r[0] == $this->id){
                        $sum = $i;
                        break;
                    }
                }
            }

            return $date[0] . "/" . $date[1] . "_" . $i . "&nbsp;&nbsp;&nbsp;&nbsp;" . $this->getTitle();
        }

        //get subject summary from db
        public function getSummary(){
            $this->initDb();
            if($this->id != ""){
                $this->summary = (getValue("SELECT subject_summary FROM tbl_subjects WHERE subject_id = " . $this->id));
            }
            return $this->summary;
        }


        //get subject created date from db
        public function getCreatedDate(){
            $this->initDb();
            if($this->id != ""){
                $this->created_date = getValue("SELECT subject_created_date FROM tbl_subjects WHERE subject_id = " . $this->id);
            }
            return $this->created_date;
        }

        //get subject due date from db
        public function getDueDate(){
            $this->initDb();
            if($this->id != ""){
                $this->due_date = (getValue("SELECT subject_due_date FROM tbl_subjects WHERE subject_id = " . $this->id));
            }
            return $this->due_date;
        }

        //get subject report status from db
        public function getReportStatus(){
            $this->initDb();
            if($this->id != ""){
                $this->report_status = getValue("SELECT report_status_id FROM tbl_subjects WHERE subject_id = " . $this->id);
            }
            return $this->report_status;
        }

        //return ownership icon of subject: My Request, Shared Request
        private function getOwnerShip(){
            /*$title = '';
            if($this->getUserId() == getCurrentUser()){
                $title = 'My Request';
            }*/
            if($this->getIsShared() == '1'){
                //$title = 'Shared';
                return '<img style="float: left; height: 12px;" src="images/unlocked.png" title="Shared" />';
            }
            else{
                //$title = 'Private';
                return '<img style="float: left; height: 12px;" src="images/locked.png" title="Private" />';
            }
        }

        //get subject report status text from db
        public function getReportStatusTextChange(){
            $this->initDb();
            $rt = "";
            $c_usr = getUserType();
            if($this->id != ""){
                $rid = $this->getReportStatus();
                if($rid != ""){
                    if($c_usr == ADMINISTRATOR || $c_usr == RESEARCHER){
                      $rt = '<select class="edit_subject_status" id="' . $this->id . '">';
                      $s_rs = getResultSet("SELECT report_status_id, report_status_name FROM tbl_report_status");
                      while($r = mysql_fetch_array($s_rs)){
                          $rt .= '<option class="_language" value="' . $r[0] . '"';
                          if($r[0] == $rid) $rt .= ' selected ';
                          $rt .= '>' . $r[1] . '</option>';
                      }
                      $rt .= '</select>';
                  }
                  else{
                        $rt = getValue("SELECT report_status_name FROM tbl_report_status WHERE report_status_id = " . $rid);
                  }
                }
            }
            return $rt;
        }

        public function getReportStatusText(){
            $this->initDb();
            $rt = "";
            $c_usr = getUserType();
            if($this->id != ""){
                $rid = $this->getReportStatus();
                if($rid != ""){
                    $rt = getValue("SELECT report_status_name FROM tbl_report_status WHERE report_status_id = " . $rid);
                }
            }
            return $rt;
        }

        //get subject is shared from db
        public function getIsShared(){
            $this->initDb();
            if($this->id != ""){
                $this->is_shared = getValue("SELECT is_shared FROM tbl_subjects WHERE subject_id = " . $this->id);
            }
            return $this->is_shared;
        }

        //get total topics from db
        public function getTotalTopics(){
            $this->initDb();
            $t = 0;
            if($this->id != ""){
                $t = getValue("SELECT COUNT(*) FROM tbl_subjects_topics WHERE subject_id = " . $this->id);
            }
            return $t;
        }

        //get user request: id
        public function getUserId(){
            $this->initDb();
            $ui = 0;
            if($this->id != ""){
                $ui = getValue("SELECT user_id FROM tbl_requested_subjects WHERE subject_id = " . $this->id);
            }
            return $ui;
        }

        //get user request: name
        public function getUserProfileName(){
            $this->initDb();
            $un = "";
            $ui = $this->getUserId();
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/user/class/user.class.php");
            $user = new user($ui);
            return $user->getProfileName();
        }

        //get user request: picture
        public function getUserProfilePicture(){
            $this->initDb();
            $un = "";
            $ui = $this->getUserId();
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/user/class/user.class.php");
            $user = new user($ui);
            return $user->getProfilePicture();
        }

        //get user request: company
        public function getUserCompany(){
            $this->initDb();
            $un = "";
            $ui = $this->getUserId();
            if($ui != ""){
                $un = getValue("SELECT user_company FROM tbl_users WHERE user_id = " . $ui);
            }
            return $un;
        }

        //show list block navigation
        public function drawList(){
            $this->initDb();
            $ut = getUserType();
            $ui = getCurrentUser();
            if($ut != ADMINISTRATOR && $ut != RESEARCHER && $ui != $this->getUserId()){
                if($this->getReportStatus() != "3") return;
            }

            if($this->getIsShared() == "0" && $ut == CUSTOMER && $ui != $this->getUserId()){
                return;
            }

            //echo '<li id="' . $this->id . '" onclick="load_subject_detail(' . $this->id . ')">';
            echo '<li id="' . $this->id . '" onclick="sethash(\'subject&' . $this->id . '\')">';
                echo "&raquo;&nbsp;&nbsp;" . $this->getTitleSummary();
                //echo '<span class="total_topic">' . $this->getTotalTopics() . '&nbsp;&nbsp;<span class="_language">Topics</span></span>';
            echo '</li>';
        }

        //show detail
        public function showDetail(){
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
            $c_usr = getUserType();

            $editable = false;
            if($c_usr == ADMINISTRATOR) $editable = true;
            if($c_usr == CUSTOMER && getCurrentUser() == $this->getUserId()) $editable = true;

            $status_id = $this->getReportStatus();
            $status_text = $this->getReportStatusTextChange();
            if($c_usr == CUSTOMER){
                $status_text = '<span class="_language">' . $status_text . '</span>';
            }

            if($editable){
                $style = "";
                if($this->getTotalTopics() > 0) $style = 'display: none;';
                $del_btn ='
                    <div class="icon delete" style="float: right;' . $style . '" onclick="delete_subject(' . $this->id . ')"></div>
                ';

                $edit_btn = '
                    <div class="icon edit" style="float: right; margin-right: 10px;" onclick="edit_subject_form(' . $this->id . ')"></div>
                ';
            }
            else{
                $del_btn = "";
                $edit_btn = "";
            }

            echo '<div class="subject_detail">';
            echo '
                <center>
                <div class="head">
                    <span class="_language" style="float: left;">Requested Detail</span>
                    ' . $del_btn . '
                    ' . $edit_btn . '
                </div>
                <table style="width: 90%; margin: 0 10px 10px 10px;" cellspacing="0" cellpadding="5" border=0>
                    <tr style="height: 15px;">
                        <td style="width: 50px;" align="left" valign="top"></td>

                        <td valign="top" align="left" colspan=2></td>
                    </tr>
                    <tr style="height: 30px;">
                        <td align="left" style="width: 50px;" valign="top"><label class="label _language">Title</label></td>

                        <td valign="top" align="left" colspan=2><span class="title" style="float: left; font-size: 16px;">' . $this->getTitle() . '</span><div style="float: left; margin: 3px 0 2px 5px;">' . $this->getOwnerShip() . '</div></td>
                    </tr>
                    <tr style="height: 30px;">
                        <td align="left" valign="top"><label class="label _language">Summary</label></td>

                        <td valign="top" align="left" colspan=2><span class="info">' . $this->getSummary() . '</span></td>
                    </tr>
                    <tr style="height: 30px;">
                        <td align="left" valign="top"><label class="label _language">Created Date</label></td>

                        <td valign="top" style="width: 50px;"  align="left"><span class="info">' . $this->getCreatedDate() . '</span></td>
                        <td rowspan=3 valign="top">
                            <table style="height: 100%; float: left;">
                                <tr valign="top">
                                    <td>
                                        <label class="label _language" style="width: 45px;">Requester</label>
                                    </td>
                                    <td>
                                        <div style="margin-left: 5px; max-width: 64px; max-height: 64px; min-width: 40px; min-height: 40px; float: right; display: block;">
                                            <img style="width: 100%; height: 100%;" src="' . $this->getUserProfilePicture() . '" />
                                        </div>
                                    </td>
                                    <td style="padding-left: 10px;">
                                        <span class="info">' . $this->getUserProfileName() . '</span><br />
                                        <span class="info">' . $this->getUserCompany() . '</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 30px;">
                        <td align="left" valign="top"><label class="label _language">Due Date</label></td>

                        <td valign="top" align="left"><span class="info">' . $this->getDueDate() . '</span></td>
                    </tr>
                    <!--
                    <tr style="height: 30px;">
                        <td align="left" valign="top"><label class="label _language">Requester</label></td>

                        <td valign="top" align="left"><span class="info">' . $this->getUserProfileName() . '</span></td>
                    </tr>
                    -->
                    <tr style="height: 30px;">
                        <td align="left" valign="top"><label class="label _language">Status</label></td>

                        <td valign="top" align="left"><span class="info">' . $status_text . '</span></td>
                    </tr>
                </table>
                </center> <br />
            ';
			//RUN
			if($this->getReportStatus() == "3" || $c_usr == ADMINISTRATOR || $c_usr == RESEARCHER){
				echo '<div id="report_block" style="padding: 0px 10px 30px 10px; margin-bottom: 100px;">';//style="border: 2px #F00 solid;"
				echo '</div>';
			}
			//END RUN
			
            echo '</div>';
			
			
        }//end: show detail

        //show form insert
        public function form_insert(){
            echo '
                <div class="form_subject_insert">
                    <div class="content" style="height: 410px;">
                        <!--<center><h3 class="_language">Request Subject</h3></center>-->
                        <div style="margin: 10px;">
                        <label class="_language">Title</label>
                            <input type="text" value="" name="t" id="txt_subject_title" style="width: 100%;"/>
                        </div>

                        <div style="height: 40px;">
                        <div style="margin: 10px; float: left;">
                        <label class="_language">Due Date</label>
                            <input type="text" name="dd" class="date" value="' . date("Y/m/d") . '" id="txt_subject_due_date"/>
                        </div>
                        <div style="margin: 10px; float: right;">
                        <label class="_language">Share</label>
                            <input name="s" type="checkbox" id="chk_share"/>
                        </div>
                        </div>

                        <div style="margin: 10px;">
                        <label class="_language">Description</label>
                            <textarea name="ds" id="subject_summary" style="display: block; width: 100%; height: 100px; margin: 0px auto;"></textarea>
                        </div

                        <div style="margin: 10px;">
                            <div class="button bClose _language" style="float: right;">Cancel</div>
                            <div class="button _language" id="save_subject" style="float: right;">Save</div>
                        </div>
                    </div>
                </div>
            ';
        }//end: show insert

        //show edit
        public function form_edit(){
            $due_date = $this->getDueDate();
            $due_date = explode("-", $due_date);
            $y = $due_date[0];
            $m = $due_date[1];
            $d = $due_date[2];
            $due_date = date("Y/m/d", mktime(0, 0, 0, $m, $d, $y));
            $shared = $this->getIsShared();
            $sumary = str_replace("<br />", chr(13), $this->getSummary());
            if($shared == "1"){
                $shared = " checked";
            }
            else $shared = '';

            echo '
                <div class="form_subject_edit">
                    <div class="content" style="height: 410px;">
                        <!--<center><h3 class="_language">Edit Subject</h3></center>-->
                        <div style="margin: 10px;">
                        <label class="_language">Title</label>
                            <input type="text" name="t" value="' . $this->getTitle() . '" id="txt_edit_subject_title" style="width: 100%;"/>
                        </div>

                        <div style="height: 40px;">
                        <div style="margin: 10px; float: left;">
                        <label class="_language">Due Date</label>
                            <input type="text" name="dd" class="date" value="' . $due_date . '" id="txt_edit_subject_due_date"/>
                        </div>
                        <div style="margin: 10px; float: right;">
                        <label class="_language">Share</label>
                            <input type="checkbox" name="s" id="chk_edit_share" ' . $shared . '/>
                        </div>
                        </div>

                        <div style="margin: 10px;">
                        <label class="_language">Description</label>
                            <textarea id="edit_subject_summary" name="ds" style="display: block; width: 100%; height: 100px; margin: 0px auto;">' . $sumary . '</textarea>
                        </div

                        <div style="margin: 10px;">
                            <div class="button bClose _language" style="float: right;">Cancel</div>
                            <div class="button _language" style="float: right;" id="save_subject">Save</div>
                        </div>
                    </div>
                </div>
            ';
        }//end:show edit

        //show large list
        public function large_list(){
            $this->initDb();
            $ut = getUserType();
            $ui = getCurrentUser();
            if($ut != ADMINISTRATOR && $ut != RESEARCHER && $ui != $this->getUserId()){
                if($this->getReportStatus() != "3") return;
            }

            if($this->getIsShared() == "0" && $ut == CUSTOMER && $ui != $this->getUserId()){
                return;
            }

            echo '
                <div class="list">
                <table style="width: 99%; height: 100%; margin-bottom: 5px;" cellspacing=0 cellpadding=0>
                    <tr>
                        <td valign="top">
                            <div class="title"><a href="#subject&' . $this->id . '">' . $this->getTitle() . '</a>
                            <div style="display: inline-block;margin: 5px 0 1px 2px;">' . $this->getOwnerShip() . '</div>
                            </div>
                            <div class="description">
                                ' . $this->getSummary() . '
                            </div>
                        </td>
                        <td style="width: 120px;" valign="top"  align="right">
                            <div class="company">
                                ' . $this->getUserCompany() . '
                            </div>
                            <div class="status">
                                <span class="_language status_value">' . $this->getReportStatusText() . '</span>
                            </div>
                            <div class="totaltopics">
                                ' . $this->getTotalTopics() . ' <span class="_language">Topics</span>
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
            ';
        }
    }
?>