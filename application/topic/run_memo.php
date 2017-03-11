<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php
/*==MEMO List========================================================================================================================*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
			
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
	$memo_id = $_GET['memoid'];
	$topic_id = $_GET['topicid'];
	$memo_date = getValue('SELECT memo_date FROM tbl_memos WHERE memo_id='.$memo_id);
	//echo '<div id="banner_label" style="background-color: #FFF; border: none; margin: 0px 5px 0px 2px; padding-left: 5px; width: 90%; height: 13px;">';   
    	//echo '<span class="title _language">MEMO</span>';
		echo '<span style="margin-left: 7px;">'.$memo_date.'<span>';
		echo '&nbsp;<span id="memo_loading"></span>';//'.'<img  src="images/loading1.gif" height="12px"/>'.'
    //echo '</div>';
	

	echo '<div id="memo">';// style="height: 140px;"
		$q_memo = getValue("SELECT memo_text FROM tbl_memos WHERE memo_id=".$memo_id);
		$memo_text = $q_memo;
		echo $memo_text;
	echo '</div>';
	
	if(getUserType()==CUSTOMER){
	echo '<div id="banner_label" style="background-color: #FFF; border: none; margin: 1px 5px 0px 2px; padding-right: 0px; width: 98%; height: 10px;">';   
		echo '<img src="images/btn_delete.png" title="Delete" onclick="delete_memo('.$memo_id.','.$topic_id.')" />';
		echo '<img src="images/btn_edit.png" title="Edit" onclick="load_form_editmemo('.$memo_id.')"/>';
		
		echo '<span id="memodeletemessage" class="_language" style="display:none;">Are you sure want to delete this?</span>';//style="display:none;"
		echo '<span id="memoedit_textrequired" class="_language" style="display:none;">Text required</span>';//style="display:none;"
    echo '</div>';
	}
/*==END MEMO List========================================================================================================================*/
?>