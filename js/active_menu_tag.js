// JavaScript Document
$(document).ready(function(){
	$("div.menu:first").find("div.btn").each(function(){
		$(this).click(function(){
            //$(this).siblings().removeClass("current");
            //$(this).addClass("current");
            sethash($(this).attr("href"));
		});
	});

    $("div.menu:first").LoadLanguage({
        language: current_language
    });
});


function focusMenu(order){
    $("div.menu:first").find("div.btn:nth-child(" + order + ")").addClass("current").siblings().removeClass("current");
}

function sethash(text){
    window.location.hash = text;
}

function gethash(){return window.location.hash.replace("#","");}

$(window).hashchange(function(){
    check_hash_change();
});

$(window).load(function(){
    /*url = window.location.toString();
    if(url.indexOf("#", 0) > 0 ){
        tmp = url.split("#");
        if(!tmp[1])
            window.location = tmp[0];
    }*/
    check_hash_change();
});


function check_hash_change(){
    var hash = gethash();
    hash = hash.split("&");
    if(hash[0]){
        switch(hash[0]){
            case "request": show_my_request(); break;
            case "account": show_my_profile(); break;
            case "subject": load_subject_detail(hash[1]); break;
			//*RUN
			case "topic": load_topic_detail(hash[1]); break;
			case "topicnew": load_newtopic(hash[1]); break;
			case "memo": load_memoalllist(); break;
			case "memodetail": load_memodetail(hash[1],hash[2]); break;
			case "topicmemodetail": load_memo(hash[1],hash[2]); break;
			case "userprofile": show_user_profile(hash[1]); break;
			//*END RUN
            default: load_home();
        }
    }
    else{
        url = window.location.toString();
        if(url.indexOf("#", 0) > 0 ){
            tmp = url.split("#");
            window.location = tmp[0];
        }
        load_home();
    }
}