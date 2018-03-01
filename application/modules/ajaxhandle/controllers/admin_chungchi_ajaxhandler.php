<?php
    class Admin_chungchi_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('administrator/chungchi_model');
        }

        public function imageUpload($element_name = false) {

            $data = $this -> Upload_Single_Image(false,false,$element_name);
            echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function updatePublish() {

            $id = $this -> input -> post('id');

            $result = $this -> chungchi_model -> updatePublish($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updateOrders() {

            $id = $this -> input -> post('id');

            $result = $this -> chungchi_model -> updateOrders($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function delete(){

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = null;
            if($this -> chungchi_model -> delete($id)){
                echo json_encode('1');
            }else {
                echo json_encode('0');
            }
        }
    }
?>