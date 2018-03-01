<?php 
	class Ajax_news_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_Update_Publish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
			if($id !== false) {
				$data = array('Publish' => (int)$Publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('news',$data,array('NewsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_IsHot() {
			$id = $this -> input -> post('id');
			$this -> input -> post('IsHot') ? $IsHot = 1 : $IsHot = 0;
			if($id !== false) {
				$data = array('IsHot' => (int)$IsHot,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('news',$data,array('NewsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_IsBanner() {
			$id = $this -> input -> post('id');
			$this -> input -> post('IsBanner') ? $IsBanner = 1 : $IsBanner = 0;
			if($id !== false) {
				$data = array('IsBanner' => (int)$IsBanner,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('news',$data,array('NewsID' => $id));

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
				$data = array(
						'Orders' => $orders,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
				$this -> db -> update('news',$data,array('NewsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		public function Ajax_Check_Title() {
			$title = $this -> input -> post('title');
				
			$this -> db -> select('NewsID');
			$this -> db -> from('news');
			$this -> db -> where('Title', $title);
			$query = $this -> db -> get();
			if ($query -> num_rows() > 0) {
				return true;
			} else {
				$this -> db -> select('CategoriesNewsID');
				$this -> db -> from('categoriesnews');
				$this -> db -> where('Title', $title);
				$query2 = $this -> db -> get();
				if ($query2 -> num_rows() > 0) {
					return true;
				} else {
					return false;
				}
			}
		}

		public function Ajax_Check_Title_Except() {
			$title = $this -> input -> post('title');
			$id = $this -> input -> post('id');
				
			$this -> db -> select('NewsID');
			$this -> db -> from('news');
			$this -> db -> where('Title', $title);
			$this -> db -> where_not_in('NewsID', $id);
			$query = $this -> db -> get();
			if ($query -> num_rows() > 0) {
				return true;
			} else {
				$this -> db -> select('CategoriesNewsID');
				$this -> db -> from('categoriesnews');
				$this -> db -> where('Title', $title);
				$query2 = $this -> db -> get();
				if ($query2 -> num_rows() > 0) {
					return true;
				} else {
					return false;
				}
			}
		}
	}
?>