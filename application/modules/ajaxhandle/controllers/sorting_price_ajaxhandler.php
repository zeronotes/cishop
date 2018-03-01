<?php
    class Sorting_price_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
        	// ../modules/ajaxhandle/models/ajax_news_categories_model
          	$this -> load -> model('sorting_price_model');	
        }

        function Update_Publish() {
        	$result = $this -> sorting_price_model -> Ajax_Update_Publish();
        	$a = '';
        	$result ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }

        function Update_Price() {
        	$result = $this -> sorting_price_model -> Ajax_Update_Price();
        	$a = '';
        	$result ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }
    }
?>