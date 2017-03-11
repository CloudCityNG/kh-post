
/*Show User*/
function show_user_profile(user_id){
	//alert(user_id);
    $("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");
    $.ajax({
        url: "application/topic/run_userprofile.php?userid=" + user_id,
        success: function(data){
			//alert(data);
            $("div.content:first").html(data);
            //$(".scrollbar").scrollbar();
            $("div.content:first").LoadLanguage({
                language: current_language
            });
        }
    });
    $("div.right").hide();
}

/*Show list topic of research*/
function subject_report(subject_id){
	$.ajax({
		url: "application/topic/run_report.php?action=report&subjectid=" + subject_id,
		success: function(data){
			data = unescape(data);
			$("div.content:first").find("div#report_block").html(data).LoadLanguage({
                language: current_language
            });
		}	
	});
}



/*==Form New Topic===========================================================================================================================*/
function load_newtopic(subject_id){//subject_id, 
    $.ajax({
		cache: false,
        "url": "application/topic/run_topicnew.php?action=newtopic&subjectid=" + subject_id,
        "success": function(data){
            data = unescape(data);
			hide_left();
            $("div.content").html(data).LoadLanguage({
                language: current_language
            });
			
			$("#txt_desc_english").cleditor({ width: 730, height: 150});
			$("#txt_desc_japan").cleditor({ width: 730, height: 150});
			$("#txt_topic_detail").cleditor({ width: 730, height: 170});
			
			
			$("#add_topic").click(function(){
				//$('span#topic_saving').append('Saving...');
				//$('img#topic_saving').attr('src','images/progress.gif');
				$('span#topic_adding').html('<img  src="images/progress.gif" height="20px"/>');
                $.post('application/topic/php_sub/p_topicadd.php?action=newtopic', $("form#form_newtopic").serialize(), function(data) {			
					//detail
                	data = unescape(data);
					data = data.toString();
					var st = data.indexOf('id="', 0);
					var et = data.indexOf('"', st);
					var topic_id = data.substr(st + 4, et-st);
					
					$('div#listtopic  ul').prepend(data);					
					//$('div#listtopic  ul').find('li#' + topic_id).trigger('click');
					load_subject_detail(subject_id);

    			});
			});
        }
    });
	//show_left();
}
/*==END Form New Topic===========================================================================================================================*/
/*==Form Edit Topic===========================================================================================================================*/
function load_editopic(topic_id){//subject_id, 
	//$('img#topicedit_loading').attr('src','images/progress.gif');
	$('span#topicedit_loading').html('<img  src="images/progress.gif" style="margin-top: 1px; width: 20px; height: 20px;"/>');
    $.ajax({
		cache: false,
        "url": "application/topic/run_topicedit.php?action=edittopic&topicid=" + topic_id,
        "success": function(data){
            data = unescape(data);
			hide_left();
            $("div.content").html(data).LoadLanguage({
                language: current_language
            });
			$("#txt_desc_english").cleditor({ width: 730, height: 150});
			$("#txt_desc_japan").cleditor({ width: 730, height: 150});
			$("#txt_topic_detail").cleditor({ width: 730, height: 170});
			
			$("#update_topic").click(function(){
				//$('span#topic_updating').append('Updating...');
				//$('img#topic_updating').attr('src','images/progress.gif');
				$('span#topic_updating').html('<img  src="images/progress.gif" height="20px"/>');
                $.post('application/topic/php_sub/p_topicedit.php?action=edittopic', $("form#form_edittopic").serialize(), function(data) {				
                	data = unescape(data);
					//load_topic_detail(data)
					
					data = unescape(data);
					data = data.toString();
					var st = data.indexOf('id="', 0);
					var et = data.indexOf('"', st);
					var topic_id = data.substr(st + 4, et-st);
					
					//Total Memo
					var list_topic_title = $('div#listtopic  ul').find('li#' + topic_id).html();
					var m_left = list_topic_title.indexOf('(', 0);
					var m_right = list_topic_title.indexOf(')', m_left);
					
					var memo_total = list_topic_title.substr(m_left, m_right-m_left+1);
					//alert(memo_total);
					//memo_total = parseInt(memo_total);

					$('div#listtopic  ul').find('li#' + topic_id).replaceWith(data + memo_total + '</li>');					
					$('div#listtopic  ul').find('li#' + topic_id).trigger('click');
    			});
			});
        }
    });
}
/*==END Form Edit Topic===========================================================================================================================*/
/*==Get Mouse Position===========================================================================================================================*/

/*==END Get Mouse Position===========================================================================================================================*/
/*==Form New Memo PopUp===========================================================================================================================*/
function load_form_newmemo(topic_id){
    $.ajax({
        //url : "application/subject/subject?action=form_insert",
		url : "application/topic/php_sub/f_memoadd.php?action=formaddmemo&topicid=" + topic_id,
        success: function(data){
			data = unescape(data);
            $('#memo_popupform').html(data);

            var ln;
            if(current_language == "jp")ln = "ja";
            else ln = "";
            $("#txt_subject_due_date").datepick($.extend($.datepick.regional[ln]));

			
            $("#memo_popupform").LoadLanguage({
                language: current_language
            });
			
			//Form NewMemo
			$("#memo_popupform").dialog("option", "title", $("#memoadd_title_label").html());
            $("#memo_popupform").dialog("open");
			$('#memo_popupform').dialog({
        		width: 400,
    		});
            $(".bClose").click(function(){
                $("#memo_popupform").dialog("close");
            });
        }
    });
}

/*==END New Form Memo PopUp===========================================================================================================================*/
function load_form_editmemo(memo_id){
    $.ajax({
        //url : "application/subject/subject?action=form_insert",
		url : "application/topic/php_sub/f_memoedit.php?action=formeditmemo&memoid=" + memo_id,
		cache: false,
        success: function(data){
			data = unescape(data);
            $('#memo_popupform').html(data);
			/*
            var ln;
            if(current_language == "jp")ln = "ja";
            else ln = "";
            $("#txt_subject_due_date").datepick($.extend($.datepick.regional[ln]));
			*/
			
            $("#memo_popupform").LoadLanguage({
                language: current_language
            });
			//Form EditMemo
			$("#memo_popupform").dialog("option", "title", $("#memoedit_title_label").html());
            $("#memo_popupform").dialog("open");
			$('#memo_popupform').dialog({
        		width: 400,
    		});
            $(".bClose").click(function(){
                $("#memo_popupform").dialog("close");
            });
        }
    });
}
//Form EditMemoAll
function load_form_editmemoall(memo_id, topic_id){
    $.ajax({
        //url : "application/subject/subject?action=form_insert",
		url : "application/topic/php_sub/f_memoalledit.php?action=formeditmemoall&memoid=" + memo_id + "&topicid="+topic_id,
		cache: false,
        success: function(data){
			data = unescape(data);
            $('#memo_popupform').html(data);
			/*
            var ln;
            if(current_language == "jp")ln = "ja";
            else ln = "";
            $("#txt_subject_due_date").datepick($.extend($.datepick.regional[ln]));
			*/

            $("#memo_popupform").LoadLanguage({
                language: current_language
            });
			//Form NewMemo
			$("#memo_popupform").dialog("option", "title", $("#memoedit_title_label").html());
            $("#memo_popupform").dialog("open");
			$('#memo_popupform').dialog({
        		width: 400,
    		});
            $(".bClose").click(function(){
                $("#memo_popupform").dialog("close");
            });
        }
    });
}
/*==END Edit Form Memo PopUp===========================================================================================================================*/
/*==Add New Memo===========================================================================================================================*/
function add_newmemo()
{
	var msr = $('#memonew_textrequired').html();
	var topic_id = $('#topicid').val();
	var memo_text = $('#memotext').val();
	
	insert_text = escape(memo_text);
	
	if(memo_text==null || memo_text==""){
			alert(msr);
			document.getElementById('memotext').focus();
			return false;
	}
	
	$.ajax({
        "url": "application/topic/php_sub/p_memoadd.php?action=memoadd&topicid=" + topic_id + "&memotext=" + insert_text,//&subjectid=" + subject_id +"
        "success": function(data){
			data = unescape(data.toString());
			data = data.split(';');		
		
			
			var str_insert = data[0] + ' ' + cutUT8String(memo_text, 30, 20);
			str_insert = '<li id="'+ data[1] +'" onclick="load_memo('+ data[1] +')">» ' + str_insert + '</li>';
			
			$('div#memolist ul').prepend(str_insert);
			$('div#memolist ul').find('li#' + data[1]).trigger('click');
			
           	$(".bClose").trigger("click");
			$('.nomemo').remove();
        }
    });
	//Total Memo
	var list_topic_title = $('div#listtopic  ul').find('li#' + topic_id).html();
	var m_left = list_topic_title.indexOf('(', 0);
	var m_right = list_topic_title.indexOf(')', m_left);				
	var str_memo = list_topic_title.substr(m_left, m_right-m_left+1);
	var memo_count = list_topic_title.substr(m_left+1, m_right-m_left-1);
	memo_total = '(' + (parseInt(memo_count) + 1) + ')';
	
	list_topic_title= list_topic_title.replace(str_memo, memo_total);
	list_topic_title= '<li id="'+ topic_id +'" onclick="load_topic_detail('+ topic_id +')">' + list_topic_title + '</li>';

	$('div#listtopic ul').find('li#' + topic_id).replaceWith(list_topic_title);		
	$('div#listtopic ul').find('li#' + topic_id).addClass("current_topic");
	
	$('div#mylist ul').find('li#' + topic_id).replaceWith(list_topic_title);
	$('div#mylist ul').find('li#' + topic_id).addClass("current_topic");
	
}
/*==Form Add New Memo===========================================================================================================================*/
/*==Add New Memo===========================================================================================================================*/
//Form Popup Edit Memo of Topic
function edit_memo()
{
	var msr = $('#memoedit_textrequired').html();
	var memo_id = $('#memoid').val();
	var memo_text = $('#memotext').val();
	
	var insert_text = escape(memo_text);
	
	if(memo_text==null || memo_text==""){
			alert(msr);
			document.getElementById('memotext').focus();
			return false;
	}
	
	$.ajax({
        "url": "application/topic/php_sub/p_memoedit.php?action=memoedit&memoid=" + memo_id + "&memotext=" + insert_text,//&subjectid=" + subject_id +"
        "success": function(data){
			//data = unescape(data);
			var str_insert =data + cutUT8String(memo_text, 30, 20);
			//alert(str_insert);
			/////////////////
			
			$('div#memolist ul').find('li#' + memo_id).html('» ' + str_insert);
			$('div#memolist ul').find('li#' + memo_id).click();
			//$('div#memo').replaceWith(data);
           	$(".bClose").trigger("click");
        }
    });
}

function cutUT8String(str_from, eng_len, utf_len)
{
	
	isUTF8 = isDoubleByte(str_from);
	//var str_o = "";
				if(isUTF8)
				{
					//alert('Jap');
					if(str_from.length > utf_len){
						str_to =  str_from.substr(0,utf_len) + '...';
						return str_to;
					}
					else{return str_from;}
				}
				else if(!isUTF8)
				{
					if(str_from.length > eng_len){
						str_to =  str_from.substr(0,eng_len) + '...';
						return str_to;
					}
					else{return str_from;}
				}		
}
//Form Popup Edit Memo of All Topic
function edit_memoall(topic_id)
{
	var msr = $('#memoedit_textrequired').html();
	var memo_id = document.getElementById('memoid').value;
	var memo_text = document.getElementById('memotext').value;
	
	//memo_text = escape(memo_text);
	var insert_text = escape(memo_text);
	
	if(memo_text==null || memo_text==""){
			alert(msr);
			document.getElementById('memotext').focus();
			return false;
	}
	
	$.ajax({
        "url": "application/topic/php_sub/p_memoalledit.php?action=memoalledit&memoid=" + memo_id + "&memotext=" + insert_text + "&topicid=" + topic_id,//&subjectid=" + subject_id +"
        "success": function(data){
			
			var str_insert =cutUT8String(memo_text, 30, 20);
			
			$('div.memoall ul.memoalllist li').find('div#' + memo_id).html('» ' + str_insert);
			load_memodetail_whenupdate(memo_id, topic_id);
			
			//$('div#memolist ul').find('li#' + memo_id).html('» ' + str_insert);
			//$('div#memolist ul').find('li#' + memo_id).click();
			
			/*
			$('div.memoall ul.memoalllist li').find('div#' + memo_id).replaceWith(data);
			load_memodetail_whenupdate(memo_id, topic_id);
			*/
			
           	$(".bClose").trigger("click");
        }
    });
}

/*==Form Add New Memo===========================================================================================================================*/
/*==Delete Memo===========================================================================================================================*/
//Delete Memo of Topic
	function delete_memo(memo_id, topic_id)
	{
		var memodeletesms = $('#memodeletemessage').html();
		var ok_del= confirm(memodeletesms);
		if(ok_del)
		{
		$.ajax({
			url: 'application/topic/php_sub/p_memodelete.php?action=memedelete&memoid=' + memo_id,
			success: function(data)
			{
				//alert(data);
				$('div#memo_block').children().remove();
				$('div#memolist ul').find('li#' + memo_id).remove();
				$('div#memo_block').hide();	
				
	//Total Memo
	var list_topic_title = $('div#listtopic  ul').find('li#' + topic_id).html();
	var m_left = list_topic_title.indexOf('(', 0);
	var m_right = list_topic_title.indexOf(')', m_left);				
	var str_memo = list_topic_title.substr(m_left, m_right-m_left+1);
	var memo_count = list_topic_title.substr(m_left+1, m_right-m_left-1);
	memo_total = '(' + (parseInt(memo_count) - 1) + ')';
	
	list_topic_title= list_topic_title.replace(str_memo, memo_total);
	list_topic_title= '<li id="'+ topic_id +'" onclick="load_topic_detail('+ topic_id +')">' + list_topic_title + '</li>';

	$('div#listtopic ul').find('li#' + topic_id).replaceWith(list_topic_title);		
	$('div#listtopic ul').find('li#' + topic_id).addClass("current_topic");
	
	$('div#mylist ul').find('li#' + topic_id).replaceWith(list_topic_title);
	$('div#mylist ul').find('li#' + topic_id).addClass("current_topic");
	//END Total Memo
			}
		});
		}
	}

//Delete Memo of All Topic
	function delete_memoall(memo_id, topic_id)
	{
		var memodeletesms = $('#memodeletemessage').html();
		var ok_del= confirm(memodeletesms);
		if(ok_del)
		{
		$.ajax({
			url: 'application/topic/php_sub/p_memodelete.php?action=memedelete&memoid=' + memo_id,
			success: function(data)
			{
				//alert(data);
				$('div#memo_block').children().remove();
				$('div.memoall ul.memoalllist li').find('div#' + memo_id).remove();
				$('div#memo_block').hide();	
				
	//Total Memo
	var list_topic_title = $('div#listtopic  ul').find('li#' + topic_id).html();
	var m_left = list_topic_title.indexOf('(', 0);
	var m_right = list_topic_title.indexOf(')', m_left);				
	var str_memo = list_topic_title.substr(m_left, m_right-m_left+1);
	var memo_count = list_topic_title.substr(m_left+1, m_right-m_left-1);
	memo_total = '(' + (parseInt(memo_count) - 1) + ')';
	
	list_topic_title= list_topic_title.replace(str_memo, memo_total);
	list_topic_title= '<li id="'+ topic_id +'" onclick="load_topic_detail('+ topic_id +')">' + list_topic_title + '</li>';

	$('div#listtopic ul').find('li#' + topic_id).replaceWith(list_topic_title);		
	$('div#listtopic ul').find('li#' + topic_id).addClass("current_topic");
	
	$('div#mylist ul').find('li#' + topic_id).replaceWith(list_topic_title);
	$('div#mylist ul').find('li#' + topic_id).addClass("current_topic");
	//END Total Memo
			}
		});
		}
	}
/*==END Delet Memo===========================================================================================================================*/

/*==Display Memo===========================================================================================================================*/
function load_memo(memo_id, topic_id){//subject_id, 
	$('div#memo_block').show();
	//$('img#memo_loading').attr('src', 'images/loading1.gif');
	$('span#memo_loading').html('<img  src="images/loading1.gif" height="12px"/>');
	
	$("div#memolist ul.topic_memolist li").each(function(){
        if($(this).attr("id") == memo_id) $(this).addClass("current_memo");
        else $(this).removeClass("current_memo");
    });

    $.ajax({
        "url": "application/topic/run_memo.php?action=memo&memoid=" + memo_id +'&topicid=' + topic_id,//&subjectid=" + subject_id +"
        "success": function(data){
            data = unescape(data);
			$("div#memo_block").show();
            $("div#memo_block").html(data).LoadLanguage({
            	language: current_language
            });
        }
    });
}
/*==END Display Memo===========================================================================================================================*/


/*==Display Memo List===========================================================================================================================*/
function load_topic_memo(topic_id){//subject_id, 
	//$('img#listmemo_loading').attr('src', 'images/loading1.gif');
	$('span#listmemo_loading').html('<img  src="images/loading1.gif" height="12px"/>');

    $.ajax({
        "url": "application/topic/run_memolist.php?action=topicmemo&topicid=" + topic_id,//&subjectid=" + subject_id +"
        "success": function(data){
            data = unescape(data);
			
			$("div#memolist_block").html(data).LoadLanguage({
            	language: current_language
            });
			var str_from = "";
			var str_to = "";
			var no_english = 30;
			var no_utf = 20;
			$('div#memolist ul.topic_memolist li').each(function(){
				str_from = $(this).html();
				isUTF8 = isDoubleByte(str_from);
				if(isUTF8)
				{
					if(str_from.length > no_utf){
					str_to =  str_from.substr(0,no_utf) + '...';
					$(this).html(str_to);
					}
				}
				else if(!isUTF8)
				{
					if(str_from.length > no_english){
					str_to =  str_from.substr(0,no_english) + '...';
					$(this).html(str_to);
					}
				}	
			});
			
			$("div#memolist_block").show();
			$("div.right").show();
			
			$('a#newmemo').css('display','block');

            $("div.right div.navigation_block:first").blockNavigation({
                num_per_page: 5
            });
        }
    });
}

function isDoubleByte(str) {
    for (var i = 0, n = str.length; i < n; i++) {
        if (str[i].charCodeAt() > 255) { return true; }
    }
    return false;
}
/*==END Display Memo List===========================================================================================================================*/
/*==Display MemoAll===========================================================================================================================*/
//Load All MemoList for All Topics
function load_memoalllist(){//subject_id, 
	//$('img#listmemo_loading').attr('src', 'images/loading1.gif');
	$('span#listmemo_loading').html('<img  src="images/loading1.gif" height="12px"/>');

    $.ajax({
        "url": "application/topic/run_memoalllist.php?action=memoall",//&subjectid=" + subject_id +"
        "success": function(data){
            data = unescape(data);
			
			$("div#memolist_block").html(data).LoadLanguage({
            	language: current_language
            });
		
			
			var str_from = "";
			var str_to = "";
			var no_english = 30;
			var no_utf = 20;
			$('div.memoall div.memoitem').each(function(){
				str_from = $(this).html();
				isUTF8 = isDoubleByte(str_from);
				if(isUTF8)
				{
					if(str_from.length > no_utf){
					str_to =  str_from.substr(0,no_utf) + '...';
					$(this).html(str_to);
					}
				}
				else if(!isUTF8)
				{
					if(str_from.length > no_english){
					str_to =  str_from.substr(0,no_english) + '...';
					$(this).html(str_to);
					}
				}	
			});
			
			$("div#memolist_block").show();
			$("div.right").show();
			$("div#memo_block").hide();
			$('a#newmemo').css('display','block');

            $("div.right div.navigation_block:first").blockNavigation({
                num_per_page: 5
            });
			
        }
    });
}
/*==END Display MemoAll===========================================================================================================================*/
//Load MemoDetail for AllMemo when click UPDATE
function load_memodetail_whenupdate(memo_id, topic_id){//subject_id, 
	$('div#memo_block').show();
	//$('img#memo_loading').attr('src', 'images/loading1.gif');
	$('span#memo_loading').html('<img  src="images/loading1.gif" height="12px"/>');
	
	$("div.memoall ul.memoalllist li div.memoitem").each(function(){
        if($(this).attr("id") == memo_id) $(this).addClass("current_memoitem");
        else $(this).removeClass("current_memoitem");
    });

    $.ajax({
        "url": "application/topic/run_memodetail.php?action=memomemodetail&memoid=" + memo_id +'&topicid=' + topic_id,//&subjectid=" + subject_id +"
        "success": function(data){
            data = unescape(data);
			$("div#memo_block").show();
            $("div#memo_block").html(data).LoadLanguage({
            	language: current_language
            });
        }
    });
}

//Load MemoDetail for AllMemo when click it
function load_memodetail(memo_id, topic_id){//subject_id, 
	$('div#memo_block').show();
	//$('img#memo_loading').attr('src', 'images/loading1.gif');
	$('span#memo_loading').html('<img  src="images/loading1.gif" height="12px"/>');
	
	$("div.memoall ul.memoalllist li div.memoitem").each(function(){
        if($(this).attr("id") == memo_id) $(this).addClass("current_memoitem");
        else $(this).removeClass("current_memoitem");
    });

    $.ajax({
        "url": "application/topic/run_memodetail.php?action=memomemodetail&memoid=" + memo_id +'&topicid=' + topic_id,//&subjectid=" + subject_id +"
        "success": function(data){
            data = unescape(data);
			$("div#memo_block").show();
            $("div#memo_block").html(data).LoadLanguage({
            	language: current_language
            });
        }
    });
	load_memotopicdetail(topic_id)
}
//Load TopicDetail when click on MemoList
function load_memotopicdetail(topic_id){//subject_id, 
	$("div.menu:first").find("div.btn").removeClass("current");
	$("div.navigation_block ul.topiclist_block li").each(function(){
        if($(this).attr("id") == topic_id) $(this).addClass("current_topic");
        else $(this).removeClass("current_topic");
    });
	
	$("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");
    $.ajax({
        "url": "application/topic/run_topicdetail.php?action=topicdetail&topicid=" + topic_id, //&subjectid=" + subject_id + "&topicid=" + topic_id,
        "success": function(data){
            //alert(current_language);
			data = unescape(data);
            $("div.content:first").html(data).LoadLanguage({
                language: current_language
            });
			
			mylike = $('div#this_topic_like span.mylike').html();
			total_like = $('div#this_topic_like span.total_like').html();	
			total_like = parseInt(total_like);
			
						
			$("div.biznavi_like_button").likeButton({
                    islike  : (mylike == "true"),
					numlike : total_like,
                    likeword: "<span class='_language'>Like</span>",
                    onClick: function(like_result){
                        $("div.biznavi_like_button").LoadLanguage({
                            language: current_language
                        });
						like_topic(topic_id, like_result);
						display_like_topictitle(topic_id, like_result);
                    }
			});
			
			$("div.biznavi_like_button").LoadLanguage({
            	language: current_language
            });
			
        }
    });
	
	//$('div#memo_block').hide();
}
/*==Display Topic Detail===========================================================================================================================*/
function load_topic_detail(topic_id){//subject_id, 
	$("div.menu:first").find("div.btn").removeClass("current");
	$("div.navigation_block ul.topiclist_block li").each(function(){
        if($(this).attr("id") == topic_id) $(this).addClass("current_topic");
        else $(this).removeClass("current_topic");
    });
	
	$("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");
    $.ajax({
        "url": "application/topic/run_topicdetail.php?action=topicdetail&topicid=" + topic_id, //&subjectid=" + subject_id + "&topicid=" + topic_id,
        "success": function(data){
            //alert(current_language);
			data = unescape(data);
			hide_left();
            $("div.content:first").html(data).LoadLanguage({
                language: current_language
            });
			
			mylike = $('div#this_topic_like span.mylike').html();
			total_like = $('div#this_topic_like span.total_like').html();	
			total_like = parseInt(total_like);
			
						
			$("div.biznavi_like_button").likeButton({
                    islike  : (mylike == "true"),
					numlike : total_like,
                    likeword: "<span class='_language'>Like</span>",
                    onClick: function(like_result){
                        $("div.biznavi_like_button").LoadLanguage({
                            language: current_language
                        });
						like_topic(topic_id, like_result);
						display_like_topictitle(topic_id, like_result);
                    }
			});
			
			$("div.biznavi_like_button").LoadLanguage({
            	language: current_language
            });
			
        }
    });
	
	load_topic_memo(topic_id);
	$('div#memo_block').hide();
	
}
//like_topic
function like_topic(topic_id, like_value)
{
	$.ajax({
		url: 'application/topic/php_sub/p_liketopic.php?topicid=' + topic_id + '&like_value=' + like_value,
		success: function(){}
	});
}
//display_topic_like
function display_like_topictitle(topic_id, result)
{
	if(result=='like')
	{
		var topic_title = '<li id="' + topic_id + '" onclick="load_topic_detail(' + topic_id + ')">» ' + $("table#tb_topicdetail tr").find("td.topic_title").html() + '</li>'; 
		//onclick="load_topic_detail('.$this->topic_id.')"
		$('div#mylist  ul').append(topic_title);	
	}
	else if(result=='unlike')
	{
		$('div#mylist ul').find('li#' + topic_id).hide();
	}
}
/*==END Display Topic Detail===========================================================================================================================*/
/*==Display List Topic===========================================================================================================================*/
function load_listtopic(subject_id){
	
	//$('img#listtopic_loading').attr('src', 'images/loading1.gif');
	$('span#listtopic_loading').html('<img  src="images/loading1.gif" height="12px"/>');
	
    $.ajax({
        "url": "application/topic/run_topiclist.php?action=listtopic&subjectid=" + subject_id,
        "success": function(data){
			data = unescape(data);
            $("div.left div.navigation_block:first").html(data).LoadLanguage({
            	language: current_language
            });
            $("div.left div.navigation_block:first").blockNavigation({
                num_per_page: 5
            });
        }
    });
}
/*==END Display List Topic===========================================================================================================================*/
/**Delete Topic*************************************************************/
	function delete_topic(topic_id, subject_id)
	{
		var memodeletesms = $('#topicdeletemessage').html();
		var ok_del= confirm(memodeletesms);
		//var ok_del= confirm('Are you sure?\nYou want to delete this TOPIC!');
		if(ok_del)
		{
		$.ajax({
			url: 'application/topic/php_sub/p_topicdelete.php?topicid='	+ topic_id + '&subjectid=' + subject_id,
			success: function(data)
			{
				//alert(data);
				$('div#listtopic ul').find('li#' + topic_id).hide();
				$('div#mylist ul').find('li#' + topic_id).hide();
				$('table#tb_topicdetail').hide();
				$('div#topicdetail #banner_label').hide();
				load_subject_detail(subject_id);
				show_left();
			}
		});
		}
	}
/**END Delete Topic*************************************************************/
