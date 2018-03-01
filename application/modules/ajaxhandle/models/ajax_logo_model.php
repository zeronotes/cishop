<?php 
	class Ajax_logo_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_update_main_logo() {
			$id = $this -> input -> post('id');

			if($id !== false && is_numeric($id)) {
				$data = array(	'IsMain' => 1,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);
				$this -> db -> update('logos',array('IsMain' => 0),array('IsMain' => 1));				

				$this -> db -> update('logos',$data,array('LogosID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_delete_logo() {
			$id = $this -> input -> post('id');

			if($id !== false && is_numeric($id)) {
				$this -> db -> delete("logos",array("LogosID" => $id));
				
				if($this -> db -> affected_rows() > 0){
					return true;
				}
			}
			return false;
		}
	}
?>