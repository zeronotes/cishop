<?php
	class Onepages_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getOnePages($slug = false) {
			switch($slug) {
				case 'thanh-toan-van-chuyen-op1': {
					$id = 1;
					break;
				}
				case 'chua-biet': {
					$id = 1;
					break;
				}
				default: {
					$id = 0;
					break;
				}
			}
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title,Description,Content as Body, ';
			}else {
				$selectClause .= ' Title_en as Title,Description_en as Description,Content_en as Body, ';
			}
			$selectClause .= " SEOTitle,SEOKeyword,SEODescription from onepages where Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return false;
		}
	}
?>