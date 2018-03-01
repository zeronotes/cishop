<?php 
	class Sorting_channel_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		function Ajax_Update_Orders() {
			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id && $orders) {
				$data = array(
						'Orders' => $orders,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
				$this -> db -> update('sortingchannel',$data,array('SortingChannelID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		function Ajax_Update_Publish() {
			$id = $this -> input -> post('id');
			$publish = $this -> input -> post('Publish') ;//? ( is_numeric($this -> input -> post('Publish')) ? $publish = $this -> input -> post('Publish') : $publish = 1 ) : $publish = 1;
			if($publish !== false && $id !== false) {
				$data = array('Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('sortingchannel',$data,array('SortingChannelID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		function Ajax_Update_IsTop() {
			$id = $this -> input -> post('id');
			$istop = $this -> input -> post('IsTop') ;
			if($istop !== false && $id !== false) {
				$data = array('IsTop' => (int)$istop,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);
				$this -> db -> update('sortingchannel',$data,array('SortingChannelID' => $id));
				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
			return false;
		}

		public function Ajax_Check_Title() {
			$title = $this -> input -> post('title');
				
			$this -> db -> select('SortingChannelID');
			$this -> db -> from('sortingchannel');
			$this -> db -> where('Title', $title);
			$query3 = $this -> db -> get();
			if ($query3 -> num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function Ajax_Check_Title_Except() {
			$title = $this -> input -> post('title');
			$id = $this -> input -> post('id');
			
			$this -> db -> select('SortingChannelID');
			$this -> db -> from('sortingchannel');
			$this -> db -> where_not_in('SortingChannelID', $id);
			$this -> db -> where('Title', $title);
			$query3 = $this -> db -> get();
			if ($query3 -> num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
?>