

//load the home page function
var current_language;
var language_items = [];
var screen_height;



$(window).resize(function(){
    set_left();
});

window.onfocus = function(e){
    if($("div.left").html() == null) return;
    $.ajax({
        url: "application/settings/camitss.php",
        success: function(data){
            if(data.toString() != "")window.location.reload();
        }
    });
}


function set_left(){
    var c_width  = $("div.template").width();
    var s_width  = $(window).width();
    var s_height = $(window).height();
    var h_height = $("div.header").height();


    var l;

    if(s_width > c_width){
        l = (s_width - c_width) /2;
    }
    else{
        l = 0;
    }

    $("div.content:first").css("height", s_height - h_height - 5);
    $("div.left").css("height", s_height - h_height - 5);
    $("div.right").css("height", s_height - h_height - 5);

    $("div.template").css("left", l);
    $("div.content:first").css("left", l);

}

function randomString(string_length) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function load_home(){

    current_language = "jp";
    $("div.menu div.btn").removeClass("current");

    $('#insert_subject').dialog({
    	autoOpen: false,
        width: 550,
    });

    $.ajax({
        "url": "application/content/leftbanner.php?action=home",
        "success" :function(data){
            data = unescape(data);
            //append data to left panel
            $("div.left").html(data);

            $("div.left").LoadLanguage({
                language: current_language
            });

            $("div.left div.navigation_block").each(function(){
                $(this).blockNavigation({
                    num_per_page: 5
                });
            });

        }
    });
    //end of left panel

    //load right panel
    $.ajax({
        "url": "application/content/rightbanner.php?action=home",
        "success" :function(data){
            data = unescape(data);
            //append data to left panel
            $("div.right").html(data);

            $("div.right").LoadLanguage({
                language: current_language
            });

            /*$("div.right div.language_block div.en").click(function(){
                ChangeLanguage("en");
            });
            $("div.right div.language_block div.jp").click(function(){
                ChangeLanguage("jp");
            });*/
        }
    });
    //end of right panel

    //load detail
    $("div#message_box_text").LoadLanguage({
        language: current_language
    });

    if($(".right_menu").html())$("#language_change").show();//determine whether user was logged in or not
    $("#language_change").change(function(){
        ChangeLanguage($(this).val());
    });

    $("div.content:first").html("");
    set_left();
    show_left();
}


function load_subject_detail(id){
	//RUN
	$("div.navigation_block ul.topiclist_block li").removeClass("current_topic");
	//END RUN
    $("div.menu:first").find("div.btn").removeClass("current");
    $("div.navigation_block ul.subject_list_block li").each(function(){
        if($(this).attr("id") == id) $(this).addClass("current");
        else $(this).removeClass("current");
    });

    //if($("div.content").find("div.subject_detail").length == 0){
    $("div.right").hide();
    if(true){
        $("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");

        //load full detail page
        $.ajax({
            "url": "application/subject/subject.php?action=detail&id=" + id,
            "success": function(data){
                data = unescape(data);
                //alert(current_language);

                sethash("subject&" + id);
                hide_left();

                $("div.content:first").html(data);
                //$('div.content').scrollbar();

                //set_scroll_content();
                //var report = $("#edit_subject_status option:selected").html();

				subject_report(id);

                $("#edit_subject_status").change(function(){
                    var txt = $(this).find("option:selected");
                    var val = txt.val();
                    txt = txt.find("span:nth-child(2)").html();
                });

                /*$("div.content").append("<div class='biznavi_like_button'></div>");
                $("div.biznavi_like_button").likeButton({
                    islike  : true,
                    numlike : 1,
                    likeword: "<span class='_language'>Like</span>",
                    onClick: function(like_result){

                        $("div.biznavi_like_button").LoadLanguage({
                            language: current_language
                        });
                    }
                });*/

                $("div.content:first").LoadLanguage({
                    language: current_language
                });

                $("select.edit_subject_status").change(function(){
                    $.ajax({
                        url: "application/subject/subject.php?action=changereport&id=" + $(this).attr("id") + "&val=" + $(this).val(),
                        success: function(data){
                        }
                    });
                });

            }
        });
        $("#loading_content").hide();
    }
    else{
        //load only subject information to make it look faster
        $.ajax({
            "url": "application/subject/subject.php?action=info&id=" + id,
            "success": function(data){
                //data = unscape(data);
                info = data.toString().split(";");
                var l = info.length;
                if(info[l-1] != 0){
                    $("div.subject_detail div.head span.delete").hide();
                }
                else{
                    $("div.subject_detail div.head span.delete").show();
                    $("div.subject_detail div.head span.delete").attr("onclick", "delete_subject(" + id + ")");
                }

                $("div.subject_detail div.head span.edit").attr("onclick", "edit_subject_form(" + id + ")");
                for(i = 1; i < info.length; i++){
                    info[i -1] = unescape(unescape(info[i-1]));
                    $("div.subject_detail table tr:nth-child(" + (i+1) + ") td:nth-child(3) span").html(info[i-1]);
                }

                $("select.edit_subject_status").LoadLanguage({
                    language: current_language
                });
            }
        });
    }

    load_listtopic(id);
    //hide_left();
}


function insert_subject_form(){
    $.ajax({
        url : "application/subject/subject.php?action=form_insert",
        success: function(data){
          $("#insert_subject").html('<form id="new_subject_form" action="application/subject/subject.php" method="POST"></form>');
            $('#insert_subject form#new_subject_form').html(data);

            var ln;
            if(current_language == "jp")ln = "ja";
            else ln = "";
            $("#txt_subject_due_date").datepick($.extend($.datepick.regional[ln]));


            $("#insert_subject").LoadLanguage({
                language: current_language
            });

            /*$('#insert_subject').bPopup({
                modal: true,
                modalClose : true,
                modalColor : "#e3e3e3",
                escClose : true,
                fadeSpeed: 100,
                opacity: 0.5
            });*/


            $("#insert_subject").dialog("option", "title", $("#InsertSubject_Title").html());
            $("#insert_subject").dialog("open");
            $(".bClose").click(function(){
                $("#insert_subject").dialog("close");
            });

            $("#subject_summary").cleditor();


            $("#save_subject").click(function(){
                var title = $("#txt_subject_title").val();
                if(title == ""){
                   alert($("span#InvalidTitle").html());
                   return false;
                }

                title = (title);
                $.post('application/subject/subject.php?action=save', $("#new_subject_form").serialize(), function(data) {
                        data=unescape(data);
                        $(".bClose").trigger("click");

                        $("div.left div.navigation_block").filter(".subjects").html(data).blockNavigation({
                            num_per_page: 5
                        });
                        $(".bClose").trigger("click");
                        $("div.left div.navigation_block").filter(".subjects").html(data).blockNavigation({
                            num_per_page: 5
                        });

                        $("div.left div.navigation_block").filter(".subjects").LoadLanguage({
                            language: current_language
                        });

                        $("div.left div.navigation_block").filter(".subjects").find("li:first").trigger("click");
    			});

            });
        }
    });
}
//end: display form insert

//edit subject form

//end: edit subject form
function edit_subject_form(target){
    $.ajax({
        url : "application/subject/subject.php?action=form_edit&target=" + target,
        success: function(data){
            data = unescape(data);
            $("#insert_subject").html('<form id="edit_subject_form" action="application/subject/subject.php" method="POST"></form>');
            $('#insert_subject form#edit_subject_form').html(data);

            /*$("#edit_subject_form").validate({
    			debug: false,
    			submitHandler: function(form) {
    				// do other stuff for a valid form

    			}
    		});*/

            var ln;
            if(current_language == "jp")ln = "ja";
            else ln = "";
            $("#txt_edit_subject_due_date").datepick($.extend($.datepick.regional[ln]));


            $("#insert_subject").LoadLanguage({
                language: current_language
            });

            /*$('#insert_subject').bPopup({
                modal: true,
                modalClose : true,
                modalColor : "#e3e3e3",
                escClose : true,
                fadeSpeed: 100,
                opacity: 0.5
            });
            */
            $("#insert_subject").dialog("option", "title", $("#EditSubject_Title").html());
            $("#insert_subject").dialog("open");
            $(".bClose").click(function(){
                $("#insert_subject").dialog("close");
            });

            $("#edit_subject_summary").cleditor();

            $("#save_subject").click(function(){
                var title = $("#txt_edit_subject_title").val();
                if(title == ""){
                   alert($("span#InvalidTitle").html());
                   return false;
                }
                $.post('application/subject/subject.php?action=update&target=' + target, $("#edit_subject_form").serialize(), function(data) {
                        $(".bClose").trigger("click");
                        data = unescape(data);
                        $("div.left div.navigation_block").filter(".subjects").html(data).blockNavigation({
                            num_per_page: 5
                        });
                        select_subject_in_block(target);
    			});
            });
        }
    });
}

//delete action
function delete_subject(target){
    if(confirm($("#ConfirmDeleteSubject").html())){
        //todo: delete subject
        $.ajax({
            url: "application/subject/subject.php?action=del&target=" + target,
            success: function(data){
                data = unescape(data);
                $("div.left div.navigation_block").filter(".subjects").html(data).find("li#" + target).remove();
                $("div.left div.navigation_block").filter(".subjects").blockNavigation({
                    num_per_page: 5
                });
                $("div.left div.navigation_block").filter(".subjects").LoadLanguage({
                    language: current_language
                });
                $("div.content:first").html("");
            }
        });
    }
}
//end: delete action

//trigger the subject select in list navigation block
function select_subject_in_block(id){
    $("div.left div.navigation_block").filter(".subjects").find("li#" + id).trigger("click");
}


//show my request
function show_my_request(){
    focusMenu(3);
    $("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");
    $.ajax({
        url: "application/subject/subject.php?action=myrequest",
        success: function(data){
            data = unescape(data);
            //alert(data);
            $("div.content:first").html(data).LoadLanguage({
                language: current_language
            });
            //$(".scrollbar").scrollbar();
        }
    });
    $("div.right").hide();
}//end: show my request


//show my account
function show_my_profile(){
    focusMenu(2);
    $("div.content:first").html("<img style='width: 100%;height: auto; margin: auto;' src='images/loading.gif' />");
    $.ajax({
        url: "application/user/profile.php",
        success: function(data){
            $("div.content:first").html(data);
            //$(".scrollbar").scrollbar();
            $("div.content:first").LoadLanguage({
                language: current_language
            });


        }
    });
    $("div.right").hide();
}
//end: my account


//logout
function log_out(){
    window.location = "application/login/logout.php";
}
//end: log out

//hide left banner
//var left_width = "26%";
//var content_width = "44%";

function hide_left(){
    var divleft = $("div.left:first");
    var divcontent = $("div.content:first");

    //left_width  = divleft.css("width");
    //content_width = divcontent.css("width");


    //divleft.animate({left: "-" + left_width});
    divleft.find("div.navigation_block").hide();

    //new_width = parseInt(left_width.replace("px", "")) + parseInt(content_width.replace("px", ""));
    //alert(new_width);
    divcontent.css("width", "69%");

    divleft.css("width", "1%");
    divleft.find("div.hide_left").attr("onclick", "show_left()").css("background-image", "url(images/arrow_right.png)").css("left", "1%");
}

function show_left(){
    var divleft = $("div.left:first");
    var divcontent = $("div.content:first");
    divleft.find("div.navigation_block").show();
    divleft.find("div.hide_left").attr("onclick", "hide_left()").css("background-image", "url(images/arrow_left.png)").css("left", "26%");
    divleft.css("width", "26%");
    divcontent.css("width", "44%");
}