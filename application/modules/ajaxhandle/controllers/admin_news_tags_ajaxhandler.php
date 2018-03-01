<?php
    class Admin_news_tags_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('ajax_news_tags_model');
        }

        function Update_Publish() {
            $result = $this -> ajax_news_tags_model -> Ajax_Update_Publish();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_Orders() {
            $result = $this -> ajax_news_tags_model -> Ajax_Update_Orders();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }
    }
?>