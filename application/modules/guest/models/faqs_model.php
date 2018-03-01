<?php
	class Faqs_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start = false, $limit_show = false,$whereClause = " 1 = 1 ") {

			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Question,Answer, ';
			}else {
				$selectClause .= ' Question_en as Question,Answer_en as Answer, ';
			}

			$selectClause .= " Id from faqs order by Orders, CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getCountOfAll($whereClause = ' 1 = 1 ') {
			$selectClause = " select count(Id) as count from faqs where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();

				return $result['count'];
			}

			return 0;
		}

		public function get7FAQs() {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Question, ';
			}else {
				$selectClause .= ' Question_en as Question, ';
			}

			$selectClause .= " Id from faqs where IsShowFooter = 1 order by Orders, CreatedDate desc limit 7 ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}
	}
?>
