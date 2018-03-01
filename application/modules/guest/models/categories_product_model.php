<?php
	class Categories_product_model extends Cms_Base_model {
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
                    //  $categories .= '<li class="re-anchor"><a class="major"';
                    // }else {
                    //  $categories .= '<li><a';
                    // }
                    $categories .= '<li><a';
                    $categories .= ' href="'.base_url().$temp[$i]['Slug'].'">';
                    if($temp[$i]['ParentID'] == 0) {

                     $categories .= '<span class="mc_title">'.$temp[$i]['Title'].'<i class="fa fa-chevron-right hidden-md"></i></span>';

                    }else {

                        $categories .= '<span class="mc_title">'.$temp[$i]['Title'].'</span>';

                     

                    }
                    // $categories .= '<span class="mc_desc hidden-md hidden-sm hidden-xs">'.$temp[$i]['Description'].'</span>';
                    $categories .= '</a>';

                    $categories .= $this -> Categories($temp[$i]['CategoriesProductsID'],$array);
                    $categories .= '</li>';
                }
                $categories .= "</ul>";
            }
            return $categories;
        }

		public function Get_categories_tree($CategoriesProductsID) {
            $arrAllChild = Array(); // array that will store all children
            while (true) {
                $arrChild = Array(); // array for storing children in this iteration
                $q = "SELECT `CategoriesProductsID` FROM `categoriesproducts` WHERE `Publish` = 1 AND `ParentID` IN (" . $CategoriesProductsID . ")";
                $rs = mysql_query($q);
                while ($r = mysql_fetch_assoc($rs)) {
                    $arrChild[] = $r['CategoriesProductsID'];
                    $arrAllChild[] = $r['CategoriesProductsID'];
                }
                if (empty($arrChild)) { // break if no more children found
                    break;
                }
                $CategoriesProductsID = implode(',', $arrChild); // generate comma-separated string of all children and execute the query again
            }
            return ($arrAllChild);
        }

		function Get_top_categories() {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('CategoriesProductsID,Title_en as Title,Slug');
            } else if ($lang == 'fr'){
            	$this -> db -> select('CategoriesProductsID,Title_fr as Title,Slug');
            } else {
            	$this -> db -> select('CategoriesProductsID,Title,Slug');
            }
            $this -> db -> from('categoriesproducts');
            $this -> db -> where('ParentID', 0);
            $this -> db -> where('Publish', 1);
            $this -> db -> where('IsTop', 1);
            $this -> db -> order_by('Orders', 'asc');
            $query = $this -> db -> get();
            $parents = $query -> result();
            foreach($parents as $par){
                $parent_list = $this -> Get_categories_tree($par -> CategoriesProductsID);
                $parent_list[] = $par -> CategoriesProductsID;
                $par -> products = $this -> Get_child_products($parent_list);
                $par -> childCate = $childCate = $this -> Get_top_child_cate($par -> CategoriesProductsID);
                $par -> ads = $this -> Get_ads($par -> CategoriesProductsID);
                // if($childCate){
                //     foreach ($childCate as $children) {
                //         $parent_list_child = $this -> Get_categories_tree($children -> CategoriesProductsID);
                //         $parent_list_child[] = $children -> CategoriesProductsID;
                //         $children -> products = $this -> Get_child_products($parent_list_child);
                //     }
                // }
            }
            return $parents;
        }

        public function Get_top_child_cate($ParentID){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('CategoriesProductsID,Title_en as Title,Description_en as Description,Slug,ImagesURL');
            } else if ($lang == 'fr'){
                $this -> db -> select('CategoriesProductsID,Title_fr as Title,Description_fr as Description,Slug,ImagesURL');
            } else {
                $this -> db -> select('CategoriesProductsID,IsTop,Title,Description,Slug,ImagesURL');
            }
            $this -> db -> from('categoriesproducts');
            $this -> db -> where_in('ParentID', $ParentID);
            $this -> db -> where('Publish', 1);
            $this -> db -> order_by('Orders', 'asc');
            $this -> db -> order_by('CreatedDate', 'desc');
            $query = $this -> db -> get();
            $result = $query -> result();
            
            if($query -> num_rows() != 0){
                return $result;
            } else {
                return false;
            }
        }

        public function Get_child_products($ParentID,$limit = 0,$start = 0) {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('products.ProductsID,products.SKU,products.Title_en as Title,products.Description_en as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            } else if ($lang =='fr'){
                $this -> db -> select('products.ProductsID,products.SKU,products.Title_fr as Title,products.Description_fr as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            } else {
                $this -> db -> select('products.ProductsID,products.SKU,products.Title as Title,products.IsNew,products.Description as Description,products.Slug,products.ImageURL,products.ImageAlt,products.SellPrice,products.ListPrice,products.CreatedDate');
            }
            $this -> db -> from('products');
            $this -> db -> where_in('CategoriesProductsID', $ParentID);
            $this -> db -> where('Publish', 1);
            // $this -> db -> where('IsHot', 1);
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
                    $re -> SellPrice = number_format($re -> SellPrice, 0, ',', '.');
                    $re -> ListPrice = number_format($re -> ListPrice, 0, ',', '.');
                }
                return $result;
            } else {
                return false;
            }
        }

        private function Get_ads($CategoriesProductsID) {
            global $lang;
            $this -> db -> select('ads.Title,ads.ImageURL,ads.Height,ads.Width,ads.Link');
            $this -> db -> from('ads');
            $this -> db -> join('adsgroups', 'ads.AdsGroupsID = adsgroups.AdsGroupsID');
            $this -> db -> where('adsgroups.CategoriesProductsID', $CategoriesProductsID);
            $this -> db -> where('ads.Publish', 1);
            $this -> db -> order_by('ads.Orders', 'asc');
            $this -> db -> order_by('ads.CreatedDate', 'desc');
            $query = $this -> db -> get();
            return $query -> result();
        }

        function get_main_cate($limit=false) {
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('CategoriesProductsID,Title_en as Title,Description_en as Description,Slug,ImagesURL');
            } else if ($lang == 'fr'){
                $this -> db -> select('CategoriesProductsID,Title_fr as Title,Description_fr as Description,Slug,ImagesURL');
            } else {
                $this -> db -> select('CategoriesProductsID,Title,Description,Slug,ImagesURL');
            }
            $this -> db -> from('categoriesproducts');
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
			$this -> db -> select("CategoriesProductsID,Title,ParentID,Slug,ImagesURL");
			$this -> db -> from("categoriesproducts");
			$this -> db -> where("Publish",1);
			$this -> db -> where("IsTop",1);
			$this -> db -> order_by("Orders","ModifedDate desc");
			$this -> db -> limit(6);
			$result = $this -> db -> get();

			return $result -> result_array();
		}


		public function Category_get_all_for_menu() {
			$this -> db -> select("CategoriesProductsID,Title,ParentID,Slug,Description");
			$this -> db -> from("categoriesproducts");
			$this -> db -> where("Publish",1);
			$this -> db -> order_by("Orders", "asc");
            $this -> db -> order_by("CreatedDate", "desc");
			$result = $this -> db -> get();

			return $this -> Products_categories_recursion($result);
		}

		public function Get_seo_by_slug($slug = false) {
			if($slug !== false) {

				$selectClause = " select SEOTitle,SEOKeyword,SEODescription from categoriesproducts where Slug = ? limit 1";
				$result = $this -> db -> query($selectClause,array($slug));

				return $result;
			}else {
				show_404();
			}
		}

		function Get_details_by_id($CategoriesProductsID) {
			global $lang;
            if($lang == 'en'){
                $this -> db -> select('CategoriesProductsID,Title_en as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else if ($lang == 'fr'){
                $this -> db -> select('CategoriesProductsID,Title_fr as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            } else {
                $this -> db -> select('CategoriesProductsID,Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription');
            }
            $this -> db -> from('categoriesproducts');
            $this -> db -> where('Publish', 1);
            $this -> db -> where('CategoriesProductsID', $CategoriesProductsID);
            $query = $this -> db -> get();
            return $query -> row();
        }

        function Get_details($Slug) {
        	global $lang;
            if($lang == 'en'){
                $this -> db -> select('CategoriesProductsID,Title_en as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription,SortingPrice,SortingBrand,SortingRes,SortingChannel');
            } else if ($lang == 'fr'){
            	$this -> db -> select('CategoriesProductsID,Title_fr as Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription,SortingPrice,SortingBrand,SortingRes,SortingChannel');
            } else {
            	$this -> db -> select('CategoriesProductsID,Title,Slug,Description,Body,ImagesURL,SEOTitle,SEOKeyword,SEODescription,SortingPrice,SortingBrand,SortingRes,SortingChannel');
            }
            $this -> db -> from('categoriesproducts');
            $this -> db -> where('Publish', 1);
            $this -> db -> where('Slug', $Slug);
            $query = $this -> db -> get();
            $result = $query -> row();

            return $result;
        }

        private function Get_Sorting_Brand($result){
            global $lang;
            $array = explode(",",$result);
            $this -> db -> select('SortingBrandID,Title,Slug');
            $this -> db -> from('sortingbrand');
            $this -> db -> where('Publish', 1);
            $this -> db -> where_in('SortingBrandID',$array);
            $query = $this -> db -> get();
            return $query -> result();
        }

        private function Get_Sorting_Price($result){
            global $lang;
            $array = explode(",",$result);
            $this -> db -> select('SortingPriceID,Title');
            $this -> db -> from('sortingprice');
            $this -> db -> where('Publish', 1);
            $this -> db -> where_in('SortingPriceID',$array);
            $query = $this -> db -> get();
            return $query -> result();
        }

        private function Get_Sorting_Res($result){
            global $lang;
            $array = explode(",",$result);
            $this -> db -> select('SortingResID,Title');
            $this -> db -> from('sortingres');
            $this -> db -> where('Publish', 1);
            $this -> db -> where_in('SortingResID',$array);
            $query = $this -> db -> get();
            return $query -> result();
        }

        private function Get_Sorting_Channel($result){
            global $lang;
            $array = explode(",",$result);
            $this -> db -> select('SortingChannelID,Title');
            $this -> db -> from('sortingchannel');
            $this -> db -> where('Publish', 1);
            $this -> db -> where_in('SortingChannelID',$array);
            $query = $this -> db -> get();
            return $query -> result();
        }
	}
?>