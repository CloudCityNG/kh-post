<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php
/*==List Topic================================================================================================================================================*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");

	$subject_id = $_GET['subjectid']; 
			$q_topic_id = getResultSet("SELECT topic_id FROM tbl_subjects_topics
											WHERE subject_id = $subject_id
											ORDER BY topic_id ASC");
			$total_topic = mysql_num_rows($q_topic_id);
												
			echo '<div class="head" style="margin: 0px 0px 0px 0px;">
					<span class="_language">Report</span>';
				if(getUserType()!=CUSTOMER){	
					echo '<div id="add_subject" class="icon add_icon" style="float: right;margin-left:5px;" onclick="sethash(\'topicnew&' . $subject_id . '\')"></div>'; // onclick="load_newtopic('.$subject_id.')"
				}
				echo '<span class="_language" style="float: right;">Topics</span>
					  <span style="float: right">'.$total_topic.'&nbsp;</span>';
            			
			echo '</div>';
				/*
				echo '<span class="title">';
            		echo '<span class=" _language">&nbsp;Report</span>';
					echo '&nbsp;<span id="listtopic_loading"></span>';
           	 	echo '</span>';
				*/
			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
			
			echo '<div id="listtopic">';//style="height: 140px;"
			/*
				$q_topic_title = getResultSet("SELECT T.topic_id FROM tbl_topics AS T
												INNER JOIN tbl_subjects_topics AS S ON S.topic_id = T.topic_id
												WHERE S.subject_id = $subject_id
												ORDER BY topic_id DESC");
			*/
            	echo '<ul class="topiclist_block">';
				$i = 0;
                if(mysql_num_rows($q_topic_id) != 0){
            		while($topic_id = mysql_fetch_array($q_topic_id)){
                		$topic = new topic($topic_id[0]);
						$i++;
						$z = ($i <10  ? 0 : '').$i;
						//$topic->display_Report1($z);
						//$topic->display_Report1($subject_id);
						if($i%2==0){
							$topic->display_Report1($z);	
						}
						else{
							$topic->display_Report2($z);	
						}
            		}
                }
            	echo '</ul>';
			echo '</div>';
/*==END List Topic================================================================================================================================================*/
?>