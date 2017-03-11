<?php
	/*ob_start();
    if(!isset($_SESSION))session_start();
	*/
	//require_once("config/config.php");	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");

	$topic_id = $_GET['topicid'];
	$subject_id = $_GET['subjectid'];
	$user_id = getCurrentUser();

	runSQL("DELETE FROM tbl_subjects_topics WHERE topic_id=".$topic_id." AND subject_id=".$subject_id);
	runSQL("DELETE FROM tbl_topics WHERE topic_id=".$topic_id);
	runSQL("DELETE FROM tbl_user_topics WHERE topic_id=".$topic_id." AND user_id=".$user_id);
	runSQL("DELETE FROM tbl_like_topics WHERE topic_id=".$topic_id." AND user_id=".$user_id);
	runSQL("DELETE FROM tbl_memos WHERE source_id=".$topic_id." AND user_id=".$user_id);

?>