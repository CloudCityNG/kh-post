<?php

    class like{
        public $topic_id;
        public $date_set;

        public function __construct(){}

        private function init_db(){
            require_once($_SERVER['DOCUMENT_ROOT'] . "module/module.php");
        }

        //get total user like
        public function getTotalUserLike(){
            $this->init_db();
            return getValue("SELECT COUNT(*) FROM tbl_like_topics WHERE topic_id = " . $this->topic_id);
        }

        //display like box
        public function show_like_box(){
            echo '
               <div class="like_box">
                    
                </div>
            ';
        }

    }

?>