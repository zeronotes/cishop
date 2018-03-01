<?php
	class Districts_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			$selectClause = " select (select count(Id) from districts where "
								.$whereClause. "
								) as count, Id,Title from districts
									where ".$whereClause." order by CreatedDate desc limit ?,?";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0 )
				return $result -> result_array();
			return array();

		}

		public function getAllForSelect() {
			$selectClause = " select Id,Title from districts ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0 )
				return $result -> result_array();
			return array();
		}

		// get all information of an Ads by id
		public function getById($id = false) {
			if($id !== false) {
				$selectClause = " select Id,Title,Description,
									DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
									DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
										(select Username from admin where UsersID = districts.CreatedBy) as CreatedBy,
										(select Username from admin where UsersID = districts.ModifiedBy) as ModifiedBy
											from districts where Id = ?";
				$result = $this -> db -> query($selectClause,array($id));
				if($result -> num_rows() > 0 )
					return $result -> row_array();
				return array();
			}else {
				show_404();
			}
		}

		private function Check_input_fields() {

			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";

			$data = array(
						'Title' => $Title ,
						'Description' => $Description
					);

			return $data;
		}

		// insert an Ads into DB. $CateObject cantain all of Ads information
		public function insert() {
			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Description' => $receivedata['Description']
					);

			$this -> db -> insert('districts',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		// update an Ads
		public function update($id = false) {
			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Description' => $receivedata['Description']
					);

			return $this -> db -> update('districts',$data,array('Id' => $id));
		}

		// delete an Ads
		public function delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('districts',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>