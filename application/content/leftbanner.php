<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php
    /*
    * This used to load left content of the page  via ajax
    */

    $action = $_GET['action'];
    if($action == "home"){
        echo "<div onclick='hide_left();' style='float: right;' class='hide_left'></div>";
		 require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
		 $user_type = getUserType();
        //display the left banner of the home page
        /*
        * There are three block to display vertically
        * First: List of Topics all topics (Order from newest to oldest)
        * Second: List of Topics in Mylist (Order from newest to oldest)
        * Third: List of all subjects (Order from newest to oldest)
        */

        //First Block
/*==List Topic================================================================================================================================================*/
        echo '<div class="navigation_block" id="navigation_listtopic_block">';
        //To display List Topics
			//echo '<div id="banner_label" style="background-color: #FFF; border: none; margin: 0px 0px 0px 2px; padding: 0px; width: 96%; height: 13px;">';   
				echo '<span class="title _language">List Topic</span>';
				echo '&nbsp;<span id="listtopic_loading"></span>';
			//echo '</div>';
			//require_once($_SERVER['DOCUMENT_ROOT'] . "application/topic/run_listtopic.php");
			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");

			echo '<div id="listtopic">';//style="height: 140px;"
				if($user_type == ADMINISTRATOR || $user_type == RESEARCHER){
            		$q_topic_id = getResultSet("SELECT topic_id FROM tbl_topics ORDER BY topic_id DESC");
        		}
				else{
					$q_topic_id = getResultSet('SELECT topic_id FROM tbl_subjects_topics AS ST
												INNER JOIN tbl_subjects AS S ON S.subject_id = ST.subject_id
												WHERE S.report_status_id=3');
				}
				echo '<ul class="topiclist_block">';						
				while($rs= mysql_fetch_array($q_topic_id)){
					$topic_id = $rs['topic_id'];
					$topic = new topic($rs['topic_id']);
                	$topic->display_ListTopic();
				}
				echo '</ul>';
				/*
				$q_topic_title = getResultSet("SELECT topic_id FROM tbl_topics ORDER BY topic_id DESC");
        		if(mysql_num_rows($q_topic_title) != 0){
            	echo '<ul class="topiclist_block">';
            		while($topic_title = mysql_fetch_array($q_topic_title)){
                		$topic = new topic($topic_title[0]);
                		$topic->display_ListTopic();
            		}
            	echo '</ul>';
				}
				*/
			echo '</div>';
        echo '</div>';//End of First Block
/*==END List Topic================================================================================================================================================*/
/*==My List================================================================================================================================================*/
        //Second Block
        echo '<div class="navigation_block">';
			echo '<span class="title _language">My List</span>';
			//require_once($_SERVER['DOCUMENT_ROOT'] . "application/topic/run_mylist.php");

			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
			$user_id = getCurrentUser();
			echo '<div id="mylist">';// style="height: 140px;"
				$q_mylist = getResultSet("SELECT T.topic_id FROM tbl_topics AS T
											INNER JOIN tbl_like_topics AS L	ON L.topic_id = T.topic_id
											WHERE L.user_id=".$user_id." ORDER BY T.topic_id DESC");
        		//if(mysql_num_rows($q_mylist) != 0){
            	echo '<ul class="topiclist_block">';
            		while($topic_title = mysql_fetch_array($q_mylist)){
                		$topic = new topic($topic_title[0]);
                		$topic->display_MyList();
            		}
            	echo '</ul>';
				//}
			echo '</div>';
        echo '</div>';//End of Second Block
/*==END My List================================================================================================================================================*/
        //Third Block
        $inser_subject_btn = "";
        
        if($user_type == ADMINISTRATOR || $user_type == CUSTOMER){
            $inser_subject_btn = '<div id="add_subject" class="icon add_icon" onclick="insert_subject_form()"></div>';
        }
        echo '<div class="navigation_block subjects">';
        echo '<span class="title">
            <span class=" _language">Subjects</span>
            <!-- <div id="view_more_subject" class="icon view_more"></div>
            ' . $inser_subject_btn . ' -->
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

        echo '</div>';//End of Third Block
    }
?>