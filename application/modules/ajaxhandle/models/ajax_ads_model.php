<?php
	class Ajax_ads_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_update_height() {
			$id = $this -> input -> post('id');
			$height = $this -> input -> post('height');

			if($height !== false && $id !== false) {
				$data = array('Height' => (int)$height,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('ads',$data,array('AdsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_update_width() {
			$id = $this -> input -> post('id');
			$width = $this -> input -> post('width');

			if($width !== false && $id !== false) {
				$data = array('Width' => (int)$width,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('ads',$data,array('AdsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_update_orders() {
			$id = $this -> input -> post('id');
			$orders = $this -> input -> post('orders');

			if($orders !== false && $id !== false) {
				$data = array('orders' => $orders,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('ads',$data,array('AdsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_update_publish() {
			$id = $this -> input -> post('id');
			$publish = $this -> input -> post('publish');

			if($publish !== false && $id !== false) {
				$data = array('Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('ads',$data,array('AdsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_delete() {
			$id = $this -> input -> post('id');

			if($id !== false && is_numeric($id)) {
				$this -> db -> delete("ads",array("AdsID" => $id));

				if($this -> db -> affected_rows() > 0){
					return true;
				}
			}
			return false;
		}
	}
?>