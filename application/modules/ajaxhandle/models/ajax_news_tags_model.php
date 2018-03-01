<?php 
	class Ajax_news_tags_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_Update_Publish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
			if($id !== false) {
				$data = array('Publish' => (int)$Publish);
				$this -> db -> update('newstags',$data,array('TagsID' => $id));
				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
			return false;
		}

		public function Ajax_Update_Orders() {
			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id !== false && $orders !== false) {
				$data = array('Orders' => $orders);
				$this -> db -> update('newstags',$data,array('TagsID' => $id));
				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}
	}
?>