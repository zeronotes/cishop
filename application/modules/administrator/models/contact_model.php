<?php
	class Contact_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function contact_get_all($limit_start=false,$limit_show=false,$whereClause = " 1 = 1 ") {
			$selectClause = " select Id,Name,Email,Phone,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
							 (select count(Id) from contacts where ".$whereClause.") as count
								from contacts where ".$whereClause." order by CreatedDate desc limit ?,? ";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function contact_get_id($id = false) {
			if($id !== false) {
				$selectClause = " select Id,Name,Email,Phone,Address,Content
									from contacts where Id = ? ";

				$result = $this -> db -> query($selectClause,array($id));

				if($result -> num_rows() > 0) {
					return $result -> row_array();
				}
				return array();
			}else {
				show_404();
			}
		}

		public function contact_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('contacts',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function contact_text_get() {
			$result = $this -> db -> get("lien_he_text");
			return $result -> row_array();
		}

		private function check_contact_text_input_field() {
			$this -> input -> post('Content') ? $Content = $this -> input -> post('Content') : $Content = "";
			$this -> input -> post('Content_en') ? $Content_en = $this -> input -> post('Content_en') : $Content_en = "";

			$data = array(
						'Content' => $Content ,
						'Content_en' => $Content_en
					);
			return $data;
		}

		public function contact_text_update() {
			$receivedata = $this -> check_contact_text_input_field();
			$data = array(
					'Content' => $receivedata['Content'],
					'Content_en' => $receivedata['Content_en']
				);
			$this -> db -> update("lien_he_text",$data,array("Id" => 1));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}
	}
?>
