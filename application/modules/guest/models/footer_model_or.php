<?php
	class Footer_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_footer_content() {
			global $lang;

			$selectClause = " select ";

			if($lang == 'vi') {
				$selectClause .= ' Footer,ContactText, ';
			}else {
				$selectClause .= ' Footer_en as Footer,ContactText_en as ContactText, ';
			}

			$selectClause .= " WebInfoID, EmailForm from webinfor ";

			$result = $this -> db -> query($selectClause);

			return $result -> row_array();
		}
	}
?>