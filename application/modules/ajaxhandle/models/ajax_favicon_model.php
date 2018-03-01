<?php 
	class Ajax_favicon_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_update_main_favicon() {
			$id = $this -> input -> post('id');

			if($id !== false && is_numeric($id)) {
				$one = 1;
				$zero = 0;
				$data = array(	'IsMain' => (int)$one,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('favicons',array('IsMain' => (int)$zero),array('IsMain' => (int)$one));				

				$this -> db -> update('favicons',$data,array('FaviconsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}
	}
?>