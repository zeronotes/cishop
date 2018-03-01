<?php
	class Logo_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Logo_get_all($limit_start=false,$limit_show=false) {
			
			$selectClause = " select (select count(OrdersID) from orders) as count, LogosID,ImageURL,
								Title,Description,CAST(IsMain as UNSIGNED INT) as IsMain,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate   
									from logos order by CreatedDate desc limit ?,?";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;

		}

		public function Logo_get_by_id($id = false) {

			if($id !== false) {
				$selectClause = " select LogosID,ImageURL,Title,Description,CAST(IsMain as UNSIGNED INT) as IsMain,
									DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate, 
										DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
											(select Username from admin where UsersID = CreatedBy) as CreatedBy,
									            (select Username from admin where UsersID = ModifiedBy) as ModifiedBy 
									            	from logos where LogosID = ? ";
				$result = $this -> db -> query($selectClause, array($id));

				return $result;
			}

			show_404();
		}

		private function Check_input_fields() {

			$this -> input -> post('ImageURL') ? $ImageURL = $this -> input -> post('ImageURL') : $ImageURL = "";
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";
			$this -> input -> post('IsMain') ? $IsMain = 1 : $IsMain = 0;

			$data = array(
						'ImageURL' => $ImageURL,
						'Title' => $Title,
						'Description' => $Description,
						'IsMain' => $IsMain
					);

			return $data;

		}

		public function Logo_insert() {
			$receivedata = $this -> Check_input_fields();
			$data = array(
						'ImageURL' => $receivedata['ImageURL'],
						'Title' => $receivedata['Title'],
						'Description' => $receivedata['Description'],
						'IsMain' => (int)$receivedata['IsMain'],
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('logos',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Logo_update($id = false) {

			if($id !== false && is_numeric($id)) {
				$receivedata = $this -> Check_input_fields();

				$data = array(
						'ImageURL' => $receivedata['ImageURL'],
						'Title' => $receivedata['Title'],
						'Description' => $receivedata['Description'],
						// 'IsMain' => $receivedata['IsMain'],
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

				$this -> db -> Update('logos',$data,array('LogosID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			show_404();

		}

	}
?>