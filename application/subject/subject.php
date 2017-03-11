<?php
    /*
    * This used to access to object of subject class
    * Createor: Loch Khemarin
    */

    $action = $_GET['action'];

    require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/subject/class/subject.class.php");

    if($action == "detail")
    {
        $subject_id = $_GET['id'];
        $subject = new subject($subject_id);
        $subject->showDetail();
    }
    if($action == "info"){
        $subject_id = $_GET['id'];
        $subject = new subject($subject_id);
        $str = urlencode($subject->getTitle()) . ";" . urlencode($subject->getSummary()) . ";" . urlencode($subject->getCreatedDate()) . ";" . urlencode($subject->getDueDate()) . ";" . urlencode($subject->getUserName()) . ";" . ($subject->getReportStatusText()) . ";" . urlencode($subject->getTotalTopics());
        echo $str;
        /*$arr = array($subject->getTitle(), ($subject->getSummary()), $subject->getCreatedDate(), $subject->getDueDate(), ($subject->getUserName()) , $subject->getTotalTopics() , $subject->getReportStatusText());
        print_r($arr);*/
    }

    if($action == "form_insert"){
        $subject = new subject();
        $subject->form_insert();
    }

    if($action == "form_edit"){
        $subject = new subject($_GET['target']);
        $subject->form_edit();
    }

    if($action == "save"){
        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        $user_id =  getCurrentUser();
        connectDB();
        $title = ($_POST['t']);
        $ds    = ($_POST['ds']);

        $s     = isset($_POST['s']);
        if($s) $s = 1;
        else $s = 0;
        list($y, $m, $d) = explode('/', $_POST['dd']);
        $dd    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
        $date  = date("Y-m-d");

        runSQL("INSERT INTO tbl_subjects(subject_title, subject_summary, subject_created_date, subject_due_date, is_shared) VALUES('$title', '$ds', '$date', '$dd', $s)");
        $subject_id = mysql_insert_id();
        runSQL("INSERT INTO tbl_requested_subjects(user_id, subject_id) VALUES($user_id, $subject_id)");
        display_block_list();

    }

    if($action == "update"){
        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        $subject_id = $_GET['target'];
        connectDB();
        $title = ($_POST['t']);
        $ds    = ($_POST['ds']);

        $s     = isset($_POST['s']);
        if($s) $s = 1;
        else $s = 0;
        list($y, $m, $d) = explode('/', $_POST['dd']);
        $dd    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

        $sql = "UPDATE tbl_subjects SET
            subject_title = '$title',
            subject_due_date = '$dd',
            subject_summary = '$ds',
            is_shared = $s
            WHERE subject_id = $subject_id
        ";

        runSQL($sql);
        display_block_list();

    }

    if($action == "del"){
        $subject_id = $_GET['target'];
        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");

        runSQL("DELETE FROM tbl_subjects WHERE subject_id =" . $subject_id);
        runSQL("DELETE FROM tbl_requested_subjects WHERE subject_id =" . $subject_id);
        display_block_list();
    }

    if($action == "myrequest"){//change from my request to all subjectes (shared for customer)
        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        //$u_id = getCurrentUser();
        $user_type = getUserType();
        //$sql  = "SELECT subject_id FROM tbl_requested_subjects WHERE user_id = " . $u_id; //old sql for myrequest
        $sql  = "SELECT subject_id FROM tbl_requested_subjects";//new sql for all subjects

        $s_rs = getResultSet($sql);
        echo '
        <div class="subject_list_detail" style="margin-top: 0px;">
            <div class="head"><span class="_language">List of requested subjects</span>';
        //if($user_type == ADMINISTRATOR || $user_type == CUSTOMER)
        echo '<div id="add_subject" style="display: block; float: right;" class="add icon" onclick="insert_subject_form()"></div>';
        echo '</div>
        ';
        if(mysql_num_rows($s_rs) > 0){
            while($s = mysql_fetch_array($s_rs)){
                $subject = new subject($s[0]);
                $subject->large_list();
            }
        }
        echo '</div>';
    }

    if($action == "changereport"){
        $subject_id = $_GET['id'];
        $report_id  = $_GET['val'];
        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        runSQL("UPDATE tbl_subjects SET report_status_id = " . $report_id . " WHERE subject_id = " . $subject_id);
    }

    function display_block_list(){
        echo '<span class="title">
            <span class=" _language">Subjects</span>
            <!--<div id="view_more_subject" class="icon view_more"></div>
            <div id="add_subject" class="icon add_icon" onclick="insert_subject_form()"></div>-->
            </span>';
        //To display List Subjects

        require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/subject/class/subject.class.php");


        $subject_rs = getResultSet("SELECT subject_id FROM tbl_subjects ORDER BY subject_created_date DESC");

        if(mysql_num_rows($subject_rs) != 0){
            echo '<ul class="subject_list_block">';
            while($subject_info = mysql_fetch_array($subject_rs)){
                $subject = new subject($subject_info[0]);
                $subject->drawList();
            }
            echo '</ul>';
        }
    }
?>