<?php 
	class Ajax_orders_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_update_status() {
			$id = $this -> input -> post('id');
			$status = $this -> input -> post('status');
			if($status !== false && $id !== false) {
				$data = array('OrderStatusID' => $status,
								'UnRead' => 0,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('orders',$data,array('OrdersID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_update_payments() {
			$id = $this -> input -> post('id');
			$payments = $this -> input -> post('payments');
			if($payments !== false && $id !== false) {
				$data = array('PaymentsID' => $payments,
								'UnRead' => 0,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('orders',$data,array('OrdersID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_delete() {
			$id = $this -> input -> post('id');
			if($id && $id != '' & is_numeric($id) ) {
				$this -> db -> delete('orders',array('OrdersID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
			show_404();
		}
	}
?>