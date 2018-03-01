<?php
	class Recruitment_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Recruitment_get() {
			$selectClause = " select * from recruitments order by CreatedDate desc, ModifiedDate desc limit 1 ";

			$result = $this -> db -> query($selectClause);

			if($result !== false) {
				return $result -> row_array();
			}
			return false;

		}
	}
?>