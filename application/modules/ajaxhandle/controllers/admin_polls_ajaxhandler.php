<?php
    class Admin_polls_ajaxhandler extends CMS_AdminController {
        function __construct(){
        	parent::__construct();
        	$this -> load -> model('administrator/polls_model');
        }

        public function Delete_poll() {

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = null;
        	if($this -> polls_model -> deletePoll($id)){
        		echo json_encode('1');
        	}else {
        		echo json_encode('0');
        	}
        }

        public function Delete_answer() {

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = null;
        	if($this -> polls_model -> deleteAnswer($id)){
        		echo json_encode('1');
        	}else {
        		echo json_encode('0');
        	}
        }

        public function Delete_poll_chk() {

            $this -> input -> post('Chk') ? $checkRows = $this -> input -> post('Chk') : $checkRows = 0;

            $arrayDeleted = array();

            if(!empty($checkRows)) {
                foreach ($checkRows as $IdPoll) {
                    $result = $this -> polls_model -> deletePoll($IdPoll);
                    if($result) {
                        $arrayDeleted[] = $IdPoll;
                    }
                }
            }

            echo json_encode(array("array" => $arrayDeleted,"msg" => "Đã xóa các bản ghi vĩnh viễn!"));

        }

        public function getAnswer() {
            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;

            $result = $this -> polls_model -> getAnswerById($id);

            if($result === false ) {
                $result['correct'] = 0;
            }else {
                $result['correct'] = 1;
            }

            echo json_encode($result);
        }

        public function addAnswer() {

            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;

            $result = $this -> polls_model -> insertAnswer($id);

            $result['correct'] = 1;

            if(isset($result['answerObj']) && $result['answerObj'] === false ) {
                $result['correct'] = 0;
            }

            echo json_encode($result);
        }

        public function updateAnswer() {
            $this -> input -> post('id') ? $id = $this -> input -> post('id') : $id = false;
            $this -> input -> post('idPoll') ? $idPoll = $this -> input -> post('idPoll') : $idPoll = false;

            $result = $this -> polls_model -> updateAnswer($id,$idPoll);

            if($result === false ) {
                $data['correct'] = 0;
            }else {
                $data['correct'] = 1;
                $data['pollChart'] = $result['pollChart'];
            }

            echo json_encode($data);
        }

        public function updateFinished() {

            $result = $this -> polls_model -> updateFinished();

            $a = '';

            $result ? $a = '1' : $a = '0';

            echo json_encode($a);
        }

    }
?>