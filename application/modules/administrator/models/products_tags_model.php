<?php
	class Products_tags_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}
        
        public function Tags_get_all($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			
			$selectClause = " select (select count(TagsID) from productstags where "
								.$whereClause. "
								) as count, TagsID,Title,Orders,CAST(Publish as UNSIGNED INT) as Publish from productstags 
									where ".$whereClause." order by Orders asc, Title asc limit ?,?";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;

		}

		public function Tags_get_all_for_select_box() {
			$this -> db -> select('TagsID,Title');
			$this -> db -> from('productstags');
			$this -> db -> where('Publish', 1);
			$this -> db -> order_by('CreatedDate', 'asc');
			$query = $this -> db -> get();
			return $query -> result_array();
		}

		public function Tags_get_except_by_id($id = false) {
			$selectClause = " TagsID,Title from productstags where TagsID not like ".$id;
			$this -> db -> select($selectClause);
			$result = $this -> db -> get();

			return $result;
		}

		// get all of categoriesnews information by id
		public function Tags_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " tags.TagsID,tags.Title,tags.Description,
								  tags.Publish,tags.Orders, tags.SEOTitle,tags.SEOKeyword,tags.SEODescription,";

				$this -> db -> select($selectClause);

				$this -> db -> from("productstags as tags");

				$this -> db -> where("tags.TagsID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}

        
        // get all of categoriesnews information by id
		public function Tags_get_by_news_id($id = false) {
			if($id !== false) {
				$selectClause = " tags.TagsID,tags.Title from tags as tags inner join tagnews as tagnews on tags.TagsID = tagnews.TagsID
                                 inner join news as news on news.NewsID = tagnews.NewsID";

				$this -> db -> select($selectClause);

				$this -> db -> where("news.NewsID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}
        
        
		// get all of categoriesnews information by slug
		public function Categoriesnews_get_by_slug($slug = false) {

		}

		private function get_newest_id() {
			// select auto_increment from information_schema.TABLES where TABLE_NAME ='tablename' and TABLE_SCHEMA='database_name';
			$this -> db -> select("auto_increment");
			$this -> db -> from("information_schema.TABLES");
			$this -> db -> where('TABLE_NAME', 'productstags');
			$this -> db -> where('TABLE_SCHEMA', $this -> db -> database);
			$query = $this -> db -> get();
			if($query -> num_rows() > 0)
				return $query -> row_array();
			return false;
		}

		private function check_input_field() {
			$this -> input -> post('tagsTitle') ? $tagsTitle = $this -> input -> post('tagsTitle') : $tagsTitle = "Unknowns";
        	$this -> input -> post('tagsPublish') ? $Publish = 1 : $Publish = 0;
        	$this -> input -> post('tagsOrders') ? ( is_numeric($this -> input -> post('tagsOrders')) ? $Orders = $this -> input -> post('tagsOrders') : $Orders = 999 ) : $Orders = 999;
        	$this -> input -> post('tagsDescription') ? $tagsDescription = $this -> input -> post('tagsDescription') : $tagsDescription = "";

        	$this -> input -> post('tagsPageTitle') ? $SEOTitle = $this -> input -> post('tagsPageTitle') : $SEOTitle = "";
            $this -> input -> post('tagsMetaKeywords') ? $SEOKeyword = $this -> input -> post('tagsMetaKeywords') : $SEOKeyword = "";
            $this -> input -> post('tagsMetaDesc') ? $SEODescription = $this -> input -> post('tagsMetaDesc') : $SEODescription = "";

        	$data = array(
        				'Title' => $tagsTitle,
						'Description' => $tagsDescription,
						'Publish' => $Publish,
						'SEOTitle' => $SEOTitle,
						'SEOKeyword' => $SEOKeyword,
						'SEODescription' => $SEODescription,
						'Orders' => $Orders
        		);
        	return $data;
		}

		//add tags
		public function Tags_insert() {
			$newestid = $this -> get_newest_id();
			$receivedata = $this -> check_input_field();
            $data = array(
					'Title' => $receivedata['Title'],
					'Description' => $receivedata['Description'],
					'Publish' => (int)$receivedata['Publish'],
					'Slug' => $this -> gen_slug($receivedata['Title']),
					'SEOTitle' => $receivedata['SEOTitle'],
					'SEOKeyword' => $receivedata['SEOKeyword'],
					'SEODescription' => $receivedata['SEODescription'],
					'Orders' => $receivedata['Orders']
				);
			return $this -> db -> insert('productstags',$data);
		}

		//update tags
		public function Tags_update($id) {
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'Description' => $receivedata['Description'],
						'Publish' => (int)$receivedata['Publish'],
						'Slug' => $this -> gen_slug($receivedata['Title']),
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'Orders' => $receivedata['Orders']
					);
			return $this -> db -> update('productstags',$data,array('TagsID' => $id));
		}

		public function Tags_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('productstags',array('TagsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>