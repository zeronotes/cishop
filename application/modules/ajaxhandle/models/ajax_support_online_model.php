<?php 
	class Ajax_support_online_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_update_orders() {
			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id && $orders) {
				$data = array(
						'Orders' => $orders,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
				$this -> db -> update('supportonline',$data,array('SupportOnlineID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		public function Ajax_update_publish() {
			$id = $this -> input -> post('id');
			$publish = $this -> input -> post('Publish') ? 1 : 0 ;
			if($publish !== false && $id !== false) {
				$data = array('Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('supportonline',$data,array('SupportOnlineID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}
	}
?>