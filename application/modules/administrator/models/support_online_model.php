<?php 
	class Support_online_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_all_suppport($limit_start=false,$limit_show=false) {
			$selectClause = " SupportOnlineID,Title,CAST(Publish as UNSIGNED INT) as Publish,Orders, (select count(SupportOnlineID) from supportonline) as count from supportonline";

			$this -> db -> select($selectClause);
			$this -> db -> order_by('CreatedDate desc');
			$this -> db -> limit($limit_show,$limit_start);

			$result = $this -> db -> get();

			return $result;
		}

		public function Get_support_by_id($id = false) {
			if($id !== false) {
				$selectClause = "select SupportOnlineID,Title,FullName,Phone,Email,Skype,Orders,Yahoo,CAST(Publish as UNSIGNED INT) as Publish,Orders from supportonline where SupportOnlineID = ?";

				$result = $this -> db -> query($selectClause,array($id));

				return $result -> row_array();
			}else {
				show_404();
			}
		}

		private function Check_input_field() {
			$this -> input -> post('supportTitle') ? $Title = $this -> input -> post('supportTitle') : $Title = "";
			$this -> input -> post('supportName') ? $FullName = $this -> input -> post('supportName') : $FullName = "";
			$this -> input -> post('supportPhone') ? $Phone = $this -> input -> post('supportPhone') : $Phone = "";
			$this -> input -> post('supportEmail') ? $Email = $this -> input -> post('supportEmail') : $Email = "";
			$this -> input -> post('supportSkype') ? $Skype = $this -> input -> post('supportSkype') : $Skype = "";
			$this -> input -> post('supportYahoo') ? $Yahoo = $this -> input -> post('supportYahoo') : $Yahoo = "";
			$this -> input -> post('supportPublish') ? $Publish = 1 : $Publish = 0;
			$this -> input -> post('supportOrders') ? ( is_numeric($this -> input -> post('supportOrders')) ? $Orders = $this -> input -> post('supportOrders') : $Orders = 999 ) : $Orders = 999;

			$data = array(
        				'Title' => $Title,
        				'FullName' => $FullName,
        				'Phone' => $Phone,
        				'Email' => $Email,
        				'Skype' => $Skype,
        				'Yahoo' => $Yahoo,
						'Publish' => $Publish,
						'Orders' => $Orders
        		);
        	return $data;
		}

		public function Support_insert() {
			$receivedata = $this -> Check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'FullName' => $receivedata['FullName'],
						'Phone' => $receivedata['Phone'],
						'Email' => $receivedata['Email'],
						'Skype' => $receivedata['Skype'],
						'Yahoo' => $receivedata['Yahoo'],
						'Publish' => (int)$receivedata['Publish'],
						'Orders' => $receivedata['Orders'],
						'CreatedBy' => $this -> session -> userdata('userid')
					);
			$this -> db -> insert('supportonline',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}		

		public function Support_update($id) {
			$receivedata = $this -> Check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'FullName' => $receivedata['FullName'],
						'Phone' => $receivedata['Phone'],
						'Email' => $receivedata['Email'],
						'Skype' => $receivedata['Skype'],
						'Yahoo' => $receivedata['Yahoo'],
						'Publish' => (int)$receivedata['Publish'],
						'Orders' => $receivedata['Orders'],
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
			$this -> db -> update('supportonline',$data,array('SupportOnlineID' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Delete_support($id = false) {
			if($id !== false) {
				$this -> db -> delete('supportonline',array('SupportOnlineID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
			
			show_404();
		}
	}
?>