<?php
	class Seo_default_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_seo_default() {
			$result = $this -> db -> get("seodefault");

			return $result -> row_array();
		}
	}
?>