<?php
    class Admin_support_online_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			// ../modules/ajaxhandle/models/ajax_support_online_model
			$this -> load -> model('ajax_support_online_model');
        }

        function Update_orders() {
        	$result = $this -> ajax_support_online_model -> Ajax_update_orders();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        function Update_publish() {
            $result = $this -> ajax_support_online_model -> Ajax_update_publish();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }
    }
?>