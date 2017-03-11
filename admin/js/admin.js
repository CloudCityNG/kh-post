function init_admin(){
    show_user_list();
    $("div#popup_1").dialog({
        autoOpen: false,
        width:  350
    });

    $("#admin_msg").LoadLanguage({
        language: current_language
    });
}

function show_edit_category(id, t1, t2){
    dijit.byId("form_admin_add_category").attr("title", "Edit Category");
    dijit.byId("form_admin_add_category").set("href", "application/category/category.php?admin=show_edit&id=" + id + "&t1=" + t1 + "&t2=" + t2);
    dijit.byId("form_admin_add_category").show();
}

function show_add_category(){
    dijit.byId("form_admin_add_category").attr("title", "Add Category");
    dijit.byId("form_admin_add_category").set("href", "application/category/category.php?admin=add");
    dijit.byId('form_admin_add_category').show();
}

function show_category(data){
    $("#category_list").html(data);

    $("div.category_list div.category_row span").hide();

    $("div.category_list div.category_row").mouseover(function(){
        $(this).find("span").fadeIn(60);
    });

    $("div.category_list div.category_row").mouseleave(function(){
        $(this).find("span").fadeOut(60);
    });

    $("div.category_list div.category_row span").click(function(){
        var id = $(this).siblings("label").attr("id");
        var action = $(this).html().toString();
        if(action == "Edit"){
            var text1 = $(this).siblings("label").html().split("/");
            var text2 = text1[1];
            text1 = text1[0];
            show_edit_category(id, text1, text2);
        }
        else if(action == "Delete"){
            if(confirm("Are you sure?")){
                $.ajax({
                    "url" : "application/category/category.php?admin=delete&id=" + id,
                    "success": function(data){
                        show_category(data);
                    }
                });
            }
        }

    });

}



function admin_show_edit_user(id){
    $.ajax({
        url: "application/user/user.php?cmd=admin_edit&id=" + id,
        success: function(data){

            $("div#popup_1").html(data);

            $("div#popup_1").LoadLanguage({
                language: current_language
            });

            $("#popup_1").dialog("option", "title", $("#edit_user_title").html());
            $("div#popup_1").dialog("open");
            $(".bClose").click(function(){
                $("#popup_1").dialog("close");
            });
        }
    });
}

function show_add_user(){
    $.ajax({
        url: "application/user/user.php?cmd=add_user",
        success: function(data){

            $("div#popup_1").html(data);
            $("div#popup_1").LoadLanguage({
                language: current_language
            });

            $("#popup_1").dialog("option", "title", $("#new_user_title").html());
            $("div#popup_1").dialog("open");
            $(".bClose").click(function(){
                $("#popup_1").dialog("close");
            });
        }
    });
}

function add_user(){
    var un   = dijit.byId("txt_new_user").value;
    var type = dijit.byId("add_user_type").value;
    var ps   = dijit.byId("txt_new_password").value;
    var cps  = dijit.byId("txt_new_confirm_password").value;

    if(ps != cps){
        alert("Password not match.");
        return false;
    }

    if(un == "" || ps == ""){
        alert("Username and password required.");
        return false;
    }

    $.ajax({
        "url" :"application/user/user.php?cmd=add_user&save=CLkrkma_9c&un=" + un + "&type=" + type + "&ps=" + ps,
        "success": function(data){
            data = trim(data.toString());
            if(data.indexOf("error_ax2ml", 0) >= 0){
                alert("Username exist.");
            }
            else{
                dijit.byId("form_admin_edit_user").hide();
                show_user_list();
            }
        }
    });
}

function show_user_list(){
     $("table.lst_user span:nth-child(3)").click(function(){
            var id = $(this).siblings("span:first").attr("id");
            var action = $(this).html().replace("[","").replace("]","");
            //delete user

                if(confirm($("div#admin_msg span#confirm_delete_user").html())){
                    $.ajax({
                        "url": "application/user/user.php?cmd=delete&id=" + id,
                        "success" :function(){
                            $("table.lst_user").find("span#" + id).closest("tr").remove();
                        }
                    });
                }
    });

    $("table.lst_user").dataTable( {
	"oLanguage": {
		"sLengthMenu": "Display _MENU_ records per page",
		"sZeroRecords": "Nothing found - sorry",
		"sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
		"sInfoEmpty": "Showing 0 to 0 of 0 records",
		"sInfoFiltered": "(filtered from _MAX_ total records)"
	}
});
}


function save_user(id){
    value = $("#edit_user_type").val();
    enable = $("#user_enable").attr("checked");

    if(enable)enable = 1;
    else enable = 0;

    $.ajax({
        "url": "application/user/user.php?cmd=admin_edit&id=" + id + "&type=" + value + "&enable=" + enable + "&savv=_user_TYPE",
        "success" :function(data){
            $(".bClose").trigger("click");
            node = $("table.lst_user").find("span#" + id).parent().prev();
            node.html(data);
            node.parent().LoadLanguage({languge: current_language});
        }
    });
}

function save_new_user(){
    un = $("#txt_new_user").val();
    ps = $("#txt_new_password").val();
    cn = $("#txt_new_confirm_password").val();
    t = $("#add_user_type").val();

    if(un == ""){
        alert($("#confirm_invalid_username").html());
        return false;
    }
    else if(ps == ""){
        alert($("#confirm_invalid_password").html());
        return false;
    }
    else if(ps != cn){
        alert($("#confirm_password_not_match").html());
        return false;
    }
    $.ajax({
        url: "application/user/user.php?cmd=add_user&save=sac4_C&___un=" + un + "&___ps=" + ps + "&___t=" + t,
        success: function(data){
            if(data.toString() != "1"){
                $("div.user_table_wrapper").html(data);
                show_user_list();
                $("div.user_table_wrapper").LoadLanguage({
                    language: current_language
                });
                $(".bClose").trigger("click");
            }
            else{
                alert($("#user_name_exist").html());
            }
        }
    });
}