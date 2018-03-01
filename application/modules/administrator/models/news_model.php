<?php
	class News_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function News_get_all_for_select_box() {
			$this -> db -> select('NewsID,Title');
			$this -> db -> from('news');
			$this -> db -> where('Publish', 1);
			$this -> db -> order_by('CreatedDate', 'asc');
			$query = $this -> db -> get();
			return $query -> result_array();
		}
		public function News_get_al() {
			$this -> db -> select('Slug,CreatedDate');
			$this -> db -> from('news');
			$this -> db -> where('Publish', 1);
			$this -> db -> order_by('CreatedDate', 'desc');
			$query = $this -> db -> get();
			return $query -> result_array();
		}
		
		// get all news
		public function News_get_all($limit_start=false,$limit_show=false,$whereClause = false, $IsTrash = 0) {
			$selectClause = "";

			$selectClause .= " select news.NewsID, news.Title,DATE_FORMAT(news.CreatedDate,'%T %m-%d-%Y') as CreatedDate, CAST(news.IsHot as UNSIGNED INT) as IsHot,CAST(news.Publish as UNSIGNED INT) as Publish,CAST(news.IsBanner as UNSIGNED INT) as IsBanner,news.Orders,";
			$selectClause .= " (select count(NewsID) from news ";
			if($whereClause !== false) {
				$selectClause .= ' where news.IsTrash = ? and '.$whereClause;
			}

			$selectClause .= ") as count, ";
			$selectClause .= " cate.Title as CateTitle,cate.CategoriesNewsID from news left join categoriesnews as cate on cate.CategoriesNewsID = news.CategoriesNewsID
										where news.IsTrash = ? and ".$whereClause." order by news.Orders asc, IsHot desc, news.CreatedDate desc limit ?,? ";



			$result = $this -> db -> query($selectClause,array($IsTrash,$IsTrash,$limit_start,$limit_show));

			return $result;
		}

		// get all of news information by id
		public function News_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " news.NewsID, news.Title,news.Title_en,news.Title_fr,news.ImageURL,news.ImageTitle,news.ImageAlt,news.Description,news.Description_en,news.Description_fr,
									news.Body,news.Body_en,news.Body_fr,CAST(news.Publish as UNSIGNED INT) as Publish,CAST(news.IsHot as UNSIGNED INT) as IsHot,CAST(news.IsBanner as UNSIGNED INT) as IsBanner,news.Orders,
									news.CategoriesNewsID,news.Date,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Tags,news.Hightlight, ";

				$selectClause .= " (select Username from admin where UsersID = news.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = news.ModifiedBy) as ModifiedBy,";

				$this -> db -> select($selectClause);

				$this -> db -> select("DATE_FORMAT(news.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(news.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

				$this -> db -> from("news");

				$this -> db -> where("news.NewsID = ".$id.";");

				$result = $this -> db -> get();

				return $result;
			}else {
				show_404();
			}
		}


		private function check_field_input() {
			$this -> input -> post('newsTitle') ? $newsTitle = $this -> input -> post('newsTitle') : $newsTitle = "";
			$this -> input -> post('newsTitle_en') ? $newsTitle_en = $this -> input -> post('newsTitle_en') : $newsTitle_en = "";
			$this -> input -> post('newsTitle_fr') ? $newsTitle_fr = $this -> input -> post('newsTitle_fr') : $newsTitle_fr = "";
			$this -> input -> post('newsCategoryID') ? $newsCategoryID = $this -> input -> post('newsCategoryID') : $newsCategoryID = "";
			$this -> input -> post('newsDescription') ? $newsDescription = $this -> input -> post('newsDescription') : $newsDescription = "";
			$this -> input -> post('newsDescription_en') ? $newsDescription_en = $this -> input -> post('newsDescription_en') : $newsDescription_en = "";
			$this -> input -> post('newsDescription_fr') ? $newsDescription_fr = $this -> input -> post('newsDescription_fr') : $newsDescription_fr = "";
			$this -> input -> post('newsPublish') ? $Publish = 1 : $Publish = 0;
			$this -> input -> post('newsIsHot') ? $IsHot = 1 : $IsHot = 0;
			$this -> input -> post('newsIsBanner') ? $IsBanner = 1 : $IsBanner = 0;
			$this -> input -> post('newsOrders') ? ( is_numeric($this -> input -> post('newsOrders')) ? $Orders = $this -> input -> post('newsOrders') : $Orders = 999 ) : $Orders = 999;
			$this -> input -> post('newsBody') ? $newsBody = $this -> input -> post('newsBody') : $newsBody = "";
			$this -> input -> post('newsBody_en') ? $newsBody_en = $this -> input -> post('newsBody_en') : $newsBody_en = "";
			$this -> input -> post('newsBody_fr') ? $newsBody_fr = $this -> input -> post('newsBody_fr') : $newsBody_fr = "";
			$this -> input -> post('newsMainImage') ? $newsMainImage = $this -> input -> post('newsMainImage') : $newsMainImage = "";
			$this -> input -> post('newsImageTitle') ? $newsImageTitle = $this -> input -> post('newsImageTitle') : $newsImageTitle = "";
			$this -> input -> post('newsImageAlt') ? $newsImageAlt = $this -> input -> post('newsImageAlt') : $newsImageAlt = "";
			$newsDate = date('Y-m-d H:i:s', time());

			$this -> input -> post('newsPageTitle') ? $SEOTitle = $this -> input -> post('newsPageTitle') : $SEOTitle = $newsTitle;
            $this -> input -> post('newsMetaKeywords') ? $SEOKeyword = $this -> input -> post('newsMetaKeywords') : $SEOKeyword = $newsTitle;
            $this -> input -> post('newsMetaDesc') ? $SEODescription = $this -> input -> post('newsMetaDesc') : $SEODescription = $newsDescription;
            $this -> input -> post('newsTags') ? $newsTags = implode(",",$this -> input -> post('newsTags')) : $newsTags = "";
            $this -> input -> post('newsHightlight') ? $newsHightlight = implode(",",$this -> input -> post('newsHightlight')) : $newsHightlight = "";
			$data = array(
					'Title' => $newsTitle,
					'Title_en' => $newsTitle_en,
					'Title_fr' => $newsTitle_fr,
					'ImageURL' => $newsMainImage,
					'ImageTitle' => $newsImageTitle,
					'ImageAlt' => $newsImageAlt,
					'Description' => $newsDescription,
					'Body' => $newsBody,
					'Description_en' => $newsDescription_en,
					'Description_fr' => $newsDescription_fr,
					'Body_en' => $newsBody_en,
					'Body_fr' => $newsBody_fr,
					'Publish' => $Publish,
					'IsHot' => $IsHot,
					'IsBanner' => $IsBanner,
					'Orders' => $Orders,
					'SEOTitle' => $SEOTitle,
					'SEOKeyword' => $SEOKeyword,
					'SEODescription' => $SEODescription,
					'Date' => $newsDate,
					'CategoriesNewsID' => $newsCategoryID,
					'Tags' => $newsTags,
					'Hightlight' => $newsHightlight,
				);
			return $data;
		}

		private function get_newest_id() {
			// select auto_increment from information_schema.TABLES where TABLE_NAME ='tablename' and TABLE_SCHEMA='database_name';
			$this -> db -> select("auto_increment");
			$this -> db -> from("information_schema.TABLES");
			$this -> db -> where('TABLE_NAME', 'news');
			$this -> db -> where('TABLE_SCHEMA', $this -> db -> database);
			$query = $this -> db -> get();
			if($query -> num_rows() > 0)
				return $query -> row_array();
			return false;
		}

		//add new news
		public function News_insert() {
			$newestid = $this -> get_newest_id();
			$receivedata = $this -> check_field_input();
			$data = array(
						'Title' => htmlspecialchars(trim($receivedata['Title'])),
						'Title_en' => htmlspecialchars(trim($receivedata['Title_en'])),
						'Title_fr' => htmlspecialchars(trim($receivedata['Title_fr'])),
						'ImageURL' => $receivedata['ImageURL'],
						'ImageTitle' => htmlspecialchars(trim($receivedata['ImageTitle'])),
						'ImageAlt' => htmlspecialchars(trim($receivedata['ImageAlt'])),
						'Description' => htmlspecialchars(trim($receivedata['Description'])),
						'Description_en' => htmlspecialchars(trim($receivedata['Description_en'])),
						'Description_fr' => htmlspecialchars(trim($receivedata['Description_fr'])),
						'Body' => $receivedata['Body'],
						'Body_en' => $receivedata['Body_en'],
						'Body_fr' => $receivedata['Body_fr'],
						'Slug' => $this -> gen_slug($receivedata['Title']),
						'Date' => $receivedata['Date'],
						'Publish' => (int)$receivedata['Publish'],
						'IsHot' => (int)$receivedata['IsHot'],
						'IsBanner' => (int)$receivedata['IsBanner'],
						'Orders' => $receivedata['Orders'],
						'SEOTitle' => htmlspecialchars($receivedata['SEOTitle']),
						'SEOKeyword' => htmlspecialchars($receivedata['SEOKeyword']),
						'SEODescription' => htmlspecialchars($receivedata['SEODescription']),
						'CategoriesNewsID' => $receivedata['CategoriesNewsID'],
						'CreatedBy' => $this -> session -> userdata('userid'), // get from session
						'Tags' => $receivedata['Tags'],
						'Hightlight' => $receivedata['Hightlight']
				);
			$this -> db -> insert("news",$data);

			if($this -> db -> affected_rows() > 0) {
				return true;
			}else {
				return false;
			}
		}

		//update news
		public function News_update($id = false) {
			if($id !== false) {
				$receivedata = $this -> check_field_input();

				$data = array(
							'Title' => htmlspecialchars(trim($receivedata['Title'])),
							'Title_en' => htmlspecialchars(trim($receivedata['Title_en'])),
							'Title_fr' => htmlspecialchars(trim($receivedata['Title_fr'])),
							'ImageURL' => $receivedata['ImageURL'],
							'ImageTitle' => htmlspecialchars(trim($receivedata['ImageTitle'])),
							'ImageAlt' => htmlspecialchars(trim($receivedata['ImageAlt'])),
							'Description' => htmlspecialchars(trim($receivedata['Description'])),
							'Description_en' => htmlspecialchars(trim($receivedata['Description_en'])),
							'Description_fr' => htmlspecialchars(trim($receivedata['Description_fr'])),
							'Body' => $receivedata['Body'],
							'Body_en' => $receivedata['Body_en'],
							'Body_fr' => $receivedata['Body_fr'],
							'Slug' => $this -> gen_slug($receivedata['Title']),
							'Date' => $receivedata['Date'],
							'Publish' => (int)$receivedata['Publish'],
							'IsHot' => (int)$receivedata['IsHot'],
							'IsBanner' => (int)$receivedata['IsBanner'],
							'Orders' => $receivedata['Orders'],
							'SEOTitle' => $receivedata['SEOTitle'],
							'SEOKeyword' => $receivedata['SEOKeyword'],
							'SEODescription' => $receivedata['SEODescription'],
							'CategoriesNewsID' => $receivedata['CategoriesNewsID'],
							'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
							'ModifiedDate' => date('Y-m-d H:i:s', time()),
							'Tags' => $receivedata['Tags'],
							'Hightlight' => $receivedata['Hightlight']
					);
				return $this -> db -> update("news",$data,array("NewsID" => $id));

			}else {
				show_404();
			}
		}

		//delete news
		public function News_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('news',array('NewsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function News_trash($id = false) {
			if($id !== false) {
				$this -> db -> update("news",array("IsTrash" => 1,"LastDateTrash" => date('Y-m-d H:i:s', time())),array("NewsID" => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function News_restore($id = false) {
			if($id !== false) {
				$this -> db -> update("news",array("IsTrash" => 0,"LastDateRestore" => date('Y-m-d H:i:s', time())),array("NewsID" => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>