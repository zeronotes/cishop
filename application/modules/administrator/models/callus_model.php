<?php
	class Callus_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = " 1 = 1 ") {
			$selectClause = " select Id,Name,Email,Phone,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate
								from call_us where ".$whereClause." order by CreatedDate desc limit ?,? ";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getCountOfAll($whereClause = ' 1 = 1 ') {
			$selectClause = "select count(Id) as count from call_us where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0) {
				$result = $result -> row_array();
				return $result['count'];
			}
			return false;
		}

		public function getById($id = false) {
			if($id !== false) {
				$selectClause = " select Id,Name,Email,Phone,Address,Content
									from call_us where Id = ? ";

				$result = $this -> db -> query($selectClause,array($id));

				if($result -> num_rows() > 0) {
					return $result -> row_array();
				}
				return array();
			}else {
				show_404();
			}
		}

		public function delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('call_us',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>