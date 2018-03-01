<?php 
	class Favicon_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Favi_get_all($limit_start=false,$limit_show=false) {
			$selectClause = " select (select count(FaviconsID) from favicons) as count,FaviconsID,IconURL,CAST(IsMain AS unsigned int) as IsMain, 
								DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate, 
									DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate, 
										(select Username from admin where UsersID = CreatedBy) as CreatedBy,
										(select Username from admin where UsersID = ModifiedBy) as ModifiedBy 
											from favicons order by CreatedDate desc limit ?,?";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;
		}

		public function Favi_get_by_id($id = false) {
			$selectClause = " select IconURL,CAST(IsMain AS unsigned int) as IsMain,FaviconsID,  
								DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate, 
									DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate, 
										(select Username from admin where UsersID = CreatedBy) as CreatedBy,
										(select Username from admin where UsersID = ModifiedBy) as ModifiedBy 
											from favicons where FaviconsID = ? ";
			$result = $this -> db -> query($selectClause,array($id));

			return $result;
		}

		private function Check_input_fields() {
			$this -> input -> post('IconURL') ? $IconURL = $this -> input -> post('IconURL') : $IconURL = "";
			$this -> input -> post('IsMain') ? $IsMain = 1 : $IsMain = 0;

			$data = array(
						'IconURL' => $IconURL ,
						'IsMain' => $IsMain 
					);

			return $data;
		}

		public function Favi_insert() {
			$receivedata = $this -> Check_input_fields();

			$data = array(
						'IconURL' => $receivedata['IconURL'] ,
						'IsMain' => (int)$receivedata['IsMain'] ,
						'CreatedBy' => $this -> session -> userdata('userid')
					);
			$this -> db -> insert('favicons',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Favi_update($id = false ) {
			if($id !== false) {
				$receivedata = $this -> Check_input_fields();

				$data = array(
							'IconURL' => $receivedata['IconURL'] ,
							'ModifiedBy' => $this -> session -> userdata('userid'),
							'ModifiedDate' => date('Y-m-d H:i:s', time())
						);
				$this -> db -> update('favicons',$data,array('FaviconsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function Favi_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('favicons',array('FaviconsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>