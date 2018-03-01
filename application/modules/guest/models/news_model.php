<?php
	class News_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

        function Get_child_news($ParentID,$limit = 0,$start = 0) {
            global $lang;
            if ($lang == 'en'){
                $this -> db -> select('news.Title_en as Title,news.Description_en as Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            } else if ($lang == 'fr'){
                $this -> db -> select('news.Title_fr as Title,news.Description_fr as Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            } else {
                $this -> db -> select('news.Title,news.Description,Slug,ImageURL,ImageTitle,ImageAlt,CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> where('CategoriesNewsID', $ParentID);
            $this -> db -> where('Publish', 1);
            //$this -> db -> order_by('IsHot', 'desc');
            //$this -> db -> order_by('Orders', 'asc');
            $this -> db -> order_by('CreatedDate', 'desc');
            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_latest_news($limit = 0,$start = 0){
            global $lang;
            if ($lang == 'en'){
                $this -> db -> select('news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if ($lang == 'fr'){
                $this -> db -> select('news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.CreatedDate','desc');
            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_most_views_news($limit = 0,$start = 0){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.View','desc');
            $this -> db -> order_by('news.CreatedDate','desc');
            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_hot($ParentID = false,$limit = 0,$start = 0){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            if($ParentID){
                $this -> load -> model('categories_news_model');
                $parent_list = $this -> categories_news_model -> Get_categories_tree($ParentID);
                $parent_list[] = $ParentID;
                $this -> db -> where_in('news.CategoriesNewsID', $parent_list);
            }
            $this -> db -> where('news.Publish', 1);
            $this -> db -> where('news.IsHot', 1);
            $this -> db -> order_by('news.Orders','asc');
            $this -> db -> order_by('news.CreatedDate','desc');

            if ($limit && $start){
                $this -> db -> limit($limit,$start);
            } else if($limit){
                $this -> db -> limit($limit,0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_banner($ParentID = false){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            if($ParentID){
                $this -> load -> model('categories_news_model');
                $parent_list = $this -> categories_news_model -> Get_categories_tree($ParentID);
                $parent_list[] = $ParentID;
                $this -> db -> where_in('news.CategoriesNewsID', $parent_list);
            }
            $this -> db -> where('news.Publish', 1);
            $this -> db -> where('news.IsBanner', 1);
            // $this -> db -> order_by('news.Orders','asc');
            $this -> db -> order_by('news.CreatedDate','desc');
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_relative($ParentID,$limit = ""){
            global $lang;
            $this -> load -> model('categories_news_model');
            $parent_list = $this -> categories_news_model -> Get_categories_tree($ParentID);
            $parent_list[] = $ParentID;

            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where_in('news.CategoriesNewsID', $parent_list);
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.IsHot','desc');
            $this -> db -> order_by('news.Orders','asc');
            $this -> db -> order_by('news.CreatedDate','desc');
            if($limit){
                $this -> db -> limit($limit, 0);
            }
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_details($slug){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Body_en as Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Body_fr as Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where('news.Publish', 1);
            $this -> db -> where('news.Slug', $slug);
            $query = $this -> db -> get();
            $result = $query -> row();
            $result -> CreatedDate = date("d/m/Y | H:i",strtotime($result -> CreatedDate)) ;
            return $result;
        }

        function Get_details_by_id($id){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.ImageURL,news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Body_en as Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            } else if($lang == 'fr'){
                $this -> db -> select('news.ImageURL,news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Body_fr as Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            } else {
                $this -> db -> select('news.ImageURL,news.NewsID,news.Title,news.Description,news.Body,news.Slug,news.CategoriesNewsID,news.SEOTitle,news.SEOKeyword,news.SEODescription,news.Hightlight,news.Tags,news.CreatedDate,news.View');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where('news.Publish', 1);
            $this -> db -> where('news.NewsID', $id);
            $query = $this -> db -> get();
            $result = $query -> row();
            $result -> CreatedDate = date("d/m/Y | H:i",strtotime($result -> CreatedDate)) ;
            return $result;
        }

        function Get_breadcrumb($CategoriesNewsID, $breadcrumb_list = false){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('categoriesnews.ParentID,categoriesnews.Title_en as Title,Slug');
            } else if($lang == 'fr'){
                $this -> db -> select('categoriesnews.ParentID,categoriesnews.Title_fr as Title,Slug');
            } else {
                $this -> db -> select('categoriesnews.ParentID,categoriesnews.Title,,Slug');
            }
            $this -> db -> from('categoriesnews');
            $this -> db -> where('CategoriesNewsID', $CategoriesNewsID);
            $query = $this -> db -> get();
            $breadcrumb = $query -> result();
            $breadcrumb_list[] = $breadcrumb[0];
            
            if ($breadcrumb[0] -> ParentID != 0) {
                return $this -> Get_breadcrumb($breadcrumb[0] -> ParentID, $breadcrumb_list);
            } else {
                return $breadcrumb_list;
            }
        }

        function Get_pagination_number($ParentID){
            $this -> db -> select('NewsID');
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where_in('news.CategoriesNewsID', $ParentID);
            $this -> db -> where('news.Publish', 1);
            $query = $this -> db -> get();
            return $query -> num_rows();
        }

        function Get_pagination_news($limit, $start, $ParentID){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where_in('news.CategoriesNewsID', $ParentID);
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.IsHot', 'desc');
            $this -> db -> order_by('news.Orders', 'asc');
            $this -> db -> order_by('news.CreatedDate', 'desc');
            $this -> db -> limit($limit, $start);
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_tag_details($slug){
            $this -> db -> from('newstags');
            $this -> db -> where('newstags.Publish', 1);
            $this -> db -> where('newstags.Slug', $slug);
            $query = $this -> db -> get();
            return $query -> row();
        }

        function Get_tag_pagination_number($TagsID){
            $this -> db -> select('NewsID');
            $this -> db -> from('news');
            $this -> db -> where("(`news`.`Tags` = ".$TagsID ." OR `news`.`Tags` LIKE '%".$TagsID.",%' OR `news`.`Tags` LIKE '%,".$TagsID."%')", NULL, FALSE);
            $this -> db -> where('news.Publish', 1);
            $query = $this -> db -> get();
            return $query -> num_rows();
        }

        function Get_tag_pagination_news($limit, $start, $TagsID){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate,news.View');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> where("(`news`.`Tags` = ".$TagsID ." OR `news`.`Tags` LIKE '%".$TagsID.",%' OR `news`.`Tags` LIKE '%,".$TagsID."%')", NULL, FALSE);
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.CreatedDate', 'desc');
            $this -> db -> limit($limit, $start);
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function Get_search_pagination_number($Keyword){
            $this -> db -> select('NewsID');
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> like('news.Title', $Keyword);
            $this -> db -> where('news.Publish', 1);
            $query = $this -> db -> get();
            return $query -> num_rows();
        }

        function Get_search_pagination_news($limit, $start, $Keyword){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this -> db -> from('news');
            $this -> db -> join('categoriesnews', 'categoriesnews.CategoriesNewsID = news.CategoriesNewsID');
            $this -> db -> like('news.Title', $Keyword);
            $this -> db -> where('news.Publish', 1);
            $this -> db -> order_by('news.CreatedDate', 'desc');
            $this -> db -> limit($limit, $start);
            $query = $this -> db -> get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function check_news($slug){
            $this -> db -> from('categoriesnews');
            $this -> db -> where('Slug', $slug);
            $query = $this -> db -> get();
            if ($query -> num_rows() == 0) return true; else return false;
        }

        function get_news_hightlight($Hightlight){
            global $lang;
            if($lang == 'en'){
                $this -> db -> select('news.NewsID,news.Title_en as Title,news.Description_en as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else if($lang == 'fr'){
                $this -> db -> select('news.NewsID,news.Title_fr as Title,news.Description_fr as Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            } else {
                $this -> db -> select('news.NewsID,news.Title,news.Description,news.Slug,news.ImageURL,news.ImageTitle,news.ImageAlt,news.CreatedDate');
            }
            $this->db->from('news');
            $this->db->where_in('NewsID',explode(",",$Hightlight));
            $this -> db -> order_by('news.Orders', 'asc');
            $this -> db -> order_by('news.CreatedDate', 'desc');
            $query = $this->db->get();
            if($query -> num_rows() != 0){
                $result = $query -> result();
                foreach ($result as $re) {
                    $re -> CreatedDate = date("d/m/Y | H:i",strtotime($re -> CreatedDate)) ;
                }
                return $result;
            } else {
                return false;
            }
        }

        function get_news_tags($Tags){
            $this->db->select('Title,Slug');
            $this->db->from('newstags');
            $this->db->where_in('TagsID',explode(",",$Tags));
            $this -> db -> order_by('Orders', 'asc');
            $this -> db -> order_by('CreatedDate', 'desc');
            $query = $this->db->get();
            if($query -> num_rows() > 0) {
                return $query -> result();
            }
            return false;
        }

        function Update_view($NewsID) {
            if(isset($_COOKIE['read_articles'])) {
                //grab the JSON encoded data from the cookie and decode into PHP Array
                $read_articles = json_decode($_COOKIE['read_articles'], true);
                if(isset($read_articles[$NewsID]) AND $read_articles[$NewsID] == 1) {
                    //this post has already been read
                } else {

                    //increment the post view count by 1 using update queries
                    $this->db->set('View', 'View+1', FALSE);
                    $this->db->where('NewsID', $NewsID);
                    $this->db->update('news');

                    $read_articles[$NewsID] = 1;
                    //set the cookie again with the new article ID set to 1
                    setcookie("read_articles",json_encode($read_articles),time()+60*60*24);
                }
            } else {
                //hasn't read an article in 24 hours?
                //increment the post view count
                $this->db->set('View', 'View+1', FALSE);
                $this->db->where('NewsID', $NewsID);
                $this->db->update('news');

                $read_articles = Array(); 
                $read_articles[$NewsID] = 1;
                setcookie("read_articles",json_encode($read_articles),time()+60*60*24);
            }
        }
	}
?>