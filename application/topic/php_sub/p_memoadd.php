<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	connectDB();
	
	$memo_text = trim(escapte_js_decrypt($_GET['memotext']));
	$memo_text = nl2br($memo_text);

	$user_id = getCurrentUser();
	$memo_date = getToday();
	$topic_id = $_GET['topicid'];

	$q_add_topic = runSQL("INSERT INTO tbl_memos (user_id, memo_text, memo_date, source_id) 
							VALUES('".$user_id."', '".$memo_text."', '".$memo_date."', '".$topic_id."')");
	$get_memoid = mysql_insert_id();
	//echo '<li id='.$get_memoid.' onclick="load_memo('.$get_memoid.')">» '.$memo_date.' '.$memo_text.'</li>';
	echo $memo_date.';'.$get_memoid;
	
?>