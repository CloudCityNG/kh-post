<?php
    ob_start();
    if(!isset($_SESSION))session_start();
    /*
    * open body tag inside the sub make it easy to call more script files or css individually to each page
    * and make it loads faster for other page which do not neccessary need the script files here
    */
    sub_head();


?>
    <link type="text/css" rel="stylesheet" href="application/subject/css/subject.css">
    <link type="text/css" rel="stylesheet" href="application/topic/css/s_topic.css">

    <!-- block navigation -->
    <link type="text/css" rel="stylesheet" href="application/listblock/css/list_block.css">
    <script type="text/javascript" src="application/listblock/js/jquery.listblock.js"></script>

    <!-- like box -->
    <script type="text/javascript" src="application/like/js/jquery.like.js"></script>
    <link type="text/css" rel="stylesheet" href="application/like/css/like.css">

    <!-- cleditor -->
    <script type="text/javascript" src="application/_cleditor/jquery.cleditor.js"></script>
    <link type="text/css" rel="stylesheet" href="application/_cleditor/jquery.cleditor.css">

<!--==RUN========================================================================-->
    <link type="text/css" rel="stylesheet" href="application/topic/css/s_topic.css" />
    <link type="text/css" rel="stylesheet" href="application/topic/css/s_jc.css" />
    <script type="text/javascript" src="js/run_module.js"></script>
<!--==END RUN========================================================================-->

<?php
    sub_head_end();
    sub_body();
?>

<center><div id="loading_content" style="display: none; width: 44%;height: 80%;position: absolute; left: 27%;background: #fff;"><img src="images/loading.gif" style="margin: 50px; center;"  /></div></center>

<div class="template">
    <div class="left tinyscrollbar"></div>
    <div class="content tinyscrollbar"></div>
    <div class="right tinyscrollbar"></div>
</div>

<center>
<div id="insert_subject" class="form_subject_insert" style="display: none;">
</div>
<div id="memo_popupform" class="form_subject_insert" style="display: none;">
</div>
</center>

<div id="message_box_text" style="display: none;">
    <span id="InvalidTitle" class="_language">Invalid Title</span>
    <span id="ConfirmDeleteSubject" class="_language">Are you sure want to delete this?</span>
    <span id="EditSubject_Title" class="_language">Edit Subject</span>
    <span id="InsertSubject_Title" class="_language">Requested Subject</span>
    <span id="memoadd_title_label" class="_language">Memo</span>
    <span id="memoedit_title_label" class="_language">Memo</span>
</div>


<?php
    sub_body_end();
?>