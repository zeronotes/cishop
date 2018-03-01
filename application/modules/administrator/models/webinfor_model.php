<?php
	class Webinfor_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_Information() {
			$result = $this -> db -> get("webinfor");
			return $result -> row_array();
		}


		/*** FOOTER ****/
		private function check_input_field() {
			$this -> input -> post('footerBody') ? $Footer = $this -> input -> post('footerBody') : $Footer = "";
			$this -> input -> post('footerBody_en') ? $Footer_en = $this -> input -> post('footerBody_en') : $Footer_en = "";
			$this -> input -> post('contactText') ? $contactText = $this -> input -> post('contactText') : $contactText = "";
			$this -> input -> post('contactText_en') ? $contactText_en = $this -> input -> post('contactText_en') : $contactText_en = "";
			$this -> input -> post('footerEmail') ? $EmailForm = $this -> input -> post('footerEmail') : $EmailForm = "";

			$data = array(
						'Footer' => $Footer ,
						'Footer_en' => $Footer_en ,
						'ContactText' => $contactText,
						'ContactText_en' => $contactText_en,
						'EmailForm' => $EmailForm
					);
			return $data;
		}

		public function Footer_update() {
			$receivedata = $this -> check_input_field();
			$data = array(
					'Footer' => $receivedata['Footer'],
					'Footer_en' => $receivedata['Footer_en'],
					'ContactText' => $receivedata['ContactText'],
					'ContactText_en' => $receivedata['ContactText_en'],
					'EmailForm' => $receivedata['EmailForm'],
				);
			$this -> db -> update("webinfor",$data,array("WebInfoID" => 1));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}
		/*** END FOOTER ****/

		/***** WEBINFOR ****/

		public function getBanner($columnName = false) {
			$selectClause = " select ".$columnName." as ImageUrl from webinfor where WebInfoID = 1 ";
			$result = $this -> db -> query($selectClause);

			return $result -> row_array();
		}

		public function updateBanner($columnName = false,$data = false) {
			return $this -> db -> update('webinfor',array($columnName => $data),array('WebInfoID' => 1));
		}

		public function getGioiThieu() {
			$selectClause = " select Gioithieu,Gioithieu_en,LinkVideoGioithieu,LinkDetailGioiThieu from webinfor where WebInfoID = 1 ";
			$result = $this -> db -> query($selectClause);

			return $result -> row_array();
		}

		/****
		***** @param array() : $data => mang chua du lieu can de update vao db
		*****/
		public function updateGioiThieu($data = array()) {
			if(!empty($data)) {
				return $this -> db -> update('webinfor',$data,array('WebInfoID' => 1));
			}else {
				return false;
			}
		}
	}
?>