<?php
	class Support_online_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Get_All_Support_Online() {
			$selectClause = " Title,FullName,Phone,Email,Skype,Yahoo from supportonline where Publish = 1";

			$this -> db -> select($selectClause);
			$this -> db -> order_by('Orders','asc');

			$result = $this -> db -> get();

			if($result -> num_rows() > 0 ) {
				return $result -> result_array();
			}

			return array();
		}

		public function Get_All_Hotline() {
			$selectClause = "Title,Phone,Orders from hotline where Publish = 1";

			$this -> db -> select($selectClause);
			$this -> db -> order_by('Orders','asc');

			$result = $this -> db -> get();

			if($result -> num_rows() > 0 ) {
				return $result -> result_array();
			}

			return array();
		}
	}
?>