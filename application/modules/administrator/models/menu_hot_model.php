<?php
	class Menu_hot_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Menu_recursion($result = false) {
			if($result !== false) {
				$result = $result -> result_array();
				$temp = $result;
				$temp = $this -> Menu(0,$temp);
				return $temp;
			}
		}


		function Menu($parentid = 0,$array = array(),$space = '|-----',$trees = array()){

			// for ($y=0; $y < count($array); $y++) {
			// 	if($array[$y]["Menu"] == $parentid) {
			// 		$array[$y]["Title"] = $space.$array[$y]['Title'];
			// 		$array[$y] = $array[$y];
			// 	}
			// }
			$temp = array();
			for ($i=0; $i < count($array); $i++) {
				// if($parentid == 0) {
				// 	$trees[] = $array[$i];
				// }else {
					// if($array[$i]["ParentID"] == $parentid ) {
					// 	// if($parentid == 0) {
					// 	// 	$array[$i]["Title"] = $space.$array[$i]['Title'];
					// 	// }else {
					// 		$array[$i]["Title"] = $space.$array[$i]['Title'];
					// 	// }
					// 	$trees[] = $array[$i];
					// 	// for ($y=0; $y < count($array); $y++) {
					// 	// 	if($array[$y]["ParentID"] == $parentid) {
					// 	// 		$trees[] = $array[$y];
					// 	// 	}
					// 	// }
					// 	$trees = $this -> Menu($array[$i]['MenuID'],$trees,$space.'^-----');
					// }else if($array[$i]["ParentID"] != $parentid) {
					// 	$trees[] = $array[$i];
					// }
				//}
				if($array[$i]["ParentID"] == $parentid) $temp[] = $array[$i];
			}

			for ($i=0; $i < count($temp); $i++) {
				$temp[$i]["Title"] = $space.$temp[$i]['Title'];
				$trees[] = $temp[$i];
				$trees = $this -> Menu($temp[$i]['MenuID'],$array,$space.'-----',$trees);
			}

			// while($rs = mysql_fetch_assoc($sql)){
			// 	$trees[] = array('id'=>$rs['cat_id'],'title'=>$space.$rs['cat_title']);
			// 	$trees = Menu($rs['cat_id'],$space.'--',$trees);
			// }
			return $trees;
		}

		public function Menu_get_all($limit_start=false,$limit_show=false) {
			$selectClause = " menuhot.MenuID,menuhot.ParentID,menuhot.Title, CAST(menuhot.IsStatic as UNSIGNED INT) as IsStatic,
								CAST(menuhot.Publish as UNSIGNED INT) as Publish, CAST(menuhot.IsClick as UNSIGNED INT) as IsClick, menuhot.Orders,CAST(menuhot.IsNewTab as UNSIGNED INT) as IsNewTab, ";
			$selectClause .= " (select count(menuhot.MenuID) from menuhot) as count";

			$this -> db -> select($selectClause);
			$this -> db -> from("menuhot");

			$this -> db -> order_by("menuhot.Orders", "asc");

			$this -> db -> limit($limit_show,$limit_start);

			$result = $this -> db -> get();

			return $this -> Menu_recursion($result);
		}

		public function Menu_get_all_to_select() {
			$selectClause = " menuhot.MenuID,menuhot.ParentID,menuhot.Title";

			$this -> db -> select($selectClause);

			$this -> db -> from("menuhot");

			$result = $this -> db -> get();

			return $this -> Menu_recursion($result);
		}

		public function Menu_get_except_by_id($id = false) {
			if($id !== false) {
				$selectClause = " menuhot.MenuID,menuhot.ParentID,menuhot.Title";

				$this -> db -> select($selectClause);

				$this -> db -> from("menuhot");

				$this -> db -> where("menuhot.MenuID not like ".$id.";");

				$result = $this -> db -> get();

				return $this -> Menu_recursion($result);
			}else {
				show_404();
			}
		}

		public function Menu_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " menuhot.MenuID, menuhot.ParentID, menuhot.Title, menuhot.Url, menuhot.Slug, menuhot.Types, menuhot.Description, menuhot.StaticContent, CAST(menuhot.IsStatic as UNSIGNED INT) as IsStatic,
								CAST(menuhot.Publish as UNSIGNED INT) as Publish, CAST(menuhot.IsClick as UNSIGNED INT) as IsClick, menuhot.Orders, CAST(menuhot.IsNewTab as UNSIGNED INT) as IsNewTab, menuhot.SEOTitle, menuhot.SEOKeyword, menuhot.SEODescription, ";

				$selectClause .= " (select Username from admin where UsersID = menuhot.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = menuhot.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);

				$this -> db -> select("DATE_FORMAT(menuhot.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(menuhot.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("menuhot");

				$this -> db -> where("menuhot.MenuID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		public function Menu_get_by_slug($slug = false) {
			if($slug !== false){
				$selectClause = " menuhot.MenuID, menuhot.ParentID, menuhot.Title, menuhot.Url,menuhot.Description, menuhot.StaticContent, CAST(menuhot.IsStatic as UNSIGNED INT) as IsStatic,
								CAST(menuhot.Publish as UNSIGNED INT) as Publish, CAST(menuhot.IsClick as UNSIGNED INT) as IsClick, menuhot.Orders,CAST(menuhot.IsNewTab as UNSIGNED INT) as IsNewTab, ";

				$selectClause .= " (select Username from admin where UsersID = menuhot.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = menuhot.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);

				$this -> db -> select("DATE_FORMAT(menuhot.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(menuhot.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("menuhot");

				$this -> db -> where("menuhot.MenuID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

		/*****************************
		***************************************************************************/

		private function check_field_input() {

			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') :  $Title = "" ;
			//$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') :  $Title_en = "" ;
			$this -> input -> post('ParentID') ? $ParentID = $this -> input -> post('ParentID') : $ParentID = 0 ;
			$this -> input -> post('IsStatic') ? $IsStatic = 1 : $IsStatic = 0 ;
			$this -> input -> post('Url') ? $Url = $this -> input -> post('Url') : $Url = "" ;
			//$this -> input -> post('Url_en') ? $Url_en = $this -> input -> post('Url_en') : $Url_en = "" ;
			$Slug = $this -> gen_slug($Title);
			//$Slug_en = $this -> gen_slug($Title_en);
			$linktype = "";
			if($IsStatic != 1) {

				$this -> input -> post('linktype') ? $linktype = $this -> input -> post('linktype') : $linktype = "";

				switch($linktype) {
					case "Internal" : {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "" . $Url;
						break;
					}
					case "External" : {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "" . $Url;
						break;
					}
					case "NewsCategories" : {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "tin-tuc/" . $Url;
						break;
					}
					case "News" : {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "tin-tuc/" . $Url;
						break;
					}
					case "ProductCategories": {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "" . $Url;
						break;
					}
					case "Products": {
						$Slug = $this -> gen_slug($Url);
						//$Slug_en = $this -> gen_slug($Url_en);
						$Url = "" . $Url;
						break;
					}
					default : {
						$Url = $this -> gen_slug($Title);
						//$Url_en = $this -> gen_slug($Title_en);
						break;
					}
				}

			}else {
				$Url = $this -> gen_slug($Title);
				//$Url_en = $this -> gen_slug($Title_en);
			}

			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "" ;
			//$this -> input -> post('Description_en') ? $Description_en = $this -> input -> post('Description_en') : $Description_en = "" ;
			$this -> input -> post('StaticContent') ? $StaticContent = $this -> input -> post('StaticContent') : $StaticContent = "" ;
			//$this -> input -> post('StaticContent_en') ? $StaticContent_en = $this -> input -> post('StaticContent_en') : $StaticContent_en = "" ;
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0 ;
			$this -> input -> post('IsClick') ? $IsClick = 1 : $IsClick = 0 ;
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ? $Orders = $this -> input -> post('Orders') : $Orders = 999 ) : $Orders = 999;
			$this -> input -> post('IsNewTab') ? $IsNewTab = 1 : $IsNewTab = 0 ;

			$this -> input -> post('menuhotPageTitle') ? $SEOTitle = $this -> input -> post('menuhotPageTitle') : $SEOTitle = "";
			//$this -> input -> post('menuhotPageTitle_en') ? $SEOTitle_en = $this -> input -> post('menuhotPageTitle_en') : $SEOTitle_en = "";
            $this -> input -> post('menuhotMetaKeywords') ? $SEOKeyword = $this -> input -> post('menuhotMetaKeywords') : $SEOKeyword = "";
            $this -> input -> post('menuhotMetaDesc') ? $SEODescription = $this -> input -> post('menuhotMetaDesc') : $SEODescription = "";

			$data = array(
					'Title' => $Title ,
					//'Title_en' => $Title_en ,
					'ParentID' => $ParentID ,
					'Url' => $Url ,
					//'Url_en' => $Url_en ,
					'Description' => $Description ,
					//'Description_en' => $Description_en ,
					'Types' => $linktype,
					'Slug' => $Slug,
					//'Slug_en' => $Slug_en ,
					'IsStatic' => $IsStatic ,
					'StaticContent' => $StaticContent ,
					//'StaticContent_en' => $StaticContent_en ,
					'Publish' => $Publish ,
					'IsClick' => $IsClick ,
					'Orders' => $Orders ,
					'SEOTitle' => $SEOTitle,
					//'SEOTitle_en' => $SEOTitle_en,
					'SEOKeyword' => $SEOKeyword,
					'SEODescription' => $SEODescription,
					'IsNewTab' => $IsNewTab
				);
			return $data;

		}

		public function Menu_insert() {
			$receivedata = $this -> check_field_input();
			$data = array(
					'Title' => $receivedata['Title'] ,
					//'Title_en' => $receivedata['Title_en'] ,
					'ParentID' => $receivedata['ParentID'] ,
					'Url' => $receivedata['Url'] ,
					//'Url_en' => $receivedata['Url_en'] ,
					'Description' => $receivedata['Description'] ,
					//'Description_en' => $receivedata['Description_en'] ,
					'Types' => $receivedata['Types'] ,
					'Slug' => $receivedata['Slug'] ,
					//'Slug_en' => $receivedata['Slug_en'] ,
					'IsStatic' => (int)$receivedata['IsStatic'] ,
					'StaticContent' => $receivedata['StaticContent'] ,
					//'StaticContent_en' => $receivedata['StaticContent_en'] ,
					'Publish' => (int)$receivedata['Publish'] ,
					'IsClick' => (int)$receivedata['IsClick'] ,
					'Orders' => $receivedata['Orders'] ,
					'SEOTitle' => $receivedata['SEOTitle'],
					//'SEOTitle_en' => $receivedata['SEOTitle_en'],
					'SEOKeyword' => $receivedata['SEOKeyword'],
					'SEODescription' => $receivedata['SEODescription'],
					'IsNewTab' => (int)$receivedata['IsNewTab'],
					'CreatedBy' => $this -> session -> userdata('userid') // get from session
				);
			$this -> db -> insert("menuhot",$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Menu_update($id = false) {
			if($id !== false) {
				$receivedata = $this -> check_field_input();
				$data = array(
					'Title' => $receivedata['Title'] ,
					//'Title_en' => $receivedata['Title_en'] ,
					'ParentID' => $receivedata['ParentID'] ,
					'Url' => $receivedata['Url'] ,
					//'Url_en' => $receivedata['Url_en'] ,
					'Description' => $receivedata['Description'] ,
					//'Description_en' => $receivedata['Description_en'] ,
					'Types' => $receivedata['Types'] ,
					'Slug' => $receivedata['Slug'] ,
					//'Slug_en' => $receivedata['Slug_en'] ,
					'IsStatic' => (int)$receivedata['IsStatic'] ,
					'StaticContent' => $receivedata['StaticContent'] ,
					//'StaticContent_en' => $receivedata['StaticContent_en'] ,
					'Publish' => (int)$receivedata['Publish'] ,
					'IsClick' => (int)$receivedata['IsClick'] ,
					'Orders' => $receivedata['Orders'] ,
					'SEOTitle' => $receivedata['SEOTitle'],
					//'SEOTitle_en' => $receivedata['SEOTitle_en'],
					'SEOKeyword' => $receivedata['SEOKeyword'],
					'SEODescription' => $receivedata['SEODescription'],
					'IsNewTab' => (int)$receivedata['IsNewTab'],
					'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
					'ModifiedDate' => date('Y-m-d H:i:s', time())
				);
				$this -> db -> update("menuhot",$data,array("MenuID" => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function Menu_delete($id = false) {

			if($id !== false) {
				$this -> db -> delete('menuhot',array('MenuID' => $id));

				if($this -> db -> affected_rows() > 0){
					$this -> db -> delete('menuhot',array('ParentID' => $id));
					return true;
				}
				return false;
			}else {
				show_404();
			}
		}
	}
?>