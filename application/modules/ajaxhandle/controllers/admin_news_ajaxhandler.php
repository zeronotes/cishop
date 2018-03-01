<?php
    class Admin_news_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			// ../modules/ajaxhandle/models/ajax_categories_model
			$this -> load -> model('ajax_news_model');
        }

        public function Main_Image_Upload() {
        	$data = $this -> Upload_Single_Image();
			echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        function Update_Publish() {
            $result = $this -> ajax_news_model -> Ajax_Update_Publish();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_IsHot() {
            $result = $this -> ajax_news_model -> Ajax_Update_IsHot();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_IsBanner() {
            $result = $this -> ajax_news_model -> Ajax_Update_IsBanner();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_Orders() {
            $result = $this -> ajax_news_model -> Ajax_Update_Orders();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Check_Title() {
            $result = $this -> ajax_news_model -> Ajax_Check_Title();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Check_Title_Except() {
            $result = $this -> ajax_news_model -> Ajax_Check_Title_Except();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }
    }
?>