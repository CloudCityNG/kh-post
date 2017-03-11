<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<script type="text/javascript" src="application/run_textbox_addremove/js/j_textbox_addremove.js"></script>

<script type='text/javascript'>
function getFileSize() {
    var input, file, file_index, i=0, file_size = 8388608; //file_size= 8Mb
	input = document.getElementsByName("topic_file[]")
	for( i=0;i<input.length;i++){
		file_index = document.getElementById('FileGroup'+i);
		file = file_index.files[0];
		if (file.size > file_size ){
			f_size = file.size / 1024;
			f_size = f_size.toFixed(0);

			//var result = num.toFixed(2);
			alert("#" + (i+1) + " NAME: " + file.name + "\n SIZE= " + f_size + "Kb SUPPORT: "+ (file_size/1024) +"Kb \n\n file SIZE not available!!");
			return false;
		}
	}
}

function validateForm()
{
	var x=document.forms["newtopic"]["title_english"].value;
	var focusto = document.getElementById('txt_title_english');
	if (x==null || x=="")
  	{
  		alert("Title English required!");
		focusto.focus();
  		return false;
  	}
}
</script>
<!--==END Limit File Upload Size===================================================-->

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
//$subject_id = $_GET['subjectid'];
$topic_id = $_GET['topicid'];
	$user_id = getCurrentUser();
/*tmp
if(getCurrentUser()==0 || getUserType()==1)
{
	header('Location:'.ROOT.'/?page=signup');
}
*/
?>
<div id="jc_body_wrapper" style="margin-top: 4px;">
	<div id="jc_banner" style="border: none; background-color: #e3e3e3; color:#00F; width:98.6%;">
        <h2 class="title _language">Edit Topic</h2>
    </div>

<?php
	$q_edit_topic = getResultSet("SELECT topic_title, topic_title_2nd, topic_summary, topic_summary_2nd, topic_detail, topic_url, topic_author FROM tbl_topics
									WHERE topic_id=".$topic_id);

	while($rt=mysql_fetch_array($q_edit_topic))
	{
		$topic_title = $rt['topic_title'];		
		$topic_title_2nd = $rt['topic_title_2nd'];
		$topic_summary = $rt['topic_summary'];
		$topic_summary_2nd = $rt['topic_summary_2nd'];
		$topic_url = $rt['topic_url'];
		$topic_detail = $rt['topic_detail'];
		$topic_author = $rt['topic_author'];
?>

<!--==Form Edit Topic====================================================================================================-->
<div id="form_newtopic_block">
<Form  id="form_edittopic"  name="newtopic"  method="post" enctype="multipart/form-data">
	<table border="0" width="100%">
    	<tr>
        	<td colspan="2"><b>TITLE</b></td>
        </tr>
        <tr>
        	<td>English</td>
            <td>Japanese</td>
        </tr>
        <tr>
        	<td><input type="text" id="txt_title_english" name="title_english" class="text_width" value="<?php echo $topic_title; ?>"/></td>
            <td><input type="text" id="txt_title_japan" name="title_japanese" class="text_width" value="<?php echo $topic_title_2nd; ?>"/></td>
        </tr>
        <tr>
        	<td colspan="2"><b>DESCRIPTION in English</b></td>
        </tr>
        <tr>
        	<td colspan="2"><textarea id="txt_desc_english" name="desc_english" class="textarea_width"><?php echo str_replace("<br />", chr(13), $topic_summary); ?></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"><b>DESCRIPTION in Japanese</b></td>
        </tr>
        <tr>
            <td colspan="2"><textarea id="txt_desc_japan" name="desc_japanese" class="textarea_width"><?php echo str_replace("<br />", chr(13), $topic_summary_2nd); ?></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"><b>URL</b></td>
        </tr>
        <tr>
        	<td colspan="2"> <input type="text" id="txt_topic_url" name="topic_url" style="width: 99.2%;" value="<?php echo $topic_url; ?>"></input></td>
        </tr>
        <tr>
        	<td colspan="2"><b>DETAILS</b></td>
        </tr>
        <tr>
        	<td colspan="2"><textarea  id="txt_topic_detail" name="topic_detail"  style="width: 99%; height: 100px;"><?php echo str_replace("<br />", chr(13), $topic_detail); ?></textarea></td>
        </tr>
         <tr>
        	<td colspan="2"><b>Author</b></td>
        </tr>
        <tr>
        	<td colspan="2"><input type="text" id="txt_topic_author" name="topic_author" style="width: 99.2%;" value="<?php echo $topic_author; ?>"></input></td>
        </tr>
    </table>
    
    <input type="hidden"  id="txt_topic_id" name="topicid" value="<?php echo $topic_id; ?>" />
    <input type="hidden" id="txt_subject_id" name="subject_id" value="<?php //echo $subject_id ?>">

	<div class="form_submit">
    	<input type="button" id="update_topic" name="edit_topic" value="Update" class="btn_submit" />
    	<span id="topic_updating"></span>
    </div>

</Form>

</div>
<?php
	}
?>
<!--==END List Subject====================================================================================================-->
</div>
