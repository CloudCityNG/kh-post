<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	connectDB();
	
	$user_id = getCurrentUser();
	$like_date = getDateTime();
	$topic_id = $_GET['topicid'];
	$islike = $_GET['like_value'];
	
	if($islike=='like'){
		$q_like_topic = runSQL("INSERT INTO tbl_like_topics (user_id, topic_id, date_set) 
								VALUES('".$user_id."', '".$topic_id."', '".$like_date."')");
	}
	else{
		$q_like_topic = runSQL("DELETE FROM tbl_like_topics WHERE topic_id=". $topic_id);
	}
?>