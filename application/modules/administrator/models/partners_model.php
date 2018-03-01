<?php
	class Partners_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			$selectClause = " select * from partners where ".$whereClause." order by Orders asc, CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getCountForAll($whereClause = ' 1 = 1 ') {
			$selectClause = " select count(Id) as count from partners where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;
		}

		public function getById($id = false) {
			$selectClause = " select * from partners where Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;

		}

		private function check_input_fields() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";
			$this -> input -> post('ImageUrl') ? $ImageUrl = $this -> input -> post('ImageUrl') : $ImageUrl = "";
			$this -> input -> post('Url') ? $Url = $this -> input -> post('Url') : $Url = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ? $Orders = $this -> input -> post('Orders') : $Orders = 999 ) : $Orders = 999 ;
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;

			$data = array(
						'Title' => $Title,
						'Title_en' => $Title_en,
						'ImageUrl' => $ImageUrl,
						'Url' => $Url,
						'Orders' => $Orders,
						'Publish' => $Publish
					);

			return $data;
		}

		public function insert() {
			$receivedata = $this -> check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Title_en' => $receivedata['Title_en'] ,
						'ImageUrl' => $receivedata['ImageUrl'] ,
						'Url' => $receivedata['Url'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => $receivedata['Publish'] ,
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('partners',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function update($id = false) {

			$receivedata = $this -> check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Title_en' => $receivedata['Title_en'] ,
						'ImageUrl' => $receivedata['ImageUrl'] ,
						'Url' => $receivedata['Url'] ,
						'Publish' => $receivedata['Publish'] ,
						'Orders' => $receivedata['Orders'] ,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

			return $this -> db -> update('partners',$data,array('Id' => $id));
		}

		public function updatePublish() {

			$id = $this -> input -> post('id');
			$publish = $this -> input -> post('Publish');
			if($publish !== false && $id !== false) {
				$data = array('Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				return $this -> db -> update('partners',$data,array('Id' => $id));
			}

			return false;
		}

		public function  updateOrders() {
			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id !== false && $orders !== false) {
				$data = array(
						'Orders' => $orders,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
				$this -> db -> update('partners',$data,array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		public function delete($id = false) {
			$this -> db -> delete('partners',array('Id' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}
	}
?>