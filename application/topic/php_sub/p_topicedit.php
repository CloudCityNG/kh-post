<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	
	$topic_id = $_POST['topicid'];
	//$subject_id = $_GET['subject_id'];
		
	$title_english = trim($_POST['title_english']);
	$title_japan = trim($_POST['title_japanese']);
	$desc_english = trim($_POST['desc_english']);
	$desc_japan = trim($_POST['desc_japanese']);
	$topic_url = trim($_POST['topic_url']);
	$topic_detail = trim($_POST['topic_detail']);	
	$topic_author = trim($_POST['topic_author']);
	
	$subject_id = $_POST['subject_id'];
	
	/*$title_english = trim(escapte_js_decrypt($_GET['title_english']));
	$title_japan = trim(escapte_js_decrypt($_GET['title_japanese']));
	$desc_english = trim(escapte_js_decrypt($_GET['desc_english']));
	$desc_japan = trim(escapte_js_decrypt($_GET['desc_japanese']));
	$topic_url = trim(escapte_js_decrypt($_GET['topic_url']));
	$topic_detail = trim(escapte_js_decrypt($_GET['topic_detail']));
	$subject_id = $_GET['subject_id'];*/
	
	$desc_english = nl2br($desc_english);
	$desc_japan = nl2br($desc_japan);
	$topic_detail = nl2br($topic_detail);
	
	$topic_title = "";
	if($title_japan!=null || $title_japan!=""){ $topic_title = $title_japan;}
	else { $topic_title = $title_english;}
	
	$date_time = getDateTime();
	$q_edit_topic = runSQL("UPDATE tbl_topics SET topic_title='".$title_english."', topic_title_2nd='".$title_japan."', topic_summary='".$desc_english."', 
							topic_summary_2nd='".$desc_japan."', topic_detail='".$topic_detail."', topic_url='".$topic_url."', topic_add_date='".$date_time."', topic_author='".$topic_author."' 
							WHERE topic_id=".$topic_id);
	
/*==Return Topic Detail==================================================================================================================================*/
echo '<li id="' . $topic_id . '" onclick="load_topic_detail('.$topic_id.')">';
                echo '» '.$topic_title;//.'('.$total_memo.')';
//echo ;
/*
echo '<div id="topicdetail">';
	
		require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
		$topic_detail = new topic($topic_id);
        $topic_detail->display_TopicDetail();
		
	echo '<div id="banner_label">';   
		echo '<a href="#" class="title _language" onclick="delete_topic('.$topic_id.','.$subject_id.')">Delete</a>';
		echo '<a href="#" class="title _language" onclick="load_editopic('.$topic_id.')">Edit</a>';
        echo '<a href="" class="title _language">Like</a>';
    echo '</div>';
echo '</div>';

echo '<div class="get_topictitle" style="display: none;">';
echo '<li id="' . $topic_id . '" onclick="load_topic_detail('.$topic_id.')" style="color: #00F;">';
                echo '» '.$topic_title;//.'('.$total_memo.')';
echo '</li>';
echo '</div>';
*/
/*==Return Topic Detail==================================================================================================================================*/	
	
?>


