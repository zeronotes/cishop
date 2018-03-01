<?php 
	class Products_rating_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Check_input_field() {
			$this -> input -> post('Rating_Review') ? $Marks = $this -> input -> post('Rating_Review') : $Marks = 1;
			$this -> input -> post('txtTitle_Review') ? $Title = $this -> input -> post('txtTitle_Review') : $Title = "";
			$this -> input -> post('txtContent_Review') ? $Comments = $this -> input -> post('txtContent_Review') : $Comments = "";
			$this -> input -> post('txtFromName_Review') ? $FullName = $this -> input -> post('txtFromName_Review') : $FullName = "";
			$this -> input -> post('txtFromEmail_Review') ? $Email = $this -> input -> post('txtFromEmail_Review') : $Email = "";
			
			$data = array(
        				'Title' => $Title,
        				'Marks' => $Marks,
        				'Comments' => $Comments,
        				'Email' => $Email,
        				'FullName' => $FullName
        		);
        	return $data;
		}

		public function Rating_insert($id = false) {
			if($id !== false) {
				$receivedata = $this -> Check_input_field();
				$data = array(
							'ProductsID' => $id,
							'Title' => $receivedata['Title'],
							'Marks' => $receivedata['Marks'],
							'Comments' => $receivedata['Comments'],
							'Email' => $receivedata['Email'],
							'FullName' => $receivedata['FullName']
						);
				$this -> db -> insert('productsrating',$data);

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
		}
	}
?>