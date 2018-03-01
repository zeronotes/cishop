<?php
	class Onepages_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		private function check_input_fields() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";

			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";
			$this -> input -> post('Description_en') ? $Description_en = $this -> input -> post('Description_en') : $Description_en = "";

			$this -> input -> post('Body') ? $Body = $this -> input -> post('Body') : $Body = "";
			$this -> input -> post('Body_en') ? $Body_en = $this -> input -> post('Body_en') : $Body_en = "";

			$this -> input -> post('newsPageTitle') ? $SEOTitle = $this -> input -> post('newsPageTitle') : $SEOTitle = $Title;
            $this -> input -> post('newsMetaKeywords') ? $SEOKeyword = $this -> input -> post('newsMetaKeywords') : $SEOKeyword = $Title;
            $this -> input -> post('newsMetaDesc') ? $SEODescription = $this -> input -> post('newsMetaDesc') : $SEODescription = $Title;

			$data = array(
					'Title' => $Title,
					'Title_en' => $Title_en,
					'Description' => $Description,
					'Description_en' => $Description_en,
					'Body' => $Body,
					'Body_en' => $Body_en,
					'SEOTitle' => $SEOTitle,
					'SEOKeyword' => $SEOKeyword,
					'SEODescription' => $SEODescription
				);
			return $data;
		}

		public function onePages($action = false,$id = false) {
			if($action !== false) {
				switch($action) {
					case 'get' : {

						$selectClause = " select * from onepages where Id = ? ";

						$result = $this -> db -> query($selectClause,array($id));

						if($result -> num_rows() > 0) {
							return $result -> row_array();
						}

						return false;

						break;
					}
					case 'update' : {

						$selectClause = " select count(Id) as count from onepages where Id = ? ";

						$result = $this -> db -> query($selectClause,array($id));

						$result = $result -> row_array();

						$receivedata = $this -> check_input_fields();

						if($result['count'] > 0 ) {
							$data = array(
										'Title' => htmlspecialchars($receivedata['Title']),
										'Title_en' => htmlspecialchars($receivedata['Title_en']),
										'Description' => htmlspecialchars($receivedata['Description']),
										'Description_en' => htmlspecialchars($receivedata['Description_en']),
										'Content' => $receivedata['Body'],
										'Content_en' => $receivedata['Body_en'],
										'SEOTitle' => htmlspecialchars($receivedata['SEOTitle']),
										'SEOKeyword' => htmlspecialchars($receivedata['SEOKeyword']),
										'SEODescription' => htmlspecialchars($receivedata['SEODescription'])
								);
							return $this -> db -> update("onepages",$data,array("Id" => $id));
						}else {
							$data = array(
										'Id' => 1,
										'Title' => htmlspecialchars($receivedata['Title']),
										'Title_en' => htmlspecialchars($receivedata['Title_en']),
										'Description' => htmlspecialchars($receivedata['Description']),
										'Description_en' => htmlspecialchars($receivedata['Description_en']),
										'Content' => $receivedata['Body'],
										'Content_en' => $receivedata['Body_en'],
										'SEOTitle' => htmlspecialchars($receivedata['SEOTitle']),
										'SEOKeyword' => htmlspecialchars($receivedata['SEOKeyword']),
										'SEODescription' => htmlspecialchars($receivedata['SEODescription'])
								);
							$this -> db -> insert("onepages",$data);

							if($this -> db -> affected_rows() > 0)
								return true;
							return false;
						}

						break;
					}default : {
						show_404();
						break;
					}
				}
 			}else {
				show_404();
			}
		}
	}
?>