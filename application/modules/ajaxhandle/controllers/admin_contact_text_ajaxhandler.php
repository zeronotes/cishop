<?php
    class Admin_contact_text_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('administrator/contact_text_model');
        }

        public function imageUpload($element_name = false) {

            $data = $this -> Upload_Single_Image(false,false,$element_name);
            echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function getByid() {

            $id = $this -> input -> post('id') ? $this -> input -> post('id') : false;

            $result = $this -> contact_text_model -> getByid($id);

            $result = $result ? $result : '0';

            echo json_encode($result);
        }

        public function insert() {
            $result = $this -> contact_text_model -> insert();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function update(){

            $id = $this -> input -> post('id') ? $this -> input -> post('id') : false;
            $result = $this -> contact_text_model -> update($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updatePublish() {

            $result = $this -> contact_text_model -> updatePublish();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updateOrders() {

            $result = $this -> contact_text_model -> updateOrders();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function delete(){

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = 0;
            if($this -> contact_text_model -> delete($id)){
                echo json_encode('1');
            }else {
                echo json_encode('0');
            }
        }
    }
?>