<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	connectDB();
	 
	$memo_id = $_GET['memoid'];
	$topic_id = $_GET['topicid'];
	$memo_text = trim(escapte_js_decrypt($_GET['memotext']));
	$memo_text = nl2br($memo_text);
	
	//$user_id = getCurrentUser();
	$memo_date = getToday();
	//$topic_id = $_POST['topicid'];

	$q_editmemo = runSQL("UPDATE tbl_memos SET memo_text='".$memo_text."', memo_date='".$memo_date."' WHERE memo_id=". $memo_id);
	//$topic_id = mysql_insert_id();

	//echo '<div class="memoitem" id='.$memo_id.' onclick="load_memo('.$memo_id.')">» '.$memo_date.' '.$memo_text.'</li>';
	echo '<div class="memoitem" id="'.$memo_id.'" onclick="load_memodetail('.$memo_id.','.$topic_id.')">';//,'.$topic_id.'
		echo '» '.$memo_text;
	echo '</div>';
	
	//header('Location: http://'.DOMAIN.ROOT.'/');
?>


