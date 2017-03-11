<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<?php
/*==MEMO List========================================================================================================================*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
 		//echo '<div class="navigation_block">';
			//echo '<span class="title _language">MEMO LIST</span>';
			//require_once($_SERVER['DOCUMENT_ROOT'] . "application/topic/run_mylist.php");
			require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/application/topic/class/topic.class.php");
			$topic_id = $_GET['topicid'];
			$user_id = getCurrentUser();
			//echo '<div id="banner_label" style="background-color: #FFF; border: none; margin: 0px 0px 0px 2px	; width: 96%; height: 13px;">';   
    			//echo '<span class="title _language">MEMO LIST</span>';
				echo '<span class="title">';
            		echo '<span class=" _language">MEMO LIST</span>';
					echo '&nbsp;<span id="listmemo_loading"></span>';
					if(getUserType()==CUSTOMER){
            			echo '<div id="add_subject" class="icon add_icon" onclick="load_form_newmemo('.$topic_id.')"></div>';
					}
           	 	echo '</span>';
    		//echo '</div>';

			echo '<div id="memolist">';// style="height: 140px;"
				
				
				if(getUserType()==CUSTOMER){
					$q_listmemo = getResultSet("SELECT memo_id, memo_text, memo_date FROM tbl_memos WHERE source_id=".$topic_id." AND user_id=".$user_id." ORDER BY memo_id DESC");
				}
				elseif(getUserType()==ADMINISTRATOR || getUserType()==RESEARCHER){
					$q_listmemo = getResultSet("SELECT memo_id, memo_text, memo_date FROM tbl_memos WHERE source_id=".$topic_id." ORDER BY memo_id DESC");
				}

				$count_memo = mysql_num_rows($q_listmemo);
        		if($count_memo != 0){
            	echo '<ul class="topic_memolist">';
            		while($rm = mysql_fetch_array($q_listmemo)){
						
						$memo_id = $rm['memo_id'];
						$memo_text = str_replace('<br />',' ',$rm['memo_text']);
						//$memo_text = urldecode($memo_text);
						
						
						//$memo_text = cutString($memo_text, 40);	
						$memo_date = $rm['memo_date'];
						echo '<li id="'.$memo_id.'" onclick="sethash(\'topicmemodetail&' . $memo_id.'&'. $topic_id . '\')">';// onclick="load_memo('.$memo_id.','.$topic_id.')">';
							echo '» '.$memo_date.' '.$memo_text;
						echo '</li>';
            		}
            	echo '</ul>';
				}
				else
				{
					echo '<p class="nomemo" style="padding-left: 7px; font-size: 20px; text-align: center; color: #CCC;">No Memo!</p>';
					echo '<ul class="topic_memolist">';
					
					echo '</ul>';	
				}
			echo '</div>';
			
			echo '<span id="memonew_textrequired" class="_language" style="display:none;">Text required</span>';//style="display:none;"
        //echo '</div>';//End of Second Block

/*==END MEMO List========================================================================================================================*/
?>