<?php
    class Admin_products_tags_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('ajax_products_tags_model');
        }

        function Update_Publish() {
            $result = $this -> ajax_products_tags_model -> Ajax_Update_Publish();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Update_Orders() {
            $result = $this -> ajax_products_tags_model -> Ajax_Update_Orders();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }
    }
?>