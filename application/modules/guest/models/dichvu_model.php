<?php
	class Dichvu_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll() {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title,Description, ';
			}else {
				$selectClause .= ' Title_en as Title,Description_en as Description, ';
			}

			$selectClause .= " ImageUrl,Link from dich_vu where Publish = 1 order by Orders ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$returnData['list'] = $result -> result_array();
                // $returnData['count'] = $this -> getCountForAll();

                return $returnData;
			}
			return array();
		}

		public function getCountForAll($whereClause = " 1 = 1 ") {
			$selectClause = " select count(Id) as count from dich_vu where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();
				return $result['count'];
			}
			return 0;
		}
	}
?>