<?php
	class Xetnghiem_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_xetnghiem_by_code($ma_xet_nghiem = false) {
			$selectClause = " select * from xetnghiem where ma_xet_nghiem = ? ";

			$result = $this -> db -> query($selectClause,array($ma_xet_nghiem));
			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;
		}

	}
?>