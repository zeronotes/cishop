<?php
    class Admin_people_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('administrator/people_model');
        }

        public function imageUpload() {
        	$data = $this -> Upload_Single_Image();
			echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function updatePublish() {

            $id = $this -> input -> post('id');

            $result = $this -> people_model -> updatePublish($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updateOrders() {

            $id = $this -> input -> post('id');

            $result = $this -> people_model -> updateOrders($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function delete(){

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = null;
            if($this -> people_model -> delete($id)){
                echo json_encode('1');
            }else {
                echo json_encode('0');
            }
        }
    }
?>