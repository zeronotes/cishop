<?php
	class Chungchi_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' FullName, ';
			}else {
				$selectClause .= ' FullName_en as FullName, ';
			}

			$selectClause .= " (select count(Id) from chungchi where ". $whereClause .") as count,
									Id,Slug,ImgUrl,ImgInformation,ImgInformation_en
										from chungchi where Publish = 1 and ". $whereClause ." order by Orders, CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function getAll_() {

			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' FullName, ';
			}else {
				$selectClause .= ' FullName_en as FullName, ';
			}

			$selectClause .= " Id,Slug,ImgUrl,ImgInformation,ImgInformation_en
										from chungchi where Publish = 1 order by Orders, CreatedDate desc limit 9";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function getById($id = false) {

			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' FullName, ';
			}else {
				$selectClause .= ' FullName_en as FullName, ';
			}

			$selectClause .= " Id,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from chungchi where Publish = 1 and Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return array();

		}

		public function getBySlug($slug = false) {

			$selectClause = " select Id,FullName,FullName_en,Slug,Description,Description_en,ImgUrl,ImgInformation,ImgInformation_en,Position,Position_en
										from chungchi where Publish = 1 and Slug = ? order by CreatedDate desc limit 1 ";

			$result = $this -> db -> query($selectClause,array($slug));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return array();

		}
	}
?>