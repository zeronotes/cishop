<?php
	class Sorting_price_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}


		private function SortingPrice_recursion($limit_start=false,$limit_show=false,$result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> SortingPrice($limit_start,$limit_show,0,$temp);
				return $temp;
			}
		}

		private function SortingPrice($start = false, $end = false,$parentid = 0,$array = array(),$space = '|-----',$trees = array()){

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
				$trees = $this -> SortingPrice(false,false,$temp[$i]['SortingPriceID'],$array,$space.'-----',$trees);
			}

			return $trees;
		}

		public function SortingPrice_get_all($limit_start=false,$limit_show=false) {
			$selectClause = ' select SortingPriceID,ParentID,Title,PriceFrom,PriceTo,
									CAST(Publish as UNSIGNED INT) AS Publish, Description, Body,
									(select count(SortingPriceID) from sortingprice where ParentID = 0) as count
									from sortingprice order by PriceFrom asc,CreatedDate desc ';

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $this -> SortingPrice_recursion($limit_start,$limit_show+$limit_start,$result);
		}

		public function Category_get_all_for_select_box() {
			$this -> db -> select("SortingPriceID,Title,ParentID");
			$this -> db -> from("sortingprice");
			$this -> db -> order_by("PriceFrom asc, PriceTo asc");
			$result = $this -> db -> get();

			return $this -> SortingPrice_recursion_noPaging($result);
		}


		private function SortingPrice_recursion_noPaging($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> SortingPrice_noPaging(0,$temp);
				return $temp;
			}
		}

		private function SortingPrice_noPaging($parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> SortingPrice_noPaging($temp[$i]['SortingPriceID'],$array,$space.'-----',$trees);
			}

			return $trees;
		}

		public function SortingPrice_get_all_for_select_box() {
			$selectClause = " select SortingPriceID,Title,ParentID from sortingprice order by Orders, CreatedDate desc ";

			$result = $this -> db -> query($selectClause);

			return $this -> SortingPrice_recursion_noPaging($result);
		}

		public function SortingPrice_get_except_by_id($id = false) {
			$selectClause = " SortingPriceID,Title,ParentID from sortingprice where SortingPriceID not like ".$id;
			$this -> db -> select($selectClause);
			$result = $this -> db -> get();

			return $this -> SortingPrice_recursion_noPaging($result);
		}

		// get all of sortingprice information by id
		public function SortingPrice_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " cate.SortingPriceID,cate.Title,cate.Title_en,cate.Title_fr,cate.Description,cate.Body,
								  cate.ParentID,cate.Publish, cate.SEOTitle,cate.SEOKeyword,cate.SEODescription,cate.PriceFrom,cate.PriceTo,
								  (select Username from admin where UsersID = cate.CreatedBy) as CreatedBy,
						          (select Username from admin where UsersID = cate.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);
				$this -> db -> select("DATE_FORMAT(cate.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(cate.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("sortingprice as cate");

				$this -> db -> where("cate.SortingPriceID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		// get all of sortingprice information by slug
		public function SortingPrice_get_by_slug($slug = false) {

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

				$selectClause .= " select SortingPriceID,Title,Title_en,Title_fr,ParentID,Slug from sortingprice where Publish = 1 and SortingPriceID = ? limit 1 ";

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
				$selectClause = " select SortingPriceID from sortingprice where Publish = 1 and ParentID = ? ";

				$result = $this -> db -> query($selectClause,$cateId);
				if($result -> num_rows() > 0) {
					$result = $result -> result_array();
					foreach ($result as $key) {
						$temp[] = $key['SortingPriceID'];
						$this -> getALlChildOfCateParent($key['SortingPriceID'],$temp);
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

        	$this -> input -> post('cateParentID') ? $cateParentID = $this -> input -> post('cateParentID') : $cateParentID = 0;
        	$this -> input -> post('catePublish') ? $Publish = 1 : $Publish = 0;
        	$this -> input -> post('cateDescription') ? $cateDescription = $this -> input -> post('cateDescription') : $cateDescription = "";
        	$this -> input -> post('cateBody') ? $cateBody = $this -> input -> post('cateBody') : $cateBody = "";
        	$this -> input -> post('catePriceFrom') ? $catePriceFrom = str_replace('.','',$this -> input -> post('catePriceFrom')) : $catePriceFrom = 0;
        	$this -> input -> post('catePriceTo') ? $catePriceTo = str_replace('.','',$this -> input -> post('catePriceTo')) : $catePriceTo = 0;
        	
        	$this -> input -> post('newsPageTitle') ? $SEOTitle = $this -> input -> post('newsPageTitle') : $SEOTitle = $cateTitle;
            $this -> input -> post('newsMetaKeywords') ? $SEOKeyword = $this -> input -> post('newsMetaKeywords') : $SEOKeyword = $cateTitle;
            $this -> input -> post('newsMetaDesc') ? $SEODescription = $this -> input -> post('newsMetaDesc') : $SEODescription = $cateDescription;

        	$data = array(
        				'Title' => 'Từ ' . number_format($catePriceFrom,0,',','.') . ' đến ' . number_format($catePriceTo,0,',','.'),
        				'Title_en' => $cateTitle_en,
        				'Title_fr' => $cateTitle_fr,
						'Description' => $cateDescription,
						'Body' => $cateBody,
						'ParentID' => $cateParentID,
						'Publish' => $Publish,
						'SEOTitle' => $SEOTitle,
						'SEOKeyword' => $SEOKeyword,
						'SEODescription' => $SEODescription,
						'PriceFrom' => $catePriceFrom,
						'PriceTo' => $catePriceTo,
        		);
        	return $data;
		}

		public function SortingPrice_get_newsest_id() {
			$selectClause = " SortingPriceID from sortingprice order by SortingPriceID desc limit 1";

			$this -> db -> select($selectClause);

			$result = $this -> db -> get();

			if($result -> num_rows() > 0)
				return $result -> row_array();
			return false;
		}

		//add new sortingprice
		public function SortingPrice_insert() {

			$newestid = $this -> SortingPrice_get_newsest_id();
			if($newestid !== false) {
				$newestid = $newestid['SortingPriceID']+1;
			}else { $newestid = 1; }

			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'PriceFrom' => $receivedata['PriceFrom'],
						'PriceTo' => $receivedata['PriceTo'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'CreatedBy' => $this -> session -> userdata('userid')//get from session data
					);
			$this -> db -> insert('sortingprice',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		//update sortingprice
		public function SortingPrice_update($id) {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Body' => $receivedata['Body'],
						'PriceFrom' => $receivedata['PriceFrom'],
						'PriceTo' => $receivedata['PriceTo'],
						'ParentID' => $receivedata['ParentID'],
						'Publish' => (int)$receivedata['Publish'],
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'ModifiedBy' => $this -> session -> userdata('userid'),//get from session data
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
			$this -> db -> update('sortingprice',$data,array('SortingPriceID' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		private function check_con($idCha = false) {
			$selectClause = " select SortingPriceID from sortingprice where ParentID = ? ";

			$result = $this -> db -> query($selectClause,array($idCha));

			if($result -> num_rows() > 0){
				return $result -> result_array();
			}
			return array();
		}

		private function dequy_xoa($idCha = false) {
			global $numTemp;
			if($idCha !== false) {

				$deleteClause = " delete from sortingprice where SortingPriceID = ? ";
				$result = $this -> db -> query($deleteClause,array($idCha));

				if($this -> db -> affected_rows() > 0 ) {
					return true;
				}

			}else {
				return false;
			}
		}

		//delete sortingprice
		public function SortingPrice_delete($id = false) {
			global $numTemp;
			if($id !== false) {
				return $this -> dequy_xoa($id);
			}
			return false;
		}
	}
?>