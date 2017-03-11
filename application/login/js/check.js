// JavaScript Document
function check_singup(){
    n=$("input#txtuser_name").val();
	p=$("input#txtuser_password").val();
	c=$("input#txtuser_con_password").val();
	if( n == "" || p == "" || c == ""){
		  //alert("please enter username, password, and confirm password first..!");
		  $("#signup_result").fadeIn(1).html("Enter username, password, and confirm password").fadeOut(2000);
		 // $("input#txtuser_name").isValid();
		  return false;
	}
	else if(p != c){
         $("#signup_result").fadeIn(1).html("Password not match").fadeOut(2000);
         return false;
   	}

	else{
        $.post(
            "application/login/insert.php",
            $("form#form_signup").serialize(),
            function(data){
                data = data.toString().trim();
                if(data == "1"){
                    $("#signup_result").fadeIn(1).html("User exists.").fadeOut(2000);
                }
                else{
                    window.location = data;
                }
            }
        );
    }
}
/*

function check_signup()
{
     n=$("input#txtuser_name").val();
	 p=$("input#txtpassword").val();
	 c=$("input#txtcon_password").val();

	if( n == "" || p == "" || c == ""){
		  //alert("please enter username, password, and confirm password first..!");
		  $("#signup_result").fadeIn(1).html("Enter username, password, and confirm password").fadeOut(2000);
		 // $("input#txtuser_name").isValid();
		  return false;
	}

	else if(p != c){
         $("#signup_result").fadeIn(1).html("Password not match").fadeOut(2000);
         return false;
   	}
	
	else{
    $.ajax({
        "url": "application/login/insert.php?username=" + $name,
        "success": function(result){
            result = result.toString().trim();
            if(result == "true"){
                $("#signup_result").fadeIn(1).html("Username already registered.").fadeOut(2000);
                //exist = true;
            }
            else {
                //exist = false;
            }
        }
    });
    if($("#signup_result").html() != ""){
        exist = true;
    }
    else exist = false;
    return exist;
	}
}*/