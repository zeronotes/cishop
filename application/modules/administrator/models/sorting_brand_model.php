<?php
	class Sorting_brand_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function ProductsCategories_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> Categories(0,$temp);
				return $temp;
			}
		}

		private function Categories($parentid = 0,$array = array(),$space = '|-----',$trees = array()){ 
			
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) { 
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> Categories($temp[$i]['SortingBrandID'],$array,$space.'-----',$trees);
			}

			return $trees;
		}

		// fill all categories into category view
		public function Category_get_all($limit_start=false,$limit_show=false) {
			$this -> db -> select(' cate.SortingBrandID,cate.Title,cate.Orders,cate.Publish,cate.IsTop,cate.ParentID, (select count(SortingBrandID) 
										from sortingbrand) as count from sortingbrand as cate');
			$this -> db -> order_by("Orders asc, Title asc, CreatedDate desc");
			$this -> db -> limit($limit_show,$limit_start);
			$result = $this -> db -> get();

			return $this -> ProductsCategories_recursion($result);
		}

		public function Category_get_all_for_select_box() {
			$this -> db -> select("SortingBrandID,Title,ParentID");
			$this -> db -> from("sortingbrand");
			$this -> db -> order_by("Orders asc, Title asc, CreatedDate desc");
			$result = $this -> db -> get();

			return $this -> ProductsCategories_recursion($result);
		}

		public function Category_get_by_id($CateID = false) {
			if($CateID !== false) {
				$selectClause = " cate.SortingBrandID,cate.Title,cate.Title_en,cate.Title_fr,cate.Description,cate.Body,cate.ImagesURL,cate.ImagesTitle,cate.ImagesAlt,
								  cate.ParentID,cate.Publish,cate.IsTop,cate.Orders,cate.SEOTitle,cate.SEOKeyword,cate.SEODescription, 
								  (select Username from admin where UsersID = cate.CreatedBy) as CreatedBy,
						          (select Username from admin where UsersID = cate.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);
				$this -> db -> select("DATE_FORMAT(cate.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(cate.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("sortingbrand as cate");

				$this -> db -> where("cate.SortingBrandID = ".$CateID.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		public function Category_get_except_by_id($CateID = false) {
			$selectClause = "* from sortingbrand where SortingBrandID not like ".$CateID;
			$this -> db -> select($selectClause);
			$result = $this -> db -> get();

			return $this -> ProductsCategories_recursion($result);
		}

		public function Category_get_by_slug($Slug = false) {
			$result = $this -> db -> get_where('sortingbrand',array('Slug' => $CateID));

			return $result;
		}

		private function check_input_field() {
			/* 
        	**	Kiem tra dau vao cua du lieu submit len server.
        	*/

        	$this -> input -> post('cateTitle') ? $cateTitle = $this -> input -> post('cateTitle') : $cateTitle = "Unknowns";
        	$this -> input -> post('cateTitle_en') ? $cateTitle_en = $this -> input -> post('cateTitle_en') : $cateTitle_en = "Unknowns";
        	$this -> input -> post('cateTitle_fr') ? $cateTitle_fr = $this -> input -> post('cateTitle_fr') : $cateTitle_fr = "Unknowns";
        	$this -> input -> post('cateTitle') ? $Slug = $this -> gen_slug( $this -> input -> post('cateTitle') ) : $Slug = "";
        	$this -> input -> post('cateParentID') ? $cateParentID = $this -> input -> post('cateParentID') : $cateParentID = 0;
        	$this -> input -> post('catePublish') ? $Publish = 1 : $Publish = 0;
        	$this -> input -> post('cateIsTop') ? $IsTop = 1 : $IsTop = 0;
        	$this -> input -> post('cateOrders') ? ( is_numeric($this -> input -> post('cateOrders')) ? $Orders = $this -> input -> post('cateOrders') : $Orders = 999 ) : $Orders = 999;
        	$this -> input -> post('cateImagesURL') ? $cateImagesURL = $this -> input -> post('cateImagesURL') : $cateImagesURL = "";
        	$this -> input -> post('cateDescription') ? $cateDescription = $this -> input -> post('cateDescription') : $cateDescription = "";
        	$this -> input -> post('cateBody') ? $cateBody = $this -> input -> post('cateBody') : $cateBody = "";
        	$this -> input -> post('catePageTitle') ? $SEOTitle = $this -> input -> post('catePageTitle') : $SEOTitle = "";
            $this -> input -> post('cateMetaKeywords') ? $SEOKeyword = $this -> input -> post('cateMetaKeywords') : $SEOKeyword = "";
            $this -> input -> post('cateMetaDesc') ? $SEODescription = $this -> input -> post('cateMetaDesc') : $SEODescription = "";

        	$data = array(
        				'Title' => $cateTitle,
        				'Title_en' => $cateTitle_en,
        				'Title_fr' => $cateTitle_fr,
						'Description' => $cateDescription,
						'Body' => $cateBody,
						'ParentID' => $cateParentID,
						'Publish' => $Publish,
						'IsTop' => $IsTop,
						'ImagesURL' => $cateImagesURL,
						'Slug' => $Slug,
						'SEOTitle' => $SEOTitle,
						'SEOKeyword' => $SEOKeyword,
						'SEODescription' => $SEODescription,
						'Orders' => $Orders
        		);
        	
        	return $data;
		}
 
		public function Category_insert() {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'IsTop' => (int)$receivedata['IsTop'],
						'ImagesURL' => $receivedata['ImagesURL'],
						'Slug' => $receivedata['Slug'],
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'Orders' => $receivedata['Orders'],
						'CreatedBy' => $this -> session -> userdata('userid')//get from session data
					);
			$this -> db -> insert('sortingbrand',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Category_update($CateID) {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'IsTop' => (int)$receivedata['IsTop'],
						'ImagesURL' => $receivedata['ImagesURL'],
						'Slug' => $receivedata['Slug'],
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'Orders' => $receivedata['Orders'],
						'ModifiedBy' => $this -> session -> userdata('userid'),//get from session data
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
			$this -> db -> update('sortingbrand',$data,array('SortingBrandID' => $CateID));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		private function check_con($idCha = false) {
			$selectClause = " select SortingBrandID from sortingbrand where ParentID = ? ";

			$result = $this -> db -> query($selectClause,array($idCha));

			if($result -> num_rows() > 0){
				return $result -> result_array();
			}
			return array();
		}

		private function dequy_xoa($idCha = false) {
			global $numTemp;
			if($idCha !== false) {

				$deleteClause = " delete from sortingbrand where SortingBrandID = ? ";
				$result = $this -> db -> query($deleteClause,array($idCha));

				if($this -> db -> affected_rows() > 0 ) {
					return true;
				}
			}else {
				return false;
			}
		}

		//delete sortingbrand
		public function Category_delete($id = false) {
			global $numTemp;
			if($id !== false) {
				return $this -> dequy_xoa($id);
			}
			return false;
		}
	}
?>