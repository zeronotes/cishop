<?php
	class Recruitments_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Recruitments_get() {
			$selectClause = " select * from recruitments order by CreatedDate desc, ModifiedDate desc limit 1";

			$result = $this -> db -> query($selectClause);

			if($result !== false) {
				return $result -> row_array();
			}
			return false;
		}

		private function check_input_field() {
			$this -> input -> post('recruitmentBody') ? $Body = $this -> input -> post('recruitmentBody') : $Body = "";

			$data = array(
						'Body' => $Body ,
					);
			return $data;
		}

		public function Recruitment_update() {
			$receivedata = $this -> check_input_field();
			$data = array(
					'Description' => $receivedata['Body'],
					'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
					'ModifiedDate' => date('Y-m-d H:i:s', time())
				);
			$this -> db -> update("recruitments",$data,array("RecruitmentsID" => 1));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}
	}
?>