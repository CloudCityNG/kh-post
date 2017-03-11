// JavaScript Document

$(document).ready(function(){
    $("#txtuser_name").keypress(function(e) {
        if(e.which == 13) {
            if($("#txtuser_password").val() != ""){
                check_login();
            }
            else{
                $("#txtuser_password").focus();
            }
        }
    });

    $("#txtuser_password").keypress(function(e) {
        if(e.which == 13) {
            if($("#txtuser_name").val() != ""){
                check_login();
            }
            else{
                $("#txtuser_name").focus();
            }
        }
    });

     $("div.content").LoadLanugage({
        language: current_language
    });
});



function check_login(){
    user_name = $("#txtuser_name").val();
    pass      = $("#txtuser_password").val();
    if(user_name == "" && pass == ""){
        return false;
    }
    else{
        $.ajax({
            url: "application/login/user_login.php?___u=" + user_name + "&___p=" + pass,
            success: function(result){
                if(result == "0"){
                    alert($("#invalid_user").html());
                }
                else{
                    //alert($("#home_page_url").html());
                    window.location = ""; //$("#home_page_url").html();
                }
            }
        });
    }

}