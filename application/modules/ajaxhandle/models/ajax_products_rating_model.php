<?php 
	class Ajax_products_rating_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function Check_input_field() {
			$this -> input -> post('Marks') ? $Marks = $this -> input -> post('Marks') : $Marks = 1;
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Comments') ? $Comments = $this -> input -> post('Comments') : $Comments = "";
			$this -> input -> post('FullName') ? $FullName = $this -> input -> post('FullName') : $FullName = "";
			$this -> input -> post('Email') ? $Email = $this -> input -> post('Email') : $Email = "";
			
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