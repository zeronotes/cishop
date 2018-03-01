<?php
	class People_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAllTabs() {

			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title, ';
			}else {
				$selectClause .= ' Title_en as Title, ';
			}

			$selectClause .= " Id from tabs_nhansu ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0 ) {
				$result = $result -> result_array();

				for ($i=0; $i < sizeof($result) ; $i++) {
					$result[$i]['people_list'] = $this -> getAllByTab($result[$i]['Id']);
				}

				return $result;
			}
			return array();
		}

		public function Speakers_All($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			$selectClause = " select (select count(Id) from speakers where ". $whereClause .") as count,
									Id,FullName,FullName_en,Slug,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from speakers where Publish = 1 and ". $whereClause ." order by Orders, CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function Speakers_All_() {

			$selectClause = " select Id,FullName,FullName_en,Slug,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from speakers where Publish = 1 order by Orders, CreatedDate desc limit 9";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function getAllByTab($tabsId = false) {

			$selectClause = " select Id,FullName,FullName_en,Slug,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from speakers where Publish = 1 and tabs_nhansu = ? order by Orders, CreatedDate desc limit 9";

			$result = $this -> db -> query($selectClause,array($tabsId));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function Speakers_Id($id = false) {

			$selectClause = " select Id,FullName,FullName_en,Description,Description_en,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from speakers where Publish = 1 and Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return array();

		}

		public function Speakers_Slug($slug = false) {

			$selectClause = " select Id,FullName,FullName_en,Slug,Description,Description_en,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from speakers where Publish = 1 and Slug = ? order by CreatedDate desc limit 1 ";

			$result = $this -> db -> query($selectClause,array($slug));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return array();

		}
	}
?>