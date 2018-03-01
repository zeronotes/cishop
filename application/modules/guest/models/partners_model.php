<?php
	class Partners_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll() {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Title, ';
			}else {
				$selectClause .= ' Title_en as Title, ';
			}

			$selectClause .= " ImageUrl,Url from partners where Publish != 0 order by Orders asc ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}
	}
?>