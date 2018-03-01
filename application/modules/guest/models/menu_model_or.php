<?php
	class Menu_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Menu_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$str = $this -> Menu(0,$temp);
				$menu_for_footer = $this -> Menu_for_footer(0,$temp);
				return array('menu'=>$str,'menu_for_footer' => $menu_for_footer);
			}
		}

		private function Menu($parentid = 0,$array = array()){
			$menu = "";
			$temp = array();
			for ($i=0; $i < count($array); $i++) {

				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			if(count($temp) > 0) {

				$menu .= "<ul>";

				for ($i=0; $i < count($temp); $i++) {

					$menu .= '<li>';

					if($temp[$i]['IsNewTab'] == 1) {
						$menu .= '<a target="_blank" href="'.base_url().$temp[$i]['Url'].'">'.$temp[$i]["Title"].'</a>';
					}
					else {
						$menu .= '<a href="'.base_url().$temp[$i]['Url'].'">'.$temp[$i]["Title"].'</a>';
					}

					$menu .= $this -> menu($temp[$i]['MenuID'],$array);
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

		public function Menu_get_all($limit_start=false,$limit_show=false) {
			$selectClause = " menu.MenuID,menu.ParentID,menu.Title,menu.IsStatic,menu.Url,
								menu.Publish,menu.Orders,menu.IsNewTab, ";

			$this -> db -> select($selectClause);
			$this -> db -> from("menu");
			$this -> db -> where("Publish",1);
			$this -> db -> order_by("Orders","menu.Modified desc","menu.CreatedDate desc");

			$result = $this -> db -> get();

			return $this -> Menu_recursion($result);
		}

		public function Check_exist_static($slug = false) {
			$selectClause = " count(menu.MenuID) as count from menu";
			$this -> db -> select($selectClause);
			$this -> db -> where("menu.Slug",$slug);
			$this -> db -> where("menu.IsStatic",1);
			$result = $this -> db -> get() -> row_array();

			if($result['count'] > 0){
				return true;
			}

			return false;
		}

		public function Get_static_content($slug = false) {
			$selectClause = " StaticContent from menu";
			$this -> db -> select($selectClause);
			$this -> db -> where("menu.Slug",$slug);
			$result = $this -> db -> get() -> row_array();

			return $result['StaticContent'];
		}
	}
?>