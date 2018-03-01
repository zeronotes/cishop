<?php
	class Logo_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Logo_get() {
			$selectClause = " select * from logos where IsMain = 1 order by CreatedDate desc, ModifiedDate desc limit 1 ";

			$result = $this -> db -> query($selectClause);

			if($result !== false) {
				return $result -> row_array();
			}
			return false;
		}
	}
?>