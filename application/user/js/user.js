function choose_profile_pic(){
    $("#user_profile_picture").trigger("click");
}
function init_profile(){
    $("#user_profile_picture").change(function(){
        var val = $(this).val();
        if(val != ""){
            $("form#form_upoad_picture").submit();
        }
    });

    $("#user_account").dialog({
        autoOpen: false,
        width: 350
    });
}

function check_upload_photo(){
    if($("#user_profile_picture").val() != "")return true;
    else return false;
}



function finish_save_profile_picture(src){
    //set the new image to the page
    $("#profile_image").attr("src", src);
}

function update_user(id){
    $.post("application/user/user.php?cmd=update&id=" + id, $("form#form_edit_user_info").serialize(), function(data){
        data = data.toString();
        if(data == "0"){
            $.ajax({
                url: "application/user/user.php?cmd=profile&id=" + id,
                success: function(data){
                    //alert(data);
                    $("#user_profile").html(data).LoadLanguage({
                        language: current_language
                    });
                    var new_profile_name = $("#user_profile table.info table.detail_info td.profile").html();
                    $("div.header:first div.menu div.btn:nth-child(2)").html(new_profile_name);
                }
            });

            $("div.user_detail table.info").next("div").hide();
        }
        else{
            alert($("div.user_detail div.head:first span.message").html());
        }
    });
}

function show_edit_profile(id){
    $.ajax({
        url: "application/user/user.php?cmd=edit_form&id=" + id,
        success: function(data){
            $("div.user_detail table.info").next("div").show();
            $("div.user_detail #detail_part").html(data).LoadLanguage({
                language: current_language
            });
        }
    });
}

function show_account_settings(id){
    $.ajax({
        url: "application/user/user.php?cmd=edit_account&id=" + id,
        success: function(data){
            $("#user_account").html(data).LoadLanguage({
                language: current_language
            });
            $("#user_account").dialog("open");

            $(".bClose").click(function(){
                $("#user_account").dialog("close");
            });
        }
    });
}

function save_account(id){
    var un = $("#username").val();
    var pass = $("#password").val();
    var new_pass = $("#new_password").val();
    var con_pass = $("#con_password").val();

    if(pass == "" || new_pass == "" || con_pass == "" || un == ""){
        return false;
    }
    if(con_pass != new_pass){
        alert($("#password_not_match").html());
        return false;
    }

    $.post("application/user/user.php?cmd=save_account", $("form#form_edit_account").serialize(),
    function(data){
        /*
        * result of data:
        * 1. invalid password
        * 2. username exist
        */

        if(data.toString() == "1"){
            alert($("#invalid_password").html());
        }
        else if(data.toString() == "2"){
            alert($("#username_exist").html());
        }
        else{
            $("#user_account").dialog("close");
        }
    });
}