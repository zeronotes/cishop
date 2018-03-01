<?php
    class Admin_menu_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			// ../modules/ajaxhandle/models/ajax_menu_model
			$this -> load -> model('ajax_menu_model');
        }

        public function imageUpload() {
            $data = $this -> Upload_Single_Image();
            echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        function Get_NewsCate() {
            $result = $this -> ajax_menu_model -> Ajax_Get_NewsCate();

            echo json_encode($result);
        }

        function Get_News() {
            $result = $this -> ajax_menu_model -> Ajax_Get_News();

            echo json_encode($result);
        }

        function Get_ProdCate() {
            $result = $this -> ajax_menu_model -> Ajax_Get_ProdCate();

            echo json_encode($result);
        }

        function Get_Prod() {
            $result = $this -> ajax_menu_model -> Ajax_Get_Prod();

            echo json_encode($result);
        }

        function Update_NewTab() {

            $result = $this -> ajax_menu_model -> Ajax_Update_NewTab();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);

        }

        function Update_Publish() {

        	$result = $this -> ajax_menu_model -> Ajax_Update_Publish();

        	$a = '';

        	$result ? $a = '1' : $a = '0';

        	echo json_encode($a);

        }

        function Update_IsClick() {

            $result = $this -> ajax_menu_model -> Ajax_Update_IsClick();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);

        }

        function Update_Orders() {

        	$result = $this -> ajax_menu_model -> Ajax_Update_Orders();

        	$a = '';

        	$result ? $a = '1' : $a = '0';

        	echo json_encode($a);

        }
    }
?>