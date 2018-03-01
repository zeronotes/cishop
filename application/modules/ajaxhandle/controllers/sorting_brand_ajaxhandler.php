<?php
    class Sorting_brand_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			// ../modules/ajaxhandle/models/sorting_brand_model
			$this -> load -> model('sorting_brand_model');
        }

        public function imageUpload() {
            $data = $this -> Upload_Single_Image();
            echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        function Update_Orders() {
        	$result = $this -> sorting_brand_model -> Ajax_Update_Orders();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_Publish() {
            $result = $this -> sorting_brand_model -> Ajax_Update_Publish();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_IsTop() {
            $result = $this -> sorting_brand_model -> Ajax_Update_IsTop();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        public function Delete() {
            $result = $this -> sorting_brand_model -> Ajax_Update_Publish();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Check_Title() {
            $result = $this -> sorting_brand_model -> Ajax_Check_Title();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Check_Title_Except() {
            $result = $this -> sorting_brand_model -> Ajax_Check_Title_Except();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }
    }
?>