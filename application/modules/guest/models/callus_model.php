<?php
	class Callus_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function check_input_fields() {
			$this -> input -> post('Name') ? $Name = $this -> input -> post('Name') : $Name = "";
			$this -> input -> post('Phone') ? $Phone = $this -> input -> post('Phone') : $Phone = "";
			$this -> input -> post('Email') ? $Email = $this -> input -> post('Email') : $Email = "";
			$this -> input -> post('Address') ? $Address = $this -> input -> post('Address') : $Address = "";
			$this -> input -> post('Content') ? $Content = $this -> input -> post('Content') : $Content = "";

			$data = array(
        				'Name' => $Name,
        				'Phone' => $Phone,
        				'Email' => $Email,
        				'Address' => $Address,
        				'Content' => $Content
        		);
        	return $data;
		}

		public function submit_callus() {
			$receivedata = $this -> check_input_fields();
			$data = array(
						'Name' => $receivedata['Name'],
						'Phone' => $receivedata['Phone'],
						'Email' => $receivedata['Email'],
						'Address' => $receivedata['Address'],
						'Content' => $receivedata['Content']
					);
			$this -> db -> insert('call_us',$data);

			if($this -> db -> affected_rows() > 0) {
				return true;
			}
			return false;
		}
	}
?>