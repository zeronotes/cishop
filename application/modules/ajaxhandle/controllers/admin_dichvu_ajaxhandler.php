<?php
    class Admin_dichvu_ajaxhandler extends CMS_AdminController {
        function __construct(){
        	parent::__construct();

        	$this -> load -> model('administrator/dichvu_model');
        }

        public function imageUpload() {
            $data = $this -> Upload_Single_Image();
            echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function delete() {

            $id = $this -> input -> post('id');

            $result = $this -> dichvu_model -> delete($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updatePublish() {

            $id = $this -> input -> post('id');

            $result = $this -> dichvu_model -> updatePublish($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

        public function updateOrders() {

            $id = $this -> input -> post('id');

            $result = $this -> dichvu_model -> updateOrders($id);

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }
    }

?>