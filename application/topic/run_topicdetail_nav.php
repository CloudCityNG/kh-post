<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<div id="topicdetail">
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	$topic_id = $_GET['topicid'];
	
	$user_id = getCurrentUser();
	
	$subject_id = getValue("SELECT subject_id FROM tbl_subjects_topics WHERE topic_id=".$topic_id);
	
	$q_mylike = getValue("SELECT like_topic_id FROM tbl_like_topics WHERE user_id=".$user_id." AND topic_id=".$topic_id);
	$q_topic_totallikes =  getValue("SELECT COUNT(like_topic_id) FROM tbl_like_topics WHERE topic_id=".$topic_id);
	
	$q_previous = getValue("SELECT topic_id FROM tbl_subjects_topics WHERE topic_id < $topic_id AND subject_id = $subject_id ORDER BY topic_id DESC");
	$q_next = getValue("SELECT topic_id FROM tbl_subjects_topics WHERE topic_id > $topic_id AND subject_id = $subject_id ORDER BY topic_id ASC");
	
	$q_min = getValue("SELECT MIN(topic_id) FROM tbl_subjects_topics WHERE subject_id = $subject_id");
	$q_max = getValue("SELECT MAX(topic_id) FROM tbl_subjects_topics WHERE subject_id = $subject_id");
	
	/*
	$q_totaltopic = getValue("SELECT COUNT(topic_id) FROM tbl_subjects_topics WHERE subject_id = $subject_id");
	$q_index = getResultSet("SELECT @rownum:=@rownum+1 'rank', ST.topic_id FROM tbl_subjects_topics AS ST, (SELECT @rownum:=0) r WHERE subject_id=$subject_id ORDER BY topic_id ASC");//limit 10;
	while($ri = mysql_fetch_array($q_index)){
		echo '_'.$ri['rank'];	
	}
	echo '<br/>'.$q_min.'->'.$q_max;
	echo '<br/>'.$q_previous.'->'.$q_next;
	echo '<br/>Total: '.$q_totaltopic;
	*/	
	//echo '<div class="topic_navigator_block">';
	echo '<div class="topic_navigator">';
	if($topic_id==$q_min){
		$q_previous=$q_max;
		echo '<span>Previous</span><span>&nbsp;||&nbsp;</span>';	
	}
	else{
		echo '<a href="#topic&'.$q_previous.'">Previous</a><span>&nbsp;||&nbsp;</span>';	
	}
	if($topic_id==$q_max){
		$q_next=$q_min;
		//echo '<span style="float: right; margin-right: 2px;">Next</span><span style="float: right;">&nbsp;||&nbsp;</span>';		
		echo '<span style="margin-right: 2px;">Next</span>';		
	}
	else{
		echo '<a href="#topic&'.$q_next.'" style=" margin-right: 2px;">Next</a>';	
	}
	echo '</div>';
	//echo '</div>';
	//if ($q_previous=''){ $q_previous = }
	//$q_previous = getValue("SELECT topic_id FROM tbl_topics WHERE topic_id < $topic_id ORDER BY topic_id DESC");
	//$q_next = getValue("SELECT topic_id FROM tbl_topics WHERE topic_id > $topic_id ORDER BY topic_id ASC");
	
	
	

	//$subject_id = $_GET['subjectid'];
		require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
		$topic_detail = new topic($topic_id);
        $topic_detail->display_TopicDetail();
		
	echo '<div id="banner_label">';   
    	//echo '<h2 class="title _language">Topic Detail</h2>';
		//echo '<span>Loading...</span>';
		echo '<div class="topic_navigator" style="float:left; margin-left: 500px;">';
			if($topic_id==$q_min){
				$q_previous=$q_max;
				echo '<span style="float:left; margin-right: 2px;">Previous</span><span style="float:left; margin: 0px 5px 0px 4px;">||</span>';	
			}
			else{
				echo '<a href="#topic&'.$q_previous.'" style="float:left; margin-right: 2px;">Previous</a><span style="float:left; margin: 0px 5px 0px 4px;">||</span>';	
			}
			
			if($topic_id==$q_max){
				$q_next=$q_min;
			//echo '<span style="float: right; margin-right: 2px;">Next</span><span style="float: right;">&nbsp;||&nbsp;</span>';		
				echo '<span style="float:left; margin: 0px 2px 0px 0px;">Next</span>';		
			}
			else{
				echo '<a href="#topic&'.$q_next.'" style="float:left; margin: 0px 2px 0px 0px;">Next</a>';	
			}
		echo '</div>';
		
		
		
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

