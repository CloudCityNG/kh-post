<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>

<div id="mylist">
   	<?php 
		$user_id = getCurrentUser();
		echo "USER= ". $user_id;
		exit();
		display_mylist($user_id); 
	?>
</div>
<?php
function display_mylist($user_id)
{
	$q_mylist = getResultSet("SELECT T.topic_id, T.topic_title, T.topic_title_2nd, T.topic_summary, T.topic_summary_2nd FROM tbl_topics AS T
							INNER JOIN tbl_like_topics AS L ON L.topic_id = T.topic_id
							WHERE L.user_id=".$user_id." ORDER BY T.topic_id DESC");						
	$sql_subject = "SELECT S.subject_id, S.subject_title FROM tbl_subjects AS S ";	
	echo '<ul>';
	while($rt = mysql_fetch_array($q_mylist))
	{
		$topic_id = $rt['topic_id'];
		// read topic
		$topic_title = trim($rt['topic_title_2nd']);
		if ($topic_title == "" || $topic_title==null){$topic_title = trim($rt['topic_title']);}
		/*
		echo '<li><img src="images/tick_mylist.png"/> '.$topic_title.'</li>';
		*/
		
		$q_subject = getResultSet($sql_subject."INNER JOIN tbl_subjects_topics AS T ON T.subject_id= S.subject_id
									WHERE T.topic_id=".$topic_id);
		while($rs=mysql_fetch_array($q_subject))
		{
				$subject_id=$rs['subject_id'];
				$subject_title=$rs['subject_title'];		
				echo '<a href="'.ROOT.'/?page=topicdetail&subject_id='.$subject_id.'&topic_id='.$topic_id.'"><li><img src="images/tick_mylist.png"/> '.$topic_title.'</li></a>';
		}
		
	}
	echo '</ul>';
							
}
?>