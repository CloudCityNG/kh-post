<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	 
	$memo_id = $_GET['memoid'];
	//$user_id = getCurrentUser();
	//$topic_id = $_POST['topicid'];

	$q_editmemo = runSQL("DELETE FROM tbl_memos WHERE memo_id=". $memo_id);
	//$topic_id = mysql_insert_id();
?>


