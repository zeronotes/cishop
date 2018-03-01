<?php
	class Hotline_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_All_Hotline($limit_start=false,$limit_show=false) {
			$selectClause = " HotlineID,Title,Phone,Orders,CAST(Publish as UNSIGNED INT) as Publish, (select count(HotlineID) from hotline) as count from hotline";

			$this -> db -> select($selectClause);

			$this -> db -> limit($limit_show,$limit_start);

			$result = $this -> db -> get();

			return $result;
		}

		public function Get_HotLine_By_Id($hotlineid = false) {
			if($hotlineid !== false) {
				$selectClause = " HotlineID,Title,Phone,Orders,CAST(Publish as UNSIGNED INT) as Publish from hotline where HotlineID =".$hotlineid;

				$this -> db -> select($selectClause);

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		private function check_input_field() {
			$this -> input -> post('hotlineTitle') ? $Title = $this -> input -> post('hotlineTitle') : $Title = "";
			$this -> input -> post('hotlinePhone') ? $Phone = $this -> input -> post('hotlinePhone') : $Phone = "";
			$this -> input -> post('hotlinePublish') ? $Publish = 1 : $Publish = 0;
			$this -> input -> post('hotlineOrders') ? ( is_numeric($this -> input -> post('hotlineOrders')) ? $Orders = $this -> input -> post('hotlineOrders') : $Orders = 999 ) : $Orders = 999;

			$data = array(
        				'Title' => $Title,
        				'Phone' => $Phone,
						'Publish' => $Publish,
						'Orders' => $Orders
        		);
        	return $data;
		}

		public function Hotline_insert() {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Phone' => $receivedata['Phone'],
						'Publish' => (int)$receivedata['Publish'],
						'Orders' => $receivedata['Orders']
					);
			$this -> db -> insert('hotline',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Hotline_update($id) {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Phone' => $receivedata['Phone'],
						'Publish' => (int)$receivedata['Publish'],
						'Orders' => $receivedata['Orders']
					);
			return $this -> db -> update('hotline',$data,array('HotlineID' => $id));
		}

		public function Hotline_update_order($id) {

			$this -> input -> post('orders') ? ( is_numeric($this -> input -> post('orders')) ? $Orders = $this -> input -> post('orders') : $Orders = 999 ) : $Orders = 999;
			$data = array(
						'Orders' => $Orders
					);
			return $this -> db -> update('hotline',$data,array('HotlineID' => $id));
		}

		public function Hotline_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('hotline',array('HotlineID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>