<?php
    class Admin_xetnghiem_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
			$this -> load -> model('administrator/xetnghiem_model');
        }

        public function imageUpload() {
        	$data = $this -> Upload_Single_Image();
			echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function delete(){

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = null;
            if($this -> xetnghiem_model -> delete($id)){
                echo json_encode('1');
            }else {
                echo json_encode('0');
            }
        }
    }
?>