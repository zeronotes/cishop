<?php
	class Contact_text_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAllTabs() {
			$selectClause = " select * from tabs_lienhe ";
			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$result = $result -> result_array();

				for ($i=0; $i < sizeof($result) ; $i++) {
					$result[$i]['lienhe_list'] = $this -> getAllByTabs($result[$i]['Id']);
				}

				return $result;
			}
			return array();
		}

		private function getAllByTabs($tabsId = false) {
			$selectClause = " select Id, Title, Title_en, Location, tabs_lienhe,Publish, Orders from noidung_lienhe where tabs_lienhe = ? ";

			$result = $this -> db -> query($selectClause,array($tabsId));

			if($result -> num_rows() > 0 ) {
				return $result -> result_array();
			}
			return array();
		}

		public function getById($id = false) {
			if($id !== false) {
				$selectClause = " select * from noidung_lienhe where Id = ? ";

				$result = $this -> db -> query($selectClause,array($id));

				if($result -> num_rows() > 0) {
					return $result -> row_array();
				}
			}
			return false;
		}

		private function check_contact_text_input_field() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";
			$this -> input -> post('Location') ? $Location = $this -> input -> post('Location') : $Location = "";
			$this -> input -> post('Content') ? $Content = $this -> input -> post('Content') : $Content = "";
			$this -> input -> post('Content_en') ? $Content_en = $this -> input -> post('Content_en') : $Content_en = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ?  $Orders = $this -> input -> post('Orders') : $Orders = 0 )  : $Orders = 999;
			$this -> input -> post('Publish') ? $Publish = $this -> input -> post('Publish') : $Publish = 0;
			$this -> input -> post('tabs_lienhe') ? $tabs_lienhe = $this -> input -> post('tabs_lienhe') : $tabs_lienhe = 0;

			$data = array(
						'Title' => $Title ,
						'Title_en' => $Title_en ,
						'Location' => $Location ,
						'Content' => $Content ,
						'Content_en' => $Content_en,
						'Orders' => $Orders ,
						'Publish' => $Publish,
						'tabs_lienhe' => $tabs_lienhe
					);
			return $data;
		}

		public function insert() {
			$receivedata = $this -> check_contact_text_input_field();
			$data = array(
					'Title' => $receivedata['Title'],
					'Title_en' => $receivedata['Title_en'],
					'Location' => $receivedata['Location'],
					'Content' => $receivedata['Content'],
					'Content_en' => $receivedata['Content_en'],
					'Orders' => $receivedata['Orders'],
					'Publish' => $receivedata['Publish'],
					'tabs_lienhe' => $receivedata['tabs_lienhe']
				);
			$this -> db -> insert("noidung_lienhe",$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function  updateOrders() {

			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id !== false && $orders !== false) {
				$data = array('Orders' => $orders );
				return $this -> db -> update('noidung_lienhe',$data,array('Id' => $id));
			}
			return false;

		}

		public function updatePublish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('publish') ? $publish = 1 : $publish = 0;
			if($id) {
				$data = array(	'Publish' => (int)$publish );

				return $this -> db -> update('noidung_lienhe',$data,array('Id' => $id));
			}

			return false;
		}

		public function update($id = 0) {
			$receivedata = $this -> check_contact_text_input_field();
			$data = array(
					'Title' => $receivedata['Title'],
					'Title_en' => $receivedata['Title_en'],
					'Location' => $receivedata['Location'],
					'Content' => $receivedata['Content'],
					'Content_en' => $receivedata['Content_en']

				);
			// 'Orders' => $receivedata['Orders'],
					// 'Publish' => $receivedata['Publish']
			return $this -> db -> update("noidung_lienhe",$data,array("Id" => $id));
		}

		public function delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('noidung_lienhe',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}

			return false;
		}
	}
?>
