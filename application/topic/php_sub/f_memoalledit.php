<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
	$memo_id = $_GET['memoid'];
	$topic_id = $_GET['topicid'];
	$q_memotext = getValue("SELECT memo_text FROM tbl_memos WHERE memo_id=".$memo_id);
?>
<div id="form_newmemo_block">
	<form name="form_editmemo" action="application/topic/php_sub/p_memoedit.php" method="post" onsubmit="return validateForm()">
    	<input type="hidden" id="memotopicid" name="topic_id" value="<?php echo $topic_id;?>" />
		<fieldset>
        <!--
			<legend class="label">Memo</legend>
        -->
			<textarea id="memotext"  rows="5" cols="42" name="memotext" style="resize: none; width: 99%; margin-bottom:2px;"><?php echo str_replace("<br />", chr(13), $q_memotext); ?></textarea>
		</fieldset>
        
        	<input type="hidden" id="memoid" name="memoid" value="<?php echo $memo_id; ?>" />
        
		<fieldset>
        	<!--
			<input type="submit" value="Update" class="btn_add" />
            -->
            
            <div name="close" class="bClose button btn_add _language">Cancel</div>
            <div name="update_memo" class="button btn_add _language" onclick="edit_memoall(<?php echo $topic_id;?>)">Update</div>
		</fieldset>
	</form>
</div>