<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php

/*==MEMO List========================================================================================================================*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
			$user_id = getCurrentUser();
			$user_type = getUserType();
			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
			//$topic_id = $_GET['topicid'];
			//echo '<div id="banner_label">';
				echo '<span class="title">';
            		echo '<span class=" _language">All Memo</span>';
					echo '&nbsp;<span id="listmemo_loading"></span>';
           	 	echo '</span>';
			//echo '</div>';
			//echo '<div id="memolist">';
		echo '<div class="memoall">';
			
			if($user_type==CUSTOMER){
				$q_memo_date = getResultSet('SELECT DISTINCT(memo_date) FROM tbl_memos
												WHERE user_id ='.$user_id
												.' ORDER BY memo_date DESC');
			}
			elseif($user_type==ADMINISTRATOR || $user_type==RESEARCHER){
				$q_memo_date = getResultSet('SELECT DISTINCT(memo_date) FROM tbl_memos ORDER BY memo_date DESC');
			}
			
			//$q_topic_id= 'SELECT DISTINCT(source_id) FROM tbl_memos WHERE memo_date=';
			
			echo '<ul class="memoalllist">';
			
				while($rd= mysql_fetch_array($q_memo_date)){
					$memo_date = trim($rd['memo_date']);
					echo '<li>';
						echo '<span class="label_date">'.$memo_date.'</span>';
					
					//$topic_id = getValue($q_topic_id."'".$memo_date."'");
					//echo "User_id= ".$topic_id;
					
							if($user_type==CUSTOMER){
								$get_listmemo = getResultSet("SELECT memo_id, memo_text FROM tbl_memos
																WHERE memo_date='".$memo_date."' AND  user_id=".$user_id." ORDER BY memo_id DESC");
							}
							elseif($user_type==ADMINISTRATOR || $user_type==RESEARCHER){
								$get_listmemo = getResultSet("SELECT memo_id, memo_text FROM tbl_memos
																WHERE memo_date='".$memo_date."' ORDER BY memo_id DESC");
							}
							
							while($rm= mysql_fetch_array($get_listmemo)){
									$memo_id = $rm['memo_id'];
									$memo_text = str_replace('<br />',' ',$rm['memo_text']);
									$topic_id = getValue('SELECT source_id FROM tbl_memos WHERE memo_id='.$memo_id);
									
									echo '<div class="memoitem" id="'.$memo_id.'" onclick="sethash(\'memodetail&' . $memo_id.'&'. $topic_id . '\')">'; //onclick="load_memodetail('.$memo_id.','.$topic_id.')"
										echo '» '.$memo_text;
									echo '</div>';
							}
							
					echo '</li>';
				}	
				
			echo '</ul>';
		echo '</div>';			
/*==END MEMO List========================================================================================================================*/
?>