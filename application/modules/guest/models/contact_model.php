<?php
	class Contact_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}
		public function contact_text_get() {
			$selectClause = " select * from lien_he_text limit 1 ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;
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

		public function submit_contact() {
			$receivedata = $this -> check_input_fields();
			$data = array(
						'Name' => $receivedata['Name'],
						'Phone' => $receivedata['Phone'],
						'Email' => $receivedata['Email'],
						'Address' => $receivedata['Address'],
						'Content' => $receivedata['Content']
					);
			$this -> db -> insert('contacts',$data);

			if($this -> db -> affected_rows() > 0) {
				// $Body = "Họ tên : <b>".$receivedata['Name']."</b><br/>";
				// $Body .= "Điện thoại : <b>".$receivedata['Phone']."</b><br/>";
    //             $Body .= "Email : <b>".$receivedata['Email']."</b><br/>";
    //             $Body .= "Địa chỉ : <b>".$receivedata['Address']."</b><br/>";
    //             $Body .= "Nội dung liện hệ : <br/><b>".$receivedata['Content']."</b><br/>";

    //             $this -> load -> model('administrator/config_model');

    //             $config = $this -> config_model -> get_configs();

    //             $this -> auto_send_mail("Thông tin liên hệ của : ".$receivedata['Name'], $Body, $config['EmailForAutoSend']);

				return true;
			}
			return false;
		}
	}
?>