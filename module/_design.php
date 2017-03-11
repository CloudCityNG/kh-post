<?php
    //open head tag of the index page
    function index_head(){
        echo '<head>';
    }

    //close header of the index
    function index_head_end(){}

    //open head tag of sub page
    function sub_head(){}

    //close the head tag of sub page
    function sub_head_end(){
        echo '</head>';
    }

    //open body tag: in sub page only
    function sub_body(){
        echo '<body>';
        //echo '<div class="wrapper">';
			draw_header(getCurrentUserProfileName());
    }


    //open body tag: in sub:welcome page only-not login yet
    function sub_body_welcome(){
        echo '<body class="claro">';
			head_login();
    }

    //close body tag: in sub page only
    function sub_body_end(){
        //echo '</div>';//wrapper
        echo '</body>';
    }

	// draw header
	function draw_header($acc_name) {
		echo '
            <div class="header">
                <div class="image_home"><img class="image_home" style="top: -3px;" height=30 src="images/home.png" onclick="sethash(\'\');" /></div>
                <div class="menu">
                    <div class="btn _language" onclick="log_out();">Logout</div>
                    <div href="account" class="btn">' . $acc_name . '</div> <!-- onclick="show_my_profile();" -->
                    <div href="request" class="btn _language">My Request</div> <!-- onclick="show_my_request();" -->
                    <div href="memo" class="btn _language">Memo</div> <!-- onclick="load_memoalllist()" -->
                </div>
            </div>
		';
	}
	// draw footer
	function draw_footer() {
		echo '
			<table width="99%" style="padding:5px;margin: 0 auto;">
				<tr>
    				<td align="left" width="40%"><div class="text_footer" style=" margin-left:30px;" >bizNavi @ 2011</div></td>
                    <td align="center">
                        <select id="language_change" style="display: none;">
                            <option value="jp">Japanese</option>
                            <option value="en">English</option>
                        </select>
                    </td>
        			<td align="right" width="40%"><div class="text_footer" style=" margin-right:30px;"><label class="_language"> Power by</label>: <a 		  href="http://www.camitss.com/" style="text-decoration:none;">camitss</a></div></td>
    			</tr>
			</table>
		';
	}

	// header before login
	function head_login() {
		echo'
			<div class="header">
                <div class="image_home"><img class="image_home" style="top: -3px;" height=30 src="images/home.png" /></div>
            </div>
		';

	}


?>