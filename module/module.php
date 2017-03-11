<?php
    ob_start();
    if(!isset($_SESSION))@session_start();
    include($_SERVER['DOCUMENT_ROOT'] . "/biznavi/config/config.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/_design.php");


    define("VIEWER", 0);
    define("CUSTOMER", 1);
    define("RESEARCHER", 2);
    define("ADMINISTRATOR", 3);
    /*
     * Parameters note
     * ?page=report&subject_id=... => subject report
     *
     */

    $path = array(
            "welcome" => "application/login/login.php",
            "logout" => "application/login/logout.php",
            "signup" => "application/login/signup.php",
            "index" => "include/index.php",
            "policy" => "application/signup/policy.php",
            /*==RUN============================================================================*/
			"newtopic" => "application/topic/run_newtopic.php",
			"edittopic" => "application/topic/run_edittopic.php",
			"report" => "application/topic/run_topicreport.php"
	        /*==END RUN============================================================================*/
            );

    //random string
    function RandomString($length=20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
        $string = "";
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
      return $string;
    }

    //convert the escape html text in javascript to php
    function escapte_js_decrypt($string){
        return (urldecode($string));
    }

    function connectDB(){
	$cn=mysql_connect(HOST_NAME,USER_NAME,USER_PASSWORD) or die("Cannot connect to DB");
	$cn=mysql_select_db(DB_NAME) or die("cannot select database");
    }

    function runSQL($str){
    	connectDB();
    	mysql_query($str) or die("cannot execute statement: $str<br/>".mysql_error());
    }
    function getResultSet($str){
    	connectDB();
    	$rs=mysql_query($str) or die("cannot select: $str ".mysql_error());
    	return $rs;
    }
    function getValue($str){
    	$rs=getResultSet($str);
    	while ($row = mysql_fetch_array($rs,MYSQL_NUM)) {
    		return $row[0];
    	}
    }

    function getDateTime(){
    	return date("Y-m-d H:i:s");
    }
    function getToday(){
    	return date("Y-m-d");
    }
    function getTime(){
    	return date("H:i:s");
    }
    function randomID($tbname,$fname){
    	$val=random(0,1999999999);
    	while(getValue("select $fname from $tbname where $fname=$val")!=""){
    		$val=random(0,1999999999);
    	}
    	return $val;
    }
    function random($min,$max){
    	return rand($min,$max);
    }

    /* ----------------- Check Duplicate value in Database ------------------- */
    function isDuplicate($table_name, $field_name, $value, $type){
    	if($type == "string"){
    		$value = "'" . $value . "'";
    	}
    	$isduplicate = false;
    	if(getValue("SELECT * FROM " . $table_name . " WHERE " . $field_name . " = " . $value) != "")$isduplicate = true;
    	return $isduplicate;
    }

    function getCurrentUser(){
        if(isset($_SESSION['_user_09_09_2011_id']))
            $user_id = $_SESSION['_user_09_09_2011_id'];
        else $user_id = 0;
        return $user_id;
    }

    function getCurrentUserProfileName(){
        $user_id = getCurrentUser();
        $user_profile = "";
        if($user_id != 0){
            $user_profile = getValue("SELECT user_profile_name FROM tbl_users WHERE user_id = " . $user_id);
            if($user_profile == ""){
               $user_profile = getValue("SELECT user_name FROM tbl_users WHERE user_id = " . $user_id);
            }
        }
        return $user_profile;
    }

    function getUserType(){
        $user_id = getCurrentUser();
        $user_type = VIEWER;
        if($user_id != 0){
            $user_type = getValue("SELECT user_type_id FROM tbl_users WHERE user_id = " . $user_id);
        }
        return $user_type;

        //test
        //return RESEARCHER;
        //return CUSTOMER;
        //return VIEWER;
        //return ADMINISTRATOR;
    }

    function getUploadSize($id){
        $filesize=$_FILES[$id]['size'];
        return $filesize;
    }

    function upload($id, $path, $name = ""){
        $result=0;
    	//$allowtype=array("jpg","jpeg","gif","png");

    	$filename=$_FILES[$id]['name'];
    	$filename=str_replace("#","_",$filename);
    	$filename=str_replace("$","_",$filename);
    	$filename=str_replace("%","_",$filename);
    	$filename=str_replace("^","_",$filename);
    	$filename=str_replace("&","_",$filename);
    	$filename=str_replace("*","_",$filename);
    	$filename=str_replace("?","_",$filename);
    	$filename=str_replace(" ","_",$filename);
    	$filename=str_replace("!","_",$filename);
    	$filename=str_replace("@","_",$filename);
    	$filename=str_replace("(","_",$filename);
    	$filename=str_replace(")","_",$filename);
    	$filename=str_replace("/","_",$filename);
    	$filename=str_replace(";","_",$filename);
    	$filename=str_replace(":","_",$filename);
    	$filename=str_replace("'","_",$filename);
    	$filename=str_replace("\\","_",$filename);
    	$filename=str_replace(",","_",$filename);
    	$filename=str_replace("+","_",$filename);
    	$filename=str_replace("-","_",$filename);
    	$filesize=$_FILES[$id]['size'];
    	$filetype=end(explode(".",strtolower($filename)));
        if($name != "")$filename = $name . "." . $filetype;
    	/*if(!in_array($filetype,$allowtype)){
    		$result="2;";
    	}*/
    	if($filesize>$_POST['MAX_FILE_SIZE'] || $filesize==0){
    		$result="1;";
    	}
    	if($result==0){
    		//$subfolder=date("Y_m_d_H_i_s");
    		$path=$path . "/";
    		if(mkdir($path,0777,true));

            /*
            if(file_exists($path.$filename)){
              unlink($path.$filename);
            }
            */

    		if(move_uploaded_file($_FILES[$id]['tmp_name'],$path.$filename)){
    			$result=$result.";".$path.$filename;
    		}
    		else{
    			$result="3;";
    		}
    	}
    	return $result;
    }


    function display_icon($file_path){
        $image_file_extension = array("JPG", "JPEG", "GIF", "PNG");
        $document_file_extension = array("XLS" => "images/excel.png",
                                    "XLSX" => "images/excel.png",
                                    "DOC" => "images/word.png",
                                    "DOCX" => "images/word.png",
                                    "PPT" => "images/ppt.png",
                                    "PPTX" => "images/ppt.png",
                                    "PDF" => "images/pdf.png");

        $file_name = explode("/", $file_path);
        $file_name = $file_name[count($file_name)-1];
        $file_ext  = explode(".", $file_name);
        $file_ext  = $file_ext[count($file_ext)-1];
        $file_ext  = strtoupper($file_ext);
        if(in_array($file_ext, $image_file_extension)) return $file_path;
        else if(array_key_exists($file_ext, $document_file_extension)) return $document_file_extension[$file_ext];
        else return "images/file_blank.png";
    }


/***RUN Function**************************************************************************/////////////
function autoID($tbname,$fname){
	$q_id = getResultSet("SELECT $fname FROM $tbname");
	$id=0;
	while($ri = mysql_fetch_array($q_id))
	{
		$id=$ri[$fname];
	}
	return $id+1;
}

function getUrl($id){
	//$sub=ROOT;
    global $detail_page;
	$name=getValue("SELECT hotel_name FROM tbl_hotels where hotel_id=$id");
	if($name!=""){
		return "?mangoparam=".$detail_page."&id=".$id;
	}
	else{
		//return $sub."/".$name;
	}
}

function get_file_extension($file_name)
{
  return substr(strrchr($file_name,'.'),1);
}

function f_extension($fn){
$str=explode('/',$fn);
$len=count($str);
$str2=explode('.',$str[($len-1)]);
$len2=count($str2);
$ext=$str2[($len2-1)];
return $ext;
}

function Field($s){
	$rev="'".$s."'";
	return $rev;
}

function cutString($str,$numChar)
{
	if(strlen($str)>$numChar){$dot="...";} else{$dot="";}
	$str = substr($str,0, $numChar).$dot;
	return $str;
}

function createPageNavigator($my_total_page, $my_page_link) //, $my_pagesize, $cur_page, $my_page_link)
{

	if (isset($_GET['curP'])== null | isset($_GET['curP'])== " " | isset($_GET['curP'])== 0){ $cur_page = 1;}
	if (isset($_GET["curP"]) != null) { $cur_page = $_GET["curP"]; }

	echo "Page: ";
	if (($cur_page == 1) || ($my_total_page==0)){
		echo "";}
	else {
		echo '<a title="First" href="' . $my_page_link . '1" style="text-decoration:none;">
				<img align="absmiddle" src="images/nav_first.png"></img>
			 </a>'; //[First]</a>';
		echo '<a title="Previous" href="' . $my_page_link . ($cur_page - 1) . '" style="text-decoration:none;">
				<img align="absmiddle" src="images/nav_previous.png"></img>
			   </a>';//[Previous]</a> ';
	}
	// End of First Previous
	// Page Number
	for ($j=1; $j <= $my_total_page; $j++) {
		if ($j == $cur_page)
			echo " " . $j . " ";
		else
			echo ' <a href="' . $my_page_link . $j . '">' . $j . '</a> ' ;
	}
	// End of Page Number
	// Next Last
	if (($cur_page == $my_total_page) || ($my_total_page==0) )
		//echo " [Next] [Last] ";
		echo " ";
	else {
		echo '  <a title="Next" href="' . $my_page_link . ($cur_page + 1) . '" style="text-decoration:none;">
					<img align="absmiddle" src="images/nav_next.png" onmouseover="src=images/next_pressed.png"></img>
				</a>';//[Next]</a> ';
		echo '<a title="Last" href="' . $my_page_link . $my_total_page . '" style="text-decoration:none;">
					<img align="absmiddle" src="images/nav_last.png" onmouseover="src=images/last_pressed.png"></img>
			  </a>';//[Last]</a>';
	}
	// End of Next Last
}
// ***** End of Page Method *********


/***End RUN Function**************************************************************************/////////////

    //check session
    function check_session()
    {
        if(!isset($_SESSION['_user_09_09_2011_id']))echo "reload";
    }

?>