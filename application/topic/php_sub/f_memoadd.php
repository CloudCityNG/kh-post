<div id="form_newmemo_block">
	<form name="form_newmemo" action="application/topic/php_sub/p_memoadd.php" method="post" onsubmit="return validateForm()">
		<fieldset>
        	<!-- 
			<legend class="label">Memo</legend>
            -->
			<textarea id="memotext" name="memotext"  rows="5" cols="42" style="resize: none; width: 99%; margin-bottom:2px;" ></textarea>
		</fieldset>
			
        	<input type="hidden" id="topicid" name="topicid" value="<?php echo $_GET['topicid']; ?>" />
        
		<fieldset>
        	<!--
			<input type="submit" value="Add" class="btn_add" onclick="loadform()" />
            -->
            <!--
            <input type="button" name="close" class="bClose btn_add" value="Cancel"/>
            <input type="button" name="add_memo" class="btn_add" value="Add" onclick="add_newmemo()" />
            -->
            <div name="close" class="bClose button btn_add _language">Cancel</div>
            <div name="add_memo" class="button btn_add _language" onclick="add_newmemo()">Add</div>
		</fieldset>
	</form>
</div>