<?php
	class Categories_news_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}


		private function NewsCategories_recursion($limit_start=false,$limit_show=false,$result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> News($limit_start,$limit_show,0,$temp);
				return $temp;
			}
		}

		private function News($start = false, $end = false,$parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			$temp = array();
			if($start !== false && $end !== false) {
				for ($i=0; $i < count($array); $i++) {

					if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
				}

				for($i = $start; $i < $end; $i++) {
					if($i < count($temp))
						$temp2[] = $temp[$i];
					else
						break;
				}

				$temp = ( isset($temp2) && is_array($temp2) && !empty($temp2) ) ? $temp2 : $temp;

			}else {
				for ($i=0; $i < count($array); $i++) {

					if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
				}
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> News(false,false,$temp[$i]['CategoriesNewsID'],$array,$space.'-----',$trees);
			}

			return $trees;
		}

		public function Categoriesnews_get_all($limit_start=false,$limit_show=false) {
			$selectClause = ' select catenews.CategoriesNewsID,catenews.ParentID,catenews.Title,catenews.Orders,catenews.Banner,
									CAST(catenews.Publish as UNSIGNED INT) AS Publish, CAST(catenews.IsHot as UNSIGNED INT) AS IsHot, CAST(catenews.IsCool as UNSIGNED INT) AS IsCool, catenews.Description, catenews.Body,
									(select count(CategoriesNewsID) from categoriesnews where ParentID = 0) as count
									from categoriesnews as catenews order by catenews.Orders,catenews.CreatedDate desc ';

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $this -> NewsCategories_recursion($limit_start,$limit_show+$limit_start,$result);
		}


		private function NewsCategories_recursion_noPaging($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> News_noPaging(0,$temp);
				return $temp;
			}
		}

		private function News_noPaging($parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> News_noPaging($temp[$i]['CategoriesNewsID'],$array,$space.'-----',$trees);
			}

			return $trees;
		}

		public function Categoriesnews_get_all_for_select_box() {
			$selectClause = " select CategoriesNewsID,Title,ParentID from categoriesnews order by Orders, CreatedDate desc ";

			$result = $this -> db -> query($selectClause);

			return $this -> NewsCategories_recursion_noPaging($result);
		}

		public function Categoriesnews_get_except_by_id($id = false) {
			$selectClause = " CategoriesNewsID,Title,ParentID from categoriesnews where CategoriesNewsID not like ".$id;
			$this -> db -> select($selectClause);
			$result = $this -> db -> get();

			return $this -> NewsCategories_recursion_noPaging($result);
		}

		// get all of categoriesnews information by id
		public function Categoriesnews_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " cate.CategoriesNewsID,cate.Title,cate.Title_en,cate.Title_fr,cate.Description,cate.Body,cate.Banner,cate.ImageTitle,cate.ImageAlt,
								  cate.ParentID,cate.Publish,cate.Orders, cate.SEOTitle,cate.SEOKeyword,cate.SEODescription,
								  (select Username from admin where UsersID = cate.CreatedBy) as CreatedBy,
						          (select Username from admin where UsersID = cate.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);
				$this -> db -> select("DATE_FORMAT(cate.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(cate.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("categoriesnews as cate");

				$this -> db -> where("cate.CategoriesNewsID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		// get all of categoriesnews information by slug
		public function Categoriesnews_get_by_slug($slug = false) {

		}

		public function getAllParentOfCateChild($cateId = false) {
			if($cateId !== false) {

				// global $lang;

				// $selectClause = " select ";

				// if($lang == 'vi') {
				// 	$selectClause .= ' Title, ';
				// }else {
				// 	$selectClause .= ' Title_en as Title, ';
				// }

				$selectClause .= " select CategoriesNewsID,Title,Title_en,Title_fr,ParentID,Slug from categoriesnews where Publish = 1 and CategoriesNewsID = ? limit 1 ";

				$result = $this -> db -> query($selectClause,$cateId);

				if($result -> num_rows() > 0) {
					$result = $result -> row_array();

					$temp[] = $result;

					if($result['ParentID'] != 0) {
						$yeah = $this -> getAllParentOfCateChild($result['ParentID']);

						foreach ($yeah as $key) {
							$temp[] = $key;
						}
					}
				}
			}

			return $temp;
		}

		public function getALlChildOfCateParent($cateId = false,$temp = array()) {
			$temp[] = $cateId;
			if($cateId !== false) {
				$selectClause = " select CategoriesNewsID from categoriesnews where Publish = 1 and ParentID = ? ";

				$result = $this -> db -> query($selectClause,$cateId);
				if($result -> num_rows() > 0) {
					$result = $result -> result_array();
					foreach ($result as $key) {
						$temp[] = $key['CategoriesNewsID'];
						$this -> getALlChildOfCateParent($key['CategoriesNewsID'],$temp);
					}
				}
			}

			return $temp;
		}

		private function check_input_field() {
			/*
        	**	Kiem tra dau vao cua du lieu submit len server.
        	*/

        	$this -> input -> post('cateTitle') ? $cateTitle = $this -> input -> post('cateTitle') : $cateTitle = "Unknowns";
        	$this -> input -> post('cateTitle_en') ? $cateTitle_en = $this -> input -> post('cateTitle_en') : $cateTitle_en = "Unknowns";
        	$this -> input -> post('cateTitle_fr') ? $cateTitle_fr = $this -> input -> post('cateTitle_fr') : $cateTitle_fr = "Unknowns";
        	//$this -> input -> post('cateTitle') ? $Slug = $this -> gen_slug( $this -> input -> post('cateTitle') ) : $Slug = "";
        	$this -> input -> post('cateParentID') ? $cateParentID = $this -> input -> post('cateParentID') : $cateParentID = 0;
        	$this -> input -> post('catePublish') ? $Publish = 1 : $Publish = 0;
        	$this -> input -> post('cateOrders') ? ( is_numeric($this -> input -> post('cateOrders')) ? $Orders = $this -> input -> post('cateOrders') : $Orders = 999 ) : $Orders = 999;
        	$this -> input -> post('cateDescription') ? $cateDescription = $this -> input -> post('cateDescription') : $cateDescription = "";
        	$this -> input -> post('cateBody') ? $cateBody = $this -> input -> post('cateBody') : $cateBody = "";
        	$this -> input -> post('Banner') ? $Banner = $this -> input -> post('Banner') : $Banner = 'default.png' ;
        	$this -> input -> post('cateImageTitle') ? $cateImageTitle = $this -> input -> post('cateImageTitle') : $cateImageTitle = "";
			$this -> input -> post('cateImageAlt') ? $cateImageAlt = $this -> input -> post('cateImageAlt') : $cateImageAlt = "";

        	$this -> input -> post('newsPageTitle') ? $SEOTitle = $this -> input -> post('newsPageTitle') : $SEOTitle = $cateTitle;
            $this -> input -> post('newsMetaKeywords') ? $SEOKeyword = $this -> input -> post('newsMetaKeywords') : $SEOKeyword = $cateTitle;
            $this -> input -> post('newsMetaDesc') ? $SEODescription = $this -> input -> post('newsMetaDesc') : $SEODescription = $cateDescription;

        	$data = array(
        				'Title' => $cateTitle,
        				'Title_en' => $cateTitle_en,
        				'Title_fr' => $cateTitle_fr,
						'Description' => $cateDescription,
						'Body' => $cateBody,
						'ParentID' => $cateParentID,
						'Publish' => $Publish,
						'SEOTitle' => $SEOTitle,
						'SEOKeyword' => $SEOKeyword,
						'SEODescription' => $SEODescription,
						'Orders' => $Orders,
						'Banner' => $Banner,
						'ImageTitle' => $cateImageTitle,
        				'ImageAlt' => $cateImageAlt,
        		);
        	return $data;
		}

		public function Categoriesnews_get_newsest_id() {
			$selectClause = " CategoriesNewsID from categoriesnews order by CategoriesNewsID desc limit 1";

			$this -> db -> select($selectClause);

			$result = $this -> db -> get();

			if($result -> num_rows() > 0)
				return $result -> row_array();
			return false;
		}

		//add new categoriesnews
		public function Categoriesnews_insert() {

			$newestid = $this -> Categoriesnews_get_newsest_id();
			if($newestid !== false) {
				$newestid = $newestid['CategoriesNewsID']+1;
			}else { $newestid = 1; }

			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'Slug' => $this -> gen_slug($receivedata['Title']),
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'Orders' => $receivedata['Orders'],
						'Banner' => $receivedata['Banner'],
						'ImageTitle' => $receivedata['ImageTitle'],
						'ImageAlt' => $receivedata['ImageAlt'],
						'CreatedBy' => $this -> session -> userdata('userid')//get from session data
					);
			$this -> db -> insert('categoriesnews',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		//update categoriesnews
		public function Categoriesnews_update($id) {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'Slug' => $this -> gen_slug($receivedata['Title']),
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'Orders' => $receivedata['Orders'],
						'Banner' => $receivedata['Banner'],
						'ImageTitle' => $receivedata['ImageTitle'],
						'ImageAlt' => $receivedata['ImageAlt'],
						'ModifiedBy' => $this -> session -> userdata('userid'),//get from session data
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
			$this -> db -> update('categoriesnews',$data,array('CategoriesNewsID' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		private function check_con($idCha = false) {
			$selectClause = " select CategoriesNewsID from categoriesnews where ParentID = ? ";

			$result = $this -> db -> query($selectClause,array($idCha));

			if($result -> num_rows() > 0){
				return $result -> result_array();
			}
			return array();
		}

		private function dequy_xoa($idCha = false) {
			global $numTemp;
			if($idCha !== false) {

				$deleteClause = " delete from categoriesnews where CategoriesNewsID = ? ";
				$result = $this -> db -> query($deleteClause,array($idCha));

				if($this -> db -> affected_rows() > 0 ) {
					$deleteNews = " delete from news where CategoriesNewsID = ? ";
					$this -> db -> query($deleteNews,array($idCha));

					$arrayTemp = $this -> check_con($idCha);
					if(!empty($arrayTemp)) {
						foreach ($arrayTemp as $key) {
							$this -> dequy_xoa($key['CategoriesNewsID']);
						}
					}
					return true;
				}

			}else {
				return false;
			}
		}

		//delete categoriesnews
		public function Categoriesnews_delete($id = false) {
			global $numTemp;
			if($id !== false) {
				return $this -> dequy_xoa($id);
			}
			return false;
		}
	}
?>