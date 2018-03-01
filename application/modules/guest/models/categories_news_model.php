<?php
	class Categories_news_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function news_categories_recursion($result = false,$cateNewsActive = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$str = $this -> Categories(0,$temp,$cateNewsActive);
				return $str;
			}
			return "";
		}

		private function Categories($parentid = 0,$array = array(),$cateNewsActive = false){
			$categories = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}
			$categories .= "<ul>";

			if($parentid == 0) {
				$categories .= '<li';
				if($cateNewsActive !== false && $cateNewsActive == 'home') {
					$categories .= ' class="menu-active" ';
				}
				$categories .= ' ><a href="'.base_url().'tin-tuc/">Home</a><ul style="height:36px;"></ul></li>';
			}


			for ($i=0; $i < count($temp); $i++) {

				$categories .= '<li ';

				if($cateNewsActive !== false && $cateNewsActive == $temp[$i]['CategoriesNewsID']) {
					$categories .= ' class="menu-active" ';
				}

				$categories .= ' ><a';
				$categories .= ' href="'.base_url().'tin-tuc/'.$temp[$i]['Slug'].'">'.$temp[$i]["Title"].'</a>';

				$categories .= $this -> Categories($temp[$i]['CategoriesNewsID'],$array);
				$categories .= '</li>';
			}
			$categories .= "</ul>";

			return $categories;
		}

		function Get_details($slug){
			global $lang;
			if($lang == 'en'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_en as Title,categoriesnews.Slug,categoriesnews.CategoriesNewsID,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			} else if($lang == 'fr'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_fr as Title,categoriesnews.Slug,categoriesnews.CategoriesNewsID,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			} else {
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title,categoriesnews.Slug,categoriesnews.CategoriesNewsID,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			}
            $this -> db -> from('categoriesnews');
            $this -> db -> where('categoriesnews.Publish', 1);
            $this -> db -> where('categoriesnews.Slug', $slug);
            $query = $this -> db -> get();
            if ($query -> num_rows() > 0){
            	return $query -> row();
            } else {
            	return false;
            }
        }

        function Get_details_by_id($id){
			global $lang;
			if($lang == 'en'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_en as Title,categoriesnews.Slug,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			} else if($lang == 'fr'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_fr as Title,categoriesnews.Slug,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			} else {
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title,categoriesnews.Slug,categoriesnews.SEOTitle,categoriesnews.SEOKeyword,categoriesnews.SEODescription,categoriesnews.Banner');
			}
            $this -> db -> from('categoriesnews');
            $this -> db -> where('categoriesnews.Publish', 1);
            $this -> db -> where('categoriesnews.CategoriesNewsID', $id);
            $query = $this -> db -> get();
            return $query -> row();
        }

        function Get_main_categories($limit = 0,$start = 0){
        	global $lang;
			if($lang == 'en'){
				$this -> db -> select('categoriesnews.Banner,categoriesnews.CategoriesNewsID,categoriesnews.Title_en as Title,categoriesnews.Slug');
			} else if($lang == 'fr'){
				$this -> db -> select('categoriesnews.Banner,categoriesnews.CategoriesNewsID,categoriesnews.Title_fr as Title,categoriesnews.Slug');
			} else {
				$this -> db -> select('categoriesnews.Banner,categoriesnews.CategoriesNewsID,categoriesnews.Title,categoriesnews.Slug');
			}
			$this -> db -> from('categoriesnews');
            $this -> db -> where('categoriesnews.Publish', 1);
            $this -> db -> where('categoriesnews.IsHot', 1);
            $this -> db -> order_by("Orders","asc");
            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            $parents = $query -> result();
            foreach($parents as $par){
            	$parent_list = $this -> Get_categories_tree($par -> CategoriesNewsID);
            	$parent_list[] = $par -> CategoriesNewsID;
            	$par -> news = $this -> Get_child_news($parent_list,5);
            }
            return $parents;
        }

        function Get_sub_categories(){
        	global $lang;
			if($lang == 'en'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_en as Title,categoriesnews.Slug');
			} else if($lang == 'fr'){
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title_fr as Title,categoriesnews.Slug');
			} else {
				$this -> db -> select('categoriesnews.CategoriesNewsID,categoriesnews.Title,categoriesnews.Slug');
			}
			$this -> db -> from('categoriesnews');
            $this -> db -> where('categoriesnews.Publish', 1);
            $this -> db -> where('categoriesnews.IsCool', 1);
            $this -> db -> where('categoriesnews.ParentID', 0);
            $this -> db -> order_by("Orders","asc");
            $query = $this -> db -> get();
            $parents = $query -> result();
            foreach($parents as $par){
            	$parent_list = $this -> Get_categories_tree($par -> CategoriesNewsID);
            	$parent_list[] = $par -> CategoriesNewsID;
            	$par -> news = $this -> Get_child_news($parent_list,5);
            }
            return $parents;
        }

        public function Get_categories_tree($CategoriesNewsID) {
            $arrAllChild = Array(); // array that will store all children
            while (true) {
                $arrChild = Array(); // array for storing children in this iteration
                $q = "SELECT `CategoriesNewsID` FROM `categoriesnews` WHERE `Publish` = 1 AND `ParentID` IN (" . $CategoriesNewsID . ")";
                $rs = mysql_query($q);
                while ($r = mysql_fetch_assoc($rs)) {
                    $arrChild[] = $r['CategoriesNewsID'];
                    $arrAllChild[] = $r['CategoriesNewsID'];
                }
                if (empty($arrChild)) { // break if no more children found
                    break;
                }
                $CategoriesNewsID = implode(',', $arrChild); // generate comma-separated string of all children and execute the query again
            }
            return ($arrAllChild);
        }

        public function Get_child_news($ParentID,$limit = 0,$start = 0) {
            global $lang;
            if ($lang == 'en'){
                $this -> db -> select('news.Title_en as Title,news.Description_en as Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            } else if ($lang == 'fr'){
                $this -> db -> select('news.Title_fr as Title,news.Description_fr as Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            } else {
                $this -> db -> select('news.Title,news.Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> where_in('CategoriesNewsID', $ParentID);
            $this -> db -> where('Publish', 1);
            $this -> db -> order_by('IsHot', 'desc');
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

        function Get_breadcrumb($CategoriesNewsID, $breadcrumb_list = false){
        	$this -> db -> select('ParentID, Title, Slug');
            $this -> db -> from('categoriesnews');
            $this -> db -> where('Publish', 1);
            $this -> db -> where('CategoriesNewsID', $CategoriesNewsID);
            $query = $this -> db -> get();
            $breadcrumb = $query -> row();
            $breadcrumb_list[] = $breadcrumb;
            
            if ($breadcrumb -> ParentID != 0) {
                return $this -> Get_breadcrumb($breadcrumb -> ParentID, $breadcrumb_list);
            } else {
                return $breadcrumb_list;
            }
        }

		public function Get_seo_by_slug($slug = false) {
			if($slug !== false) {

				$selectClause = " select SEOTitle,SEOKeyword,SEODescription from categoriesnews where Slug = ? limit 1";
				$result = $this -> db -> query($selectClause,array($slug));

				return $result;
			}else {
				show_404();
			}
		}

	}
?>