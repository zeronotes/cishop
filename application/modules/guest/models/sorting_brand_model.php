<?php
	class Sorting_brand_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Products_categories_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$str = $this -> Categories(0,$temp);
				return $str;
			}
		}

		private function Categories($parentid = 0,$array = array()){
			$categories = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {
				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {
				$categories .= "<ul>";
				for ($i=0; $i < count($temp); $i++) {
					// if($temp[$i]['ParentID'] == 0) {
					// 	$categories .= '<li class="re-anchor"><a class="major"';
					// }else {
					// 	$categories .= '<li><a';
					// }
					$categories .= '<li><a';
					$categories .= ' href="'.base_url().$temp[$i]['Slug'].'">'.$temp[$i]["Title"].'</a>';

					$categories .= $this -> Categories($temp[$i]['SortingBrandID'],$array);
					$categories .= '</li>';
				}
				$categories .= "</ul>";
			}
			return $categories;
		}

		public function Get_categories_tree($SortingBrandID) {
            $arrAllChild = Array(); // array that will store all children
            while (true) {
                $arrChild = Array(); // array for storing children in this iteration
                $q = "SELECT `SortingBrandID` FROM `sortingbrand` WHERE `Publish` = 1 AND `ParentID` IN (" . $SortingBrandID . ")";
                $rs = mysql_query($q);
                while ($r = mysql_fetch_assoc($rs)) {
                    $arrChild[] = $r['SortingBrandID'];
                    $arrAllChild[] = $r['SortingBrandID'];
                }
                if (empty($arrChild)) { // break if no more children found
                    break;
                }
                $SortingBrandID = implode(',', $arrChild); // generate comma-separated string of all children and execute the query again
            }
            return ($arrAllChild);
        }

		function Get_top_categories() {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('SortingBrandID,Title_en as Title,Slug');
            } else if ($lang == 'fr'){
            	$this -> db -> select('SortingBrandID,Title_fr as Title,Slug');
            } else {
            	$this -> db -> select('SortingBrandID,Title,Slug');
            }
            $this -> db -> from('sortingbrand');
            $this -> db -> where('ParentID', 0);
            $this -> db -> where('Publish', 1);
            $this -> db -> where('IsTop', 1);
            $this -> db -> order_by('Orders', 'asc');
            $query = $this -> db -> get();
            $parents = $query -> result();
            foreach($parents as $par){
                $parent_list = $this -> Get_categories_tree($par -> SortingBrandID);
                $parent_list[] = $par -> SortingBrandID;
                $par -> products = $this -> Get_child_products($parent_list);
            }
            return $parents;
        }

        private function Get_child_products($ParentID,$limit = 0,$start = 0) {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('products.ProductsID,products.Title_en as Title,products.Description_en as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            } else if ($lang =='fr'){
                $this -> db -> select('products.ProductsID,products.Title_fr as Title,products.Description_fr as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            } else {
                $this -> db -> select('products.ProductsID,products.Title as Title,products.Description as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            }
            $this -> db -> from('products');
            $this -> db -> where_in('SortingBrandID', $ParentID);
            $this -> db -> where('Publish', 1);
            $this -> db -> order_by('Orders', 'asc');
            $this -> db -> order_by('CreatedDate', 'desc');
            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function get_main_cate($limit=false) {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('SortingBrandID,Title_en as Title,Description_en as Description,Slug,ImagesURL');
            } else if ($lang == 'fr'){
                $this -> db -> select('SortingBrandID,Title_fr as Title,Description_fr as Description,Slug,ImagesURL');
            } else {
                $this -> db -> select('SortingBrandID,Title,Description,Slug,ImagesURL');
            }
            $this -> db -> from('sortingbrand');
            $this -> db -> where('ParentID', 0);
            $this -> db -> where('Publish', 1);
            $this -> db -> order_by('Orders', 'asc');
            if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            return $query -> result();
        }

		public function Category_get_for_top() {
			$this -> db -> select("SortingBrandID,Title,ParentID,Slug,ImagesURL");
			$this -> db -> from("sortingbrand");
			$this -> db -> where("Publish",1);
			$this -> db -> where("IsTop",1);
			$this -> db -> order_by("Orders","ModifedDate desc");
			$this -> db -> limit(6);
			$result = $this -> db -> get();

			return $result -> result_array();
		}


		public function Category_get_all_for_menu() {
			$this -> db -> select("SortingBrandID,Title,ParentID,Slug");
			$this -> db -> from("sortingbrand");
			$this -> db -> where("Publish",1);
			$this -> db -> order_by("Orders","ModifedDate desc");
			$result = $this -> db -> get();

			return $this -> Products_categories_recursion($result);
		}

		public function Get_seo_by_slug($slug = false) {
			if($slug !== false) {

				$selectClause = " select SEOTitle,SEOKeyword,SEODescription from sortingbrand where Slug = ? limit 1";
				$result = $this -> db -> query($selectClause,array($slug));

				return $result;
			}else {
				show_404();
			}
		}

		function Get_details_by_id($SortingBrandID) {
			global $lang;
            if($lang == 'en'){
                $this -> db -> select('SortingBrandID,Title_en as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else if ($lang == 'fr'){
                $this -> db -> select('SortingBrandID,Title_fr as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else {
                $this -> db -> select('SortingBrandID,Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            }
            $this -> db -> from('sortingbrand');
            $this -> db -> where('Publish', 1);
            $this -> db -> where('SortingBrandID', $SortingBrandID);
            $query = $this -> db -> get();
            return $query -> row();
        }

        function Get_details($Slug) {
        	global $lang;
            if($lang == 'en'){
                $this -> db -> select('SortingBrandID,Title_en as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else if ($lang == 'fr'){
            	$this -> db -> select('SortingBrandID,Title_fr as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else {
            	$this -> db -> select('SortingBrandID,Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            }
            $this -> db -> from('sortingbrand');
            $this -> db -> where('Publish', 1);
            $this -> db -> where('Slug', $Slug);
            $query = $this -> db -> get();
            return $query -> row();
        }
	}
?>