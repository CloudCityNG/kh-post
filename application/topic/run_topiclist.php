<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php
/*==List Topic================================================================================================================================================*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");

	$subject_id = $_GET['subjectid'];
        //To display List Topics
			//echo '<div id="banner_label" style="background-color: #FFF; border: 1px #f00 solid; margin: 0px 0px 0px 2px	; width: 96%; height: 13px;">';   
				echo '<span class="title">';
            		echo '<span class=" _language">List Topic</span>';
					echo '&nbsp;<span id="listtopic_loading"></span>';
					
					//echo 'User Type= '.getUserType();
					//exit();
					
					if(getUserType()!=CUSTOMER && getUserType()!=VIEWER){
            			echo '<div id="add_subject" class="icon add_icon" onclick="sethash(\'topicnew&' . $subject_id . '\')"></div>';//onclick="load_newtopic('.$subject_id.')"
					}
           	 	echo '</span>';

    		//echo '</div>';
			//echo '<span class="title _language">List Topic</span>';
			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
			
			echo '<div id="listtopic">';//style="height: 140px;"
				$q_topic_title = getResultSet("SELECT T.topic_id FROM tbl_topics AS T
												INNER JOIN tbl_subjects_topics AS S ON S.topic_id = T.topic_id
												WHERE S.subject_id = $subject_id
												ORDER BY topic_id DESC");
            	echo '<ul class="topiclist_block">';
                if(mysql_num_rows($q_topic_title) != 0){
            		while($topic_title = mysql_fetch_array($q_topic_title)){
                		$topic = new topic($topic_title[0]);
                		$topic->display_ListTopic($subject_id);
            		}
                }
            	echo '</ul>';
			echo '</div>';
/*==END List Topic================================================================================================================================================*/
?>