<?php
    class Admin_faqs_ajaxhandler extends CMS_AdminController {
        function __construct(){
        	parent::__construct();
        	$this -> load -> model('administrator/faqs_model');
        }

        public function delete() {
        	$this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;
        	if($this -> faqs_model -> delete($id)){
        		echo json_encode('1');
        	}else {
        		echo json_encode('0');
        	}
        }

        public function updatePublish() {
        	$this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;
        	$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
        	if($this -> faqs_model -> updatePublish($id,$Publish)){
        		echo json_encode('1');
        	}else {
        		echo json_encode('0');
        	}
        }

        public function updateOrders() {
        	$this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;
        	$this -> input -> post('Orders') ? $Orders = $this -> input -> post('Orders') : $Orders = 999;
        	if($this -> faqs_model -> updateOrders($id,$Orders)){
        		echo json_encode('1');
        	}else {
        		echo json_encode('0');
        	}
        }
    }
?>
