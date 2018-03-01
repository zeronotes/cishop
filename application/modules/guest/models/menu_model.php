<?php
	class Menu_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Menu_recursion($result = false,$menuActive = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$str = $this -> Menu(0,$temp,$menuActive);
				// $menu_for_footer = $this -> Menu_for_footer(0,$temp);
				// return array('menu'=>$str,'menu_for_footer' => $menu_for_footer);
				return $str;
			}
			return "";
		}

		private function MenuResponsive_recursion($result = false,$menuActive = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$str = $this -> MenuResponsive(0,$temp,$menuActive);
				// $menu_for_footer = $this -> Menu_for_footer(0,$temp);
				// return array('menu'=>$str,'menu_for_footer' => $menu_for_footer);
				return $str;
			}
			return "";
		}

		private function Menu($parentid = 0,$array = array(),$menuActive = false){
			$this -> load -> model('categories_product_model');
			$menu_tree = $this -> categories_product_model -> Category_get_all_for_menu();

			$menu = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {

				//$current_url_no_query = $this->config->site_url().$this->uri->uri_string();

				$menu .= "<ul id='menu'>";
				for ($i=0; $i < count($temp); $i++) {
					if($this -> checkHasChild($temp[$i]['MenuID'])){
						$menu .= '<li class="hasChild" ';
					} else {
						$menu .= '<li ';
					}
					// $menu .= ( $temp[$i]['ParentID'] == 0 && $this -> checkHasChild($temp[$i]['MenuID'],true) ) ? 'style="background: url(../../resources/ui_images/client/images/backgrounds/arrows5px.png) center right no-repeat;"' : '';
					if($temp[$i]['Url'] == $menuActive) {
						$menu .= ' class="active-menu" ';
					}

					$menu .= ' ><a';

					if($temp[$i]['IsNewTab'] == 1) {
						$menu .= ' target="_blank" ';
					}

					if($temp[$i]['Url'] == 'tin-tuc/giao-hang') {
						$menu .= ' class="transfer" ';
					}

					$menu .= ' href="';

					if($temp[$i]['IsClick'] != 1) {
						$menu .= 'javascript:void(0);';
					}else {
						//$menu .= site_url($this->lang->lang()).'/'.$temp[$i]['Url'];
						if ($temp[$i]['Types']=='External') {
							$menu .= $temp[$i]['Url'];
						}else {
							$menu .= base_url() . $temp[$i]['Url'];
						}
						
					}
					$menu .= '">';
					//$menu .= $this->lang->lang() == 'vi' ? $temp[$i]["Title"] : $temp[$i]["Title_en"];
					$menu .= $temp[$i]["Title"];
					//$menu .= ( $temp[$i]['ParentID'] != 0 && $this -> checkHasChild($temp[$i]['MenuID'],false) ) ? '<span style="float:right;margin:0 10px 0 0;color:#ff6f1e;">»</span>' : '';
					$menu .='</a>';
					if($temp[$i]['Url'] == 'san-pham'){
						$menu .= $menu_tree;
					}

					$menu .= $this -> Menu($temp[$i]['MenuID'],$array);
					$menu .= '</li>';
				}
				$menu .= "</ul>";
			}
			return $menu;
		}

		private function MenuResponsive($parentid = 0,$array = array(),$menuActive = false){
			$menu = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {

				//$current_url_no_query = $this->config->site_url().$this->uri->uri_string();

				$menu .= "<ul class=\"nav navbar-nav\">";
				for ($i=0; $i < count($temp); $i++) {
					$menu .= '<li ';
					// $menu .= ( $temp[$i]['ParentID'] == 0 && $this -> checkHasChild($temp[$i]['MenuID'],true) ) ? 'style="background: url(../../resources/ui_images/client/images/backgrounds/arrows5px.png) center right no-repeat;"' : '';
					if($temp[$i]['Url'] == $menuActive) {
						$menu .= ' class="active-menu" ';
					}

					if($temp[$i]['IsClick'] != 1) {
						$menu .= ' class="dropdown" ';
					}

					$menu .= ' ><a';

					if($temp[$i]['IsNewTab'] == 1) {
						$menu .= ' target="_blank" ';
					}

					$menu .= ' href="';
					if($temp[$i]['IsClick'] != 1) {
						$menu .= '#"';
						$menu .= '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
					}else {
						//$menu .= site_url($this->lang->lang()).'/'.$temp[$i]['Url'];
						$menu .= base_url() . $temp[$i]['Url'];
						$menu .= '">';
					}
					//$menu .= $this->lang->lang() == 'vi' ? $temp[$i]["Title"] : $temp[$i]["Title_en"];
					$menu .= $temp[$i]["Title"];
					//$menu .= ( $temp[$i]['ParentID'] != 0 && $this -> checkHasChild($temp[$i]['MenuID'],false) ) ? '<span style="float:right;margin:0 10px 0 0;color:#ff6f1e;">»</span>' : '';
					if($temp[$i]['IsClick'] != 1) {
						$menu .=' <span class="caret"></span></a>';
					} else {
						$menu .='</a>';
					}
					$menu .= $this -> MenuResponsive2($temp[$i]['MenuID'],$array);
					$menu .= '</li>';
				}
				$menu .= "</ul>";
			}
			return $menu;
		}

		private function MenuResponsive2($parentid = 0,$array = array(),$menuActive = false){
			$menu = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {

				//$current_url_no_query = $this->config->site_url().$this->uri->uri_string();

				$menu .= "<ul class=\"dropdown-menu\">";
				for ($i=0; $i < count($temp); $i++) {
					$menu .= '<li ';
					// $menu .= ( $temp[$i]['ParentID'] == 0 && $this -> checkHasChild($temp[$i]['MenuID'],true) ) ? 'style="background: url(../../resources/ui_images/client/images/backgrounds/arrows5px.png) center right no-repeat;"' : '';
					if($temp[$i]['Url'] == $menuActive) {
						$menu .= ' class="active-menu" ';
					}

					if($temp[$i]['IsClick'] != 1) {
						$menu .= ' class="dropdown-submenu" ';
					}

					$menu .= ' ><a';

					if($temp[$i]['IsNewTab'] == 1) {
						$menu .= ' target="_blank" ';
					}

					$menu .= ' href="';
					if($temp[$i]['IsClick'] != 1) {
						$menu .= '#"';
						$menu .= '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
					}else {
						//$menu .= site_url($this->lang->lang()).'/'.$temp[$i]['Url'];
						$menu .= base_url() . $temp[$i]['Url'];
						$menu .= '">';
					}
					//$menu .= $this->lang->lang() == 'vi' ? $temp[$i]["Title"] : $temp[$i]["Title_en"];
					$menu .= $temp[$i]["Title"];
					//$menu .= ( $temp[$i]['ParentID'] != 0 && $this -> checkHasChild($temp[$i]['MenuID'],false) ) ? '<span style="float:right;margin:0 10px 0 0;color:#ff6f1e;">»</span>' : '';
					if($temp[$i]['IsClick'] != 1) {
						$menu .=' <span class="caret"></span></a>';
					} else {
						$menu .='</a>';
					}
					$menu .= $this -> MenuResponsive2($temp[$i]['MenuID'],$array);
					$menu .= '</li>';
				}
				$menu .= "</ul>";
			}
			return $menu;
		}

		private function Menu_for_footer($parentid = 0,$array = array()){
			$menu = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {

				$menu .= "";

				for ($i=0; $i < count($temp); $i++) {


					if($temp[$i]['IsNewTab'] == 1) {
						$menu .= '<a target="_blank" href="'.base_url().$temp[$i]['Url'].'">'.$temp[$i]["Title"].'</a>';
					}
					else {
						$menu .= '<a href="'.base_url().$temp[$i]['Url'].'">'.$temp[$i]["Title"].'</a>';
					}

					if($i < count($temp) - 1) {
						$menu .= '&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}
				$menu .= "";

			}

			return $menu;
		}

		public function getMenuForFooter() {

			global $lang;

			$selectClause = " ";

			if($lang == 'vi') {
				$selectClause .= ' menu.Title, ';
			}else {
				$selectClause .= ' menu.Title_en as Title, ';
			}

			$selectClause .= " menu.MenuID,menu.ParentID,menu.IsStatic,menu.Url,
								menu.Publish,menu.Orders,menu.IsNewTab,menu.IsClick ";

			$this -> db -> select($selectClause);
			$this -> db -> from("menu");
			$this -> db -> where("Publish",1);
			$this -> db -> where("ParentID",0);
			$this -> db -> order_by("Orders");

			$result = $this -> db -> get();

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		//Hàm lấy menu chính
		public function Menu_get_all($menuActive = false) {
			$selectClause = " menu.MenuID,menu.ParentID,menu.Title,menu.IsStatic,menu.Url,
								menu.Publish,menu.Orders,menu.IsNewTab,menu.IsClick,menu.Types ";

			$this -> db -> select($selectClause);
			$this -> db -> from("menu");
			$this -> db -> where("Publish",1);
			$this -> db -> order_by("Orders");

			$result = $this -> db -> get();

			return $this -> Menu_recursion($result,$menuActive);
		}

		public function MenuResponsive_get_all($menuActive = false) {
			$selectClause = " menu.MenuID,menu.ParentID,menu.Title,menu.IsStatic,menu.Url,
								menu.Publish,menu.Orders,menu.IsNewTab,menu.IsClick,menu.Types ";

			$this -> db -> select($selectClause);
			$this -> db -> from("menu");
			$this -> db -> where("Publish",1);
			$this -> db -> order_by("Orders");

			$result = $this -> db -> get();

			return $this -> MenuResponsive_recursion($result,$menuActive);
		}

		public function getById($id = false) {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title, ';
			}else {
				$selectClause .= ' Title_en as Title, ';
			}

			$selectClause .= " MenuID,Slug from menu where Publish = 1 and MenuID = ? limit 1 ";

			$result = $this -> db -> query($selectClause,$id);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();

				return $result;
			}
			return false;
		}

		public function getBySlug($slug = false) {
			global $lang;

			$selectClause = " select ";

			if ($lang == 'en') {
				$selectClause .= ' Title_en as Title, StaticContent_en as StaticContent,SEOTitle,SEOKeyword,SEODescription';
			}else if ($lang == 'fr') {
				$selectClause .= ' Title_fr as Title, StaticContent_fr as StaticContent,SEOTitle,SEOKeyword,SEODescription';
			}else {
				$selectClause .= ' Title, StaticContent,SEOTitle,SEOKeyword,SEODescription';
			}

			$selectClause .= " ,MenuID,Slug from menu where Publish = 1 and Slug = ? limit 1 ";

			$result = $this -> db -> query($selectClause,$slug);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();

				return $result;
			}
			return false;
		}

		public function getAllParentMenu() {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title, ';
			}else {
				$selectClause .= ' Title_en as Title, ';
			}

			$selectClause .= " MenuID,Url,Slug from menu where Publish = 1 and ParentID = 0 order by Orders ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getAllFoSmallColumn($Id  = false) {
			$menuArr = $this -> getAllParentOfMenuChild($Id);
			$menuArr = $this -> getALlChildOfMenuParent($menuArr[sizeof($menuArr)-1]['MenuID']);

			return $menuArr;
		}

		public function getAllFoSmallColumnByURI($URI  = false) {

			$menuTemp = $this -> getCateByURI($URI);

			if($menuTemp) {
				$menuArr = $this -> getAllParentOfMenuChild($menuTemp['MenuID']);
				$menuArr = $this -> getALlChildOfMenuParent($menuArr[sizeof($menuArr)-1]['MenuID']);

				return $menuArr;
			}

			return array();
		}

		private function getCateByURI($URI = false) {
			$selectClause = " select MenuID from menu where Url = ? ";

			$result = $this -> db -> query($selectClause,array($URI));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return false;
		}

		public function getAllParentOfMenuChild($cateId = false) {
			//if($cateId !== false) {
				global $lang;

				$selectClause = " select ";

				if($lang == 'vi') {
					$selectClause .= ' Title, ';
				}else {
					$selectClause .= ' Title_en as Title, ';
				}

				$selectClause .= " MenuID,ParentID,Url,Slug from menu where Publish = 1 and MenuID = ? limit 1 ";

				$result = $this -> db -> query($selectClause,$cateId);

				if($result -> num_rows() > 0) {
					$result = $result -> row_array();

					$temp[] = $result;

					if($result['ParentID'] != 0) {
						$yeah = $this -> getAllParentOfMenuChild($result['ParentID']);

						foreach ($yeah as $key) {
							$temp[] = $key;
						}
					}
				}else {
					$temp[] = false;
				}
			//}

			return $temp;
		}

		private function getALlChildOfMenuParent($Id = false,$temp = array()) {
			$temp[] = $this -> getById($Id);
			if($Id !== false) {
				global $lang;

				$selectClause = " select ";

				if($lang == 'vi') {
					$selectClause .= ' Title, ';
				}else {
					$selectClause .= ' Title_en as Title, ';
				}
				$selectClause .= " MenuID,ParentID,Url,Slug from menu where Publish = 1 and ParentID = ? order by Orders ";

				$result = $this -> db -> query($selectClause,$Id);
				if($result -> num_rows() > 0) {
					$result = $result -> result_array();
					foreach ($result as $key) {
						$temp[] = $key;
						$this -> getALlChildOfMenuParent($key['MenuID'],$temp);
					}
				}
			}

			return $temp;
		}

		public function checkHasChild($menuId = false,$allowParent = false) {

			if($menuId && $allowParent == false) {

				$selectClause = " select count(MenuID) as count from menu where Publish = 1 and ParentID = ? ";

			}else if($allowParent == true) {
				$selectClause = " select count(MenuID) as count from menu where Publish = 1 and ParentID = ? ";
			}

			if(isset($selectClause)) {

				$result = $this -> db -> query($selectClause,array($menuId));

				if($result -> num_rows() > 0) {
					$result = $result -> row_array();

					return $result['count'];
				}
			}
			return 0;
		}

		public function Check_exist_static($slug = false) {
			$selectClause = " menu.MenuID,SEOTitle,SEOKeyword,SEODescription from menu";
			$this -> db -> select($selectClause);
			$this -> db -> where("menu.Slug",$slug);
			$this -> db -> where("menu.IsStatic",1);
			$result = $this -> db -> get();

			if($result -> num_rows() > 0){
				return $result -> row_array();
			}
			return false;
		}

		public function Get_static_content($slug = false) {

			global $lang;

			$selectClause = "";

			if($lang == 'vi') {
				$selectClause .= ' StaticContent, ';
			}else {
				$selectClause .= ' StaticContent_en as StaticContent, ';
			}
			$selectClause .= " Banner from menu ";
			$this -> db -> select($selectClause);
			$this -> db -> where("menu.Slug",$slug);
			$result = $this -> db -> get() -> row_array();

			return $result;
		}

		public function Menu_sub_get_all(){
			global $lang;
            if ($lang == 'en'){
                $this -> db -> select('Title_en as Title,Description_en as Description,Url,Slug,Banner,IsNewTab,IsClick');
            } else {
                $this -> db -> select('Title,Description,Url,Slug,Banner,IsNewTab,IsClick');
            }
            $this -> db -> from('menuhot');
            $this -> db -> where('Publish', 1);
            $this -> db -> order_by('Orders', 'asc');
            $this -> db -> order_by('CreatedDate', 'desc');
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                return $result;
            } else {
                return false;
            }
		}
	}
?>