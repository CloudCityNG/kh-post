<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<div id="topicdetail">
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
$topic_id = $_GET['topicid'];
$topic_detail = new topic($topic_id);
	
	
	$user_id = getCurrentUser();
	
	$subject_id = getValue("SELECT subject_id FROM tbl_subjects_topics WHERE topic_id=".$topic_id);
	
	$q_mylike = getValue("SELECT like_topic_id FROM tbl_like_topics WHERE user_id=".$user_id." AND topic_id=".$topic_id);
	$q_topic_totallikes =  getValue("SELECT COUNT(like_topic_id) FROM tbl_like_topics WHERE topic_id=".$topic_id);
	
	$q_previous = getValue("SELECT topic_id FROM tbl_subjects_topics WHERE topic_id < $topic_id AND subject_id = $subject_id ORDER BY topic_id DESC");
	$q_next = getValue("SELECT topic_id FROM tbl_subjects_topics WHERE topic_id > $topic_id AND subject_id = $subject_id ORDER BY topic_id ASC");
	
	$q_min = getValue("SELECT MIN(topic_id) FROM tbl_subjects_topics WHERE subject_id = $subject_id");
	$q_max = getValue("SELECT MAX(topic_id) FROM tbl_subjects_topics WHERE subject_id = $subject_id");
	
	$previous_id = new topic($q_previous);
	$next_id = new topic($q_next);
	
	$previous_topic = $previous_id->getTopic_Title();
	$next_topic = $next_id->getTopic_Title();
	
	echo '<div class="topic_navigator">';
		echo '<table border="0" width="100%">';
			echo '<tr>';
				echo '<td width="50%" align="right" style="background-color:#FFF;"><a href="#topic&'.$q_previous.'">'.$previous_topic.'</a></td>';
				if($topic_id!=$q_min){
					echo '<td style="background-color:#FFF; border-right: 1px #66ACCA solid; padding-right: 7px;"><img src="application/listblock/images/backward.gif" title="Previous"></td>';
				}		
				if($topic_id!=$q_max){
					echo '<td style="background-color:#FFF;"><img src="application/listblock/images/forward.gif" title="Next"></td>';
				}		
				echo '<td width="50%" align="left" style="background-color:#FFF;"><a href="#topic&'.$q_next.'">'.$next_topic.'</a></td>';
			echo '</tr>';
		echo '</table>';
		/*	
		if($topic_id==$q_min){
			$q_previous=$q_max;
			echo '<span>Previous</span><span>&nbsp;||&nbsp;</span>';	
		}
		else{
			echo '<a href="#topic&'.$q_previous.'">Previous</a><span>&nbsp;||&nbsp;</span>';	
		}
		if($topic_id==$q_max){
			$q_next=$q_min;
			echo '<span style="margin-right: 2px;">Next</span>';		
		}
		else{
			echo '<a href="#topic&'.$q_next.'" style=" margin-right: 2px;">Next</a>';	
		}
		*/
	echo '</div>';
		
   $topic_detail->display_TopicDetail();
		
	echo '<div id="banner_label">';   
    	//echo '<h2 class="title _language">Topic Detail</h2>';
		//echo '<span>Loading...</span>';
		echo '&nbsp;<span id="topicedit_loading" style="float:left;"></span>';
		if(getUserType()!=CUSTOMER){// && getUserType()!=VIEWER
			echo '<a href="#" class="title _language" onclick="delete_topic('.$topic_id.','.$subject_id.')">Delete</a>';
			echo '<span class="event_label title _language" onclick="load_editopic('.$topic_id.')">Edit</span>'; // //onclick="sethash(\'topicedit&' . $topic_id . '\')"
			echo '<span id="topicdeletemessage" class="_language" style="display:none;">Are you sure want to delete this?</span>';//style="display:none;"
		}
        echo '<div class="biznavi_like_button" style="float: right;">Like</div>';
    echo '</div>';
	
	echo '<div id="this_topic_like" style="display: none">'; //style="display: none"
		if($q_mylike){
			echo '<span class="mylike">true</span>';
		}
		elseif(!$q_mylike)
		{
			echo '<span class="mylike">false</span>';
		}
		echo '<span class="total_like">'.$q_topic_totallikes.'</span>';
	echo '</div>';
?>
</div>

