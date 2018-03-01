<?php
	class Ajax_menu_hot_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function NewsCate_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> NewsCate(0,$temp);
				return $temp;
			}
		}

		private function NewsCate($parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> NewsCate($temp[$i]['CategoriesNewsID'],$array,$space.'-----',$trees);
			}
			return $trees;
		}

		private function News_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> News($temp);
				return $temp;
			}
		}

		private function News($array = array(),$space = '|--',$trees = array()){

			for ($i=0; $i < count($array); $i++) {
				$array[$i]["Title"] = $space.$array[$i]['Title'];
				$trees[] = $array[$i];
			}
			return $trees;
		}

		private function ProdCate_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> ProdCate(0,$temp);
				return $temp;
			}
		}

		private function ProdCate($parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> ProdCate($temp[$i]['CategoriesProductsID'],$array,$space.'-----',$trees);
			}
			return $trees;
		}

		private function Prod_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> Prod($temp);
				return $temp;
			}
		}

		private function Prod($array = array(),$space = '|--',$trees = array()){

			for ($i=0; $i < count($array); $i++) {
				$array[$i]["Title"] = $space.$array[$i]['Title'];
				$trees[] = $array[$i];
			}
			return $trees;
		}

		// lay ra cac tin tic tuc de nhet link vao menu
		public function Ajax_Get_News() {
			$selectClause = " news.NewsID,news.CategoriesNewsID,news.Slug,news.Title";
			$this -> db -> select($selectClause);
			$this -> db -> from("news");
			$this -> db -> order_by("Orders", "asc");
			$this -> db -> order_by("IsHot", "desc");
			$this -> db -> order_by("CreatedDate","desc");
			$result = $this -> db -> get();
			return $this -> News_recursion($result);
		}

		// lay ra cac danh muc tin tuc tuc de nhet link vao menu
		public function Ajax_Get_NewsCate() {
			$selectClause = " categoriesnews.CategoriesNewsID,categoriesnews.ParentID,categoriesnews.Slug, categoriesnews.Title";

			$this -> db -> select($selectClause);

			$this -> db -> from("categoriesnews");

			$result = $this -> db -> get();

			return $this -> NewsCate_recursion($result);
		}

		// lay ra cac san pham de nhet link vao menu
		public function Ajax_Get_Prod() {
			$selectClause = " products.ProductsID,products.CategoriesProductsID,products.Slug,products.Title";
			$this -> db -> select($selectClause);
			$this -> db -> from("products");
			$this -> db -> order_by("Orders", "asc");
			$this -> db -> order_by("IsHot", "desc");
			$this -> db -> order_by("CreatedDate","desc");
			$result = $this -> db -> get();
			return $this -> Prod_recursion($result);
		}

		// lay ra cac danh muc san pham tuc de nhet link vao menu
		public function Ajax_Get_ProdCate() {
			$selectClause = " categoriesproducts.CategoriesProductsID,categoriesproducts.ParentID,categoriesproducts.Slug,categoriesproducts.Title";

			$this -> db -> select($selectClause);

			$this -> db -> from("categoriesproducts");

			$result = $this -> db -> get();

			return $this -> ProdCate_recursion($result);
		}

		public function Ajax_Update_NewTab() {
			$id = $this -> input -> post('id');
			$this -> input -> post('IsNewTab') ? $IsNewTab = 1 : $IsNewTab = 0;
			if($id !== false) {
				$data = array('IsNewTab' => (int)$IsNewTab,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('menuhot',$data,array('MenuID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Publish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
			if($id !== false) {
				$data = array('Publish' => (int)$Publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('menuhot',$data,array('MenuID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_IsClick() {
			$id = $this -> input -> post('id');
			$this -> input -> post('IsClick') ? $IsClick = 1 : $IsClick = 0;
			if($id !== false) {
				$data = array('IsClick' => (int)$IsClick,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('menuhot',$data,array('MenuID' => $id));

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
				$this -> db -> update('menuhot',$data,array('MenuID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}
	}
?>