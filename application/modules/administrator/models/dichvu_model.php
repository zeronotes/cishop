<?php
	class Dichvu_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			$selectClause = " select * from dich_vu where ".$whereClause." order by CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				$returnData['list'] = $result -> result_array();
                $returnData['count'] = $this -> getCountForAll();

                return $returnData;
			}
			return array();
		}

		public function getCountForAll($whereClause = " 1 = 1 ") {
			$selectClause = " select count(Id) as count from dich_vu where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();
				return $result['count'];
			}
			return 0;
		}

		public function getById($id = false) {
			$selectClause = " select * from dich_vu where Id = ? ";

			$result = $this -> db -> query($selectClause,$id);

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;
		}

		public function getDataFromClient() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";
			$this -> input -> post('ImageUrl') ? $ImageUrl = $this -> input -> post('ImageUrl') : $ImageUrl = "";
			$this -> input -> post('Link') ? $Link = $this -> input -> post('Link') : $Link = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ?  $Orders = $this -> input -> post('Orders') : $Orders = 999 )  : $Orders = 999;
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";
			$this -> input -> post('Description_en') ? $Description_en = $this -> input -> post('Description_en') : $Description_en = "";

			$data = array(
						'Title' => $Title ,
						'Title_en' => $Title_en ,
						'ImageUrl' => $ImageUrl ,
						'Link' => $Link ,
						'Orders' => $Orders ,
						'Publish' => $Publish ,
						'Description' => $Description ,
						'Description_en' => $Description_en
					);

			return $data;
		}

		public function insert() {
			$receivedata = $this -> getDataFromClient();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Title_en' => $receivedata['Title_en'] ,
						'ImageUrl' => $receivedata['ImageUrl'] ,
						'Link' => $receivedata['Link'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish'] ,
						'Description' => $receivedata['Description'] ,
						'Description_en' => $receivedata['Description_en'] ,
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('dich_vu',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function updatePublish($id = false) {
			$publish = $this -> input -> post('publish') ? 1 : 0;

			return $this -> db -> update('dich_vu',array('Publish' => (int)$publish),array('Id' => $id));
		}

		public function updateOrders($id = false) {

			$orders = $this -> input -> post('orders') ? $this -> input -> post('orders') : 999;

			return $this -> db -> update('dich_vu',array('Orders' => $orders),array('Id' => $id));
		}

		public function update($id = false) {
			$receivedata = $this -> getDataFromClient();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Title_en' => $receivedata['Title_en'] ,
						'ImageUrl' => $receivedata['ImageUrl'] ,
						'Link' => $receivedata['Link'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish'] ,
						'Description' => $receivedata['Description'] ,
						'Description_en' => $receivedata['Description_en'] ,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

			return $this -> db -> update('dich_vu',$data,array('Id' => $id));
		}

		public function delete($id = false) {
			$this -> db -> delete('dich_vu',array('Id' => $id));

			if($this -> db -> affected_rows() > 0) {
				return true;
			}
			return false;
		}
	}
?>