<?php
    /*
    * This class is used to design and access to database for tbl_topic
    * Creator: Loch Khemarin
    * Date Created: Sep-07-2011
    */
    class topic{
        private $topic_id;
        private $topic_title;
        private $topic_summary;
		private $topic_detail;
		private $topic_url;
        private $topic_created_date;
		private $user_id;
		private $user_name;
		private $topic_author;

        public function __construct($id = ""){
            $this->topic_id = $id;
            $this->topic_title = "";
            $this->topic_summary = "";
			$this->topic_detail = "";
			$this->topic_url = "";
            $this->topic_created_date = "";
			$this->topic_author= "";
			$this->user_id = 0;
			$this->user_name = "NO Name";
			
        }

        private function initDb(){
            require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
        }
		//get user from db
		public function getUserName(){
			//$this->user_id = getCurrentUser();
            $this->initDb();
            if($this->getUserID()!= 0){
                $this->user_name = getValue("SELECT user_profile_name FROM tbl_users AS U
												INNER JOIN tbl_user_topics AS T ON T.user_id = U.user_id
											 	WHERE topic_id = " . $this->topic_id);
            }
            return $this->user_name;
        }
		public function getUserID(){
            $this->initDb();
            //if($this->user_id!= 0){
                $this->user_id = getValue("SELECT user_id FROM tbl_user_topics WHERE topic_id = " . $this->topic_id);
            //}
            return $this->user_id;
        }
		//get topic author from db
		public function getTopic_Author(){
            $this->initDb();
            if($this->topic_id!= ""){
                $this->topic_author = urldecode(getValue("SELECT topic_author FROM tbl_topics WHERE topic_id = " . $this->topic_id));
            }
            return $this->topic_author;
        }

        //get topic title from db
        public function getTopic_Title(){
            $this->initDb();
            if($this->topic_id != ""){
                $this->topic_title = urldecode(getValue("SELECT topic_title_2nd FROM tbl_topics WHERE topic_id = " . $this->topic_id));//stripslashes($topic_detail);
				
				if ($this->topic_title == "" || $this->topic_title==null){
					$this->topic_title = urldecode(getValue("SELECT topic_title FROM tbl_topics WHERE topic_id = " . $this->topic_id));
				}
            }
            return $this->topic_title;
        }

        //get topic summary from db
        public function getTopic_Summary(){
            $this->initDb();
			$summary = "";
            if($this->topic_id != ""){
                $this->topic_summary = urldecode(getValue("SELECT topic_summary_2nd FROM tbl_topics WHERE topic_id = " . $this->topic_id));
				$summary = strlen(strip_tags($this->topic_summary));
				//if ($this->topic_summary == "" || $this->topic_summary==null){
				if($summary==0){
					$this->topic_summary = urldecode(getValue("SELECT topic_summary FROM tbl_topics WHERE topic_id = " . $this->topic_id));
				}
            }
            return $this->topic_summary;
        }
		
		//get topic detail from db
		public function getTopic_Detail(){
            $this->initDb();
            if($this->topic_id != ""){
                $this->topic_detail = urldecode(getValue("SELECT topic_detail FROM tbl_topics WHERE topic_id = " . $this->topic_id));
            }
            return $this->topic_detail;
        }
		
		//get topic url from db
		public function getTopic_Url(){
            $this->initDb();
            if($this->topic_id != ""){
                $this->topic_url = urldecode(getValue("SELECT topic_url FROM tbl_topics WHERE topic_id = " . $this->topic_id));
            }
            return $this->topic_url;
        }

        //get topic created date from db
        public function getCreatedDate(){
            $this->initDb();
            if($this->topic_id != ""){
                $this->topic_created_date = getValue("SELECT topic_add_date FROM tbl_topics WHERE topic_id = " . $this->topic_id);
            }
            return $this->topic_created_date;
        }
		
		//get topic Files from db
		public function getTopicFiles(){
			$attached_type= 2; //for topic files
			$files = "";
            $this->initDb();
            if($this->topic_id != ""){
                $q_topic_files = getResultSet("SELECT attached_path FROM tbl_attached
								WHERE attach_type_id =".$attached_type." AND source_id=".$this->topic_id);
				$count_file = mysql_num_rows($q_topic_files);
				//if($count_file==0){ return 'N/A';}
				/**will be removed******************************************/
				/*				
				if($count_file==0){ 
				return
				'<tr>'
					.'<td class="topicdetail_label"><span class="title _language">Files :</span></td>'
					.'<td>'.'N/A'.'</td>'.
				'</tr>';
				}
				*/				
				/********************************************/
				
				while($rf = mysql_fetch_array($q_topic_files))
				{
                	$file_path = $rf['attached_path'];
					$files = $files.'<a href="'.$file_path.'" target="_new">'.$file_path. '<br/>';
            	}
				/*
				return
				'<tr>'
					.'<td class="topicdetail_label"><span class="title _language">Files :</span></td>'
					.'<td>'.$files.'</td>'.
				'</tr>';
				*/
            }
        }

        //show list block navigation
        public function display_ListTopic(){//$subject_id=""
			$user_id = getCurrentUser();
			//$subject_id = $_GET['subjectid'];
			if(getUserType()==CUSTOMER){
				$total_memo = getValue("SELECT COUNT(memo_id) FROM tbl_memos WHERE user_id=".$user_id." AND source_id=".$this->topic_id);
			}
			elseif(getUserType()==ADMINISTRATOR || getUserType()==RESEARCHER)
			{
				$total_memo = getValue("SELECT COUNT(memo_id) FROM tbl_memos WHERE source_id=".$this->topic_id);
			}
			
            echo '<li id="' . $this->topic_id . '" onclick="sethash(\'topic&' . $this->topic_id . '\')">';//'.$subject_id.', onclick="load_topic_detail('.$this->topic_id.')"
                echo '» '.$this->getTopic_Title().' ('.$total_memo.')';
            echo '</li>';
        }
		
		//show My List
        public function display_MyList(){
			$user_id = getCurrentUser();
			//$total_memo = getValue("SELECT COUNT(memo_id) FROM tbl_memos WHERE user_id=".$user_id." AND source_id=".$this->topic_id);
			if(getUserType()==CUSTOMER){
				$total_memo = getValue("SELECT COUNT(memo_id) FROM tbl_memos WHERE user_id=".$user_id." AND source_id=".$this->topic_id);
			}
			elseif(getUserType()==ADMINISTRATOR || getUserType()==RESEARCHER)
			{
				$total_memo = getValue("SELECT COUNT(memo_id) FROM tbl_memos WHERE source_id=".$this->topic_id);
			}
			
			
            echo '<li id="' . $this->topic_id . '" onclick="sethash(\'topic&' . $this->topic_id . '\')">';//onclick="load_topic_detail('.$this->topic_id.')"
                echo '» '.$this->getTopic_Title().' ('.$total_memo.')';
            echo '</li>';
        }
		
		//show report
		public function display_Report1($i){//$subject_id=""
			$user_id = getCurrentUser();
			//$subject_id = $_GET['subjectid'];
			echo '<table class="list_report" id="tb_report" border="0" bordercolor="#F00" cellspacing="1" width="100%" onclick="sethash(\'topic&' . $this->topic_id . '\')">';//onclick="load_topic_detail('.$this->topic_id.')"								
				echo '<tr>';
					echo '<td class="no" rowspan="2">'.$i.'</td>';
					echo '<td class="report_title">'.$this->getTopic_Title().'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="2" class="report_desc">'.$this->getTopic_Summary().'</td>';
				echo '</tr>';
			echo '</table>';
			//**********************************************/
			/*
            echo '<li id="' . $this->topic_id . '" onclick="load_topic_detail('.$this->topic_id.')">';//'.$subject_id.',
                echo '» '.$this->getTopic_Title();
            echo '</li>';
			*/
        }
		public function display_Report2($i){//$subject_id=""
			$user_id = getCurrentUser();
			//$subject_id = $_GET['subjectid'];
			echo '<table class="list_report1" id="tb_report" border="0" bordercolor="#F00" cellspacing="1" width="100%" onclick="sethash(\'topic&' . $this->topic_id . '\')">';								
				echo '<tr>';
					echo '<td class="no" rowspan="2">'.$i.'</td>';
					echo '<td class="report_title">'.$this->getTopic_Title().'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="2">'.$this->getTopic_Summary().'</td>';
				echo '</tr>';
			echo '</table>';
        }
		
		public function display_Memo(){
            echo '<li id="' . $this->topic_id . '" onclick="load_topic_detail('.$this->topic_id.')"><img src="images/tick_mylist.png"/>';
                echo $this->getTopic_Title();
            echo '</li>';
        }
		
		public function display_TopicDetail(){
		echo '<table id="tb_topicdetail" border="0" bordercolor="#FFF" cellspacing="1" width="100%">';								
			echo '<tr>';
				//echo 'User'.$this->getUserID();
				echo '<td class="topicdetail_label"><span class="_language">Title</span>&nbsp;:</td>';
				echo '<td class="topic_title">'.$this->getTopic_Title().'</td>';
			echo '</tr>';
			if(getUserType()!=CUSTOMER){
			echo '<tr>';
				echo '<td class="topicdetail_label"><span class="_language">Researcher</span>&nbsp;:</td>';
				echo '<td><span class="topicowser_link_user_profile" onclick="sethash(\'userprofile&' . $this->getUserID() . '\')">'.$this->getUserName().'</span>'.'<span class="datetime">'.$this->getCreatedDate().'</span></td>';
				//echo '<td><a href="#" onclick="sethash(\'userprofile&' . $this->getUserID() . '\')">'.$this->getUserName().'</a>'.'<span class="datetime">'.$this->getCreatedDate().'</span></td>';//onclick="show_user_profile('.$this->getUserID().')"
				//echo '<br/>User_Af'.$this->getUserID();
			echo '</tr>';
			}
			if($this->getTopic_Author()!=null || $this->getTopic_Author()!=""){
			echo '<tr>';
				echo '<td class="topicdetail_label"><span class="_language">Author</span>&nbsp;:</td>';
				echo '<td>'.$this->getTopic_Author().'</td>';
			echo '</tr>';
			}
			
			if($this->getTopic_Summary()!=null || $this->getTopic_Summary()!=""){
			echo '<tr>';
				echo '<td class="topicdetail_label"><span class="_language">Summary</span>&nbsp;:</td>';
				echo '<td>'.$this->getTopic_Summary().'</td>';
			echo '</tr>';
			}
			
			if($this->getTopic_Url()!=null || $this->getTopic_Url()!=""){
			echo '<tr>';
				echo '<td class="topicdetail_label"><span class="_language">Source</span>&nbsp;:</td>';
				echo '<td><a href="'.$this->getTopic_Url().'" target="_new">'.cutString($this->getTopic_Url(),60).'</a></td>';
			echo '</tr>';
			}
			
			$topic_detail = strlen(strip_tags($this->getTopic_Detail()));
			//if($this->getTopic_Detail()!=null || $this->getTopic_Detail()!=""){
			if($topic_detail!=0){
				echo '<tr bordercolor="#FAFAFA" >';
					echo '<td class="topicdetail_label" bordercolor="#FAFAFA"><span class="_language">Details</span>&nbsp;:</td>';
				echo '</tr>';
				
				echo '<tr bordercolor="#FAFAFA">';
					echo '<td colspan="2" bordercolor="#FAFAFA">'.$this->getTopic_Detail().'</td>';
				echo '</tr >';
			}
			
			
			
			echo $this->getTopicFiles();
			/*
			echo '<tr>';
				echo '<td class="topicdetail_label"><span class="title _language">Files :</span></td>';
				echo '<td>'.$this->getTopicFiles().'</td>';
			echo '</tr>';
			*/
		echo '</table>';
        }

    }
?>