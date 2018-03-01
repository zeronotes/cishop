<?php
    class Guest extends CMS_BaseController {

        function __construct()
        {
        	parent::__construct();
            $this -> load -> model('main_model');
			//$this->output->cache(43200);
			$this->output->cache(10);
        }

        function error_404(){
            $data = $this -> main_model -> general();
            $this -> load -> view('guest/error_404', $data);
        }

        function trang_chu($message = false){
            global $lang;
            $data = $this -> main_model -> general();
            
            $this -> load -> model('banner_model');

            $data['banners'] = $this -> banner_model -> Banner_get_all();

            $data['get_news_product'] = $this -> products_model -> Get_new_products(8);
            
            //$data['hot_cate_news'] = $this -> categories_news_model -> Get_main_categories();
            $data['banner_news'] = $this -> news_model -> Get_banner();
            $data['hot_cate_products'] = $this -> categories_product_model -> Get_top_categories();
            $data['hot_brand_products'] = $this -> sorting_brand_model -> Get_top_categories();
            $data['gallery'] = $this -> ads_model -> Ads_get_for_show(1);
            $data['banner_ads'] = $this -> ads_model -> Ads_get_for_show(1);
            $data['menu'] = $this -> menu_model -> Menu_get_all('trang-chu');
            $data['sub_menu'] = $this -> menu_model -> Menu_sub_get_all();
            $data['latest_news'] = $this -> news_model -> Get_child_news(17, 5);
            $data['partner'] = $this -> partners_model -> getAll();
            

            if($message){
                $data['message'] = $message;
            }

            $this -> load -> view('guest/main_index', $data);
        }

        function products($slug = "") {
            global $lang;
            $data = $this -> main_model -> general();
            
            $data['menu'] = $this -> menu_model -> Menu_get_all('san-pham');
            $data['isRibbon'] = false;
            if (!$slug) {
                redirect('error-404');
            } else if ($slug == "moi") {
                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'moi';
                $config["total_rows"] = $this -> products_model -> Get_new_pagination_number();
                $config["per_page"] = $data["per_page"] = 120;
                $config["uri_segment"] = 2;
                $this -> pagination -> initialize($config);

                $data['page'] = ($this -> uri -> segment(2)) ? $this -> uri -> segment(2) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_new_pagination_product($config["per_page"], $offset);
                $data['links'] = $this -> pagination -> create_links();
                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Sản phẩm mới", base_url(). "moi");

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $data['parent'] = new StdClass();
                $data['parent'] -> Title = "Sản phẩm mới";
                $this -> load -> view('guest/main_product1.php', $data);

            } else if ($slug == "noi-bat") {
                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'noi-bat';
                $config["total_rows"] = $this -> products_model -> Get_hot_pagination_number();
                $config["per_page"] = $data["per_page"] = 120;
                $config["uri_segment"] = 2;
                $this -> pagination -> initialize($config);

                $data['page'] = ($this -> uri -> segment(2)) ? $this -> uri -> segment(2) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_hot_pagination_product($config["per_page"], $offset);
                $data['links'] = $this -> pagination -> create_links();
                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Sản phẩm nổi bật", base_url(). "noi-bat");

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $data['parent'] = new StdClass();
                $data['parent'] -> Title = "Sản phẩm nổi bật";
                $this -> load -> view('guest/main_product1.php', $data);

            } else if ($slug == "ban-chay") {
                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'ban-chay';
                $config["total_rows"] = $this -> products_model -> Get_sellers_pagination_number();
                $config["per_page"] = $data["per_page"] = 120;
                $config["uri_segment"] = 2;
                $this -> pagination -> initialize($config);

                $data['page'] = ($this -> uri -> segment(2)) ? $this -> uri -> segment(2) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_sellers_pagination_product($config["per_page"], $offset);
                $data['links'] = $this -> pagination -> create_links();
                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Sản phẩm bán chạy", base_url(). "ban-chay");

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $data['parent'] = new StdClass();
                $data['parent'] -> Title = "Sản phẩm bán chạy";
                $this -> load -> view('guest/main_product1.php', $data);

            } else if ($slug == "khuyen-mai") {
                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'khuyen-mai';
                $config["total_rows"] = $this -> products_model -> Get_promotion_pagination_number();
                $config["per_page"] = $data["per_page"] = 120;
                $config["uri_segment"] = 2;
                $this -> pagination -> initialize($config);

                $data['page'] = ($this -> uri -> segment(2)) ? $this -> uri -> segment(2) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_promotion_pagination_product($config["per_page"], $offset);
                $data['links'] = $this -> pagination -> create_links();
                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Sản phẩm khuyến mãi", base_url(). "khuyen-mai");

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $data['parent'] = new StdClass();
                $data['parent'] -> Title = "Sản phẩm khuyến mãi";
                $this -> load -> view('guest/main_product1.php', $data);

            } else if($this -> categories_product_model -> Get_details($slug)) {
                $data['showSorting'] = true;
                $data['parent'] = $parent = $this -> categories_product_model -> Get_details($slug);
                $parent_list = $this -> categories_product_model -> Get_categories_tree($data['parent'] -> CategoriesProductsID);
                $parent_list[] = $data['parent'] -> CategoriesProductsID;

                $data['current_query'] = $_SERVER['QUERY_STRING'];
                $data['sort'] = array();
                
                $data['sort_b'] = false;
                if ($this->input->get('b')) {
                    $data['sort_b'] = true;
                    $data['sort']['b'] = $this->input->get('b');
                    $temp_b = $_GET;
                    unset($temp_b['b']);
                    unset($temp_b['trang']);
                    $data['current_query_brand'] = http_build_query($temp_b);
                } else{
                    if($data['current_query'] != ""){
                        $temp_b = $_GET;
                        unset($temp_b['trang']);
                        $data['current_query_brand'] = http_build_query($temp_b);
                    }
                }

                $data['sort_p'] = false;
                if ($this->input->get('p')) {
                    $data['sort_p'] = true;
                    $data['sort']['p'] = $this->input->get('p');
                    $temp_p = $_GET;
                    unset($temp_p['p']);
                    unset($temp_p['trang']);
                    $data['current_query_price'] = http_build_query($temp_p);
                } else{
                    if($data['current_query'] != ""){
                        $temp_p = $_GET;
                        unset($temp_p['trang']);
                        $data['current_query_price'] = http_build_query($temp_p);
                    }
                }

                $data['sort_r'] = false;
                if ($this->input->get('r')) {
                    $data['sort_r'] = true;
                    $data['sort']['r'] = $this->input->get('r');
                    $temp_r = $_GET;
                    unset($temp_r['r']);
                    unset($temp_r['trang']);
                    $data['current_query_res'] = http_build_query($temp_r);
                } else{
                    if($data['current_query'] != ""){
                        $temp_r = $_GET;
                        unset($temp_r['trang']);
                        $data['current_query_res'] = http_build_query($temp_r);
                    }
                }

                $data['sort_c'] = false;
                if ($this->input->get('c')) {
                    $data['sort_c'] = true;
                    $data['sort']['c'] = $this->input->get('c');
                    $temp_c = $_GET;
                    unset($temp_c['c']);
                    unset($temp_c['trang']);
                    $data['current_query_channel'] = http_build_query($temp_c);
                } else{
                    if($data['current_query'] != ""){
                        $temp_c = $_GET;
                        unset($temp_c['trang']);
                        $data['current_query_channel'] = http_build_query($temp_c);
                    }
                }

                if($parent -> SEOTitle){ $data['SEOTitle'] = $parent -> SEOTitle;}
                else {$data['SEOTitle'] = $parent -> Title;}
                if($parent -> SEOKeyword){ $data['SEOKeyword'] = $parent -> SEOKeyword;}
                if($parent -> SEODescription){ $data['SEODescription'] = $parent -> SEODescription;}

                $this -> load -> library('pagination');
                $temp_trang = $_GET;
                unset($temp_trang['trang']);
                $data['current_query_trang'] = http_build_query($temp_trang);
                $config["base_url"] = base_url() . $parent -> Slug . "/?" . $data['current_query_trang'];
                $config["total_rows"] = $this -> products_model -> Get_pagination_number($parent_list,$data['sort']);
                $config["per_page"] = $data["per_page"] = 32;
                $config['page_query_string'] = TRUE;
                $config['query_string_segment'] = 'trang';
                $data['page'] = 0;
                if($this->input->get('trang')){
                    $data['page'] = $this->input->get('trang');
                }
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];

                $this -> pagination -> initialize($config);
                $data['links'] = $this -> pagination -> create_links();

                $data['productsList'] = $this -> products_model -> Get_pagination_product($config["per_page"], $offset, $parent_list, $data['sort'],$parent -> SortingPrice);
                $breadcrumb_list = $this -> products_model -> Get_breadcrumb($parent -> CategoriesProductsID);
                $breadcrumb_list = array_reverse($breadcrumb_list);
                $this -> breadcrumb -> append_crumb('Trang chủ', base_url());
                foreach ($breadcrumb_list as $bl){
                    $this -> breadcrumb -> append_crumb($bl -> Title, base_url() . $bl -> Slug);
                }
                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();

                $this -> load -> view('guest/main_product1.php', $data);
            } else if($this -> sorting_brand_model -> Get_details($slug)) {
                $data['parent'] = $parent = $this -> sorting_brand_model -> Get_details($slug);
                $parent_list = $this -> sorting_brand_model -> Get_categories_tree($data['parent'] -> SortingBrandID);
                $parent_list[] = $data['parent'] -> SortingBrandID;

                if($parent -> SEOTitle){ $data['SEOTitle'] = $parent -> SEOTitle;}
                else {$data['SEOTitle'] = $parent -> Title;}
                if($parent -> SEOKeyword){ $data['SEOKeyword'] = $parent -> SEOKeyword;}
                if($parent -> SEODescription){ $data['SEODescription'] = $parent -> SEODescription;}

                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . $parent -> Slug;
                $config["total_rows"] = $this -> products_model -> Get_pagination_number_by_brand($parent_list);
                $config["per_page"] = $data["per_page"] = 120;
                $config["uri_segment"] = 2;
                $this -> pagination -> initialize($config);
                        
                $data['page'] = ($this -> uri -> segment(2)) ? $this -> uri -> segment(2) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_pagination_product_by_brand($config["per_page"], $offset, $parent_list);
                $data['links'] = $this -> pagination -> create_links();
                $breadcrumb_list = $this -> products_model -> Get_breadcrumb_by_brand($parent -> SortingBrandID);
                $breadcrumb_list = array_reverse($breadcrumb_list);
                $this -> breadcrumb -> append_crumb('Trang chủ', base_url());
                foreach ($breadcrumb_list as $bl){
                    $this -> breadcrumb -> append_crumb($bl -> Title, base_url() . $bl -> Slug);
                }
                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                $data['breadcrumb'] = $this -> breadcrumb -> output();

                $this -> load -> view('guest/main_product1.php', $data);
            } else {
                $data['product'] = $product = $this -> products_model -> Get_details($slug);
                if(empty($data['product'])) {
                    redirect('error-404');
                }
                $data['productImage'] = $this -> products_model -> Prd_image_get_all($product -> ProductsID);
                $data['current_category'] = $current_category = $this -> categories_product_model -> Get_details_by_id($product -> CategoriesProductsID);
                $data['brand'] = $brand = $this -> sorting_brand_model -> Get_details_by_id($product -> SortingBrandID);

                if($product -> SEOTitle){ $data['SEOTitle'] = $product -> SEOTitle;}
                else {$data['SEOTitle'] = $product -> Title;}
                if($product -> SEOKeyword){ $data['SEOKeyword'] = $product -> SEOKeyword;}
                if($product -> SEODescription){ $data['SEODescription'] = $product -> SEODescription;}
                    
                $this -> breadcrumb -> append_crumb('Trang chủ', base_url());
                $breadcrumb_list = $this -> products_model -> Get_breadcrumb($product -> CategoriesProductsID);
                $breadcrumb_list = array_reverse($breadcrumb_list);
                foreach ($breadcrumb_list as $bl){
                    $this -> breadcrumb -> append_crumb($bl -> Title, base_url() . $bl -> Slug);
                }

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);
                
                $data['hightlight'] = $this -> products_model -> Get_hightlight($product -> Hightlight);
                $data['tags'] = $this -> products_model -> get_product_tags($product -> Tags);
                $data['relative'] = $this -> products_model -> Get_relative($current_category -> CategoriesProductsID, $product -> ProductsID);
                // $data['relative_brand'] = $this -> products_model -> Get_relative_by_brand($brand -> SortingBrandID, $product -> ProductsID);
                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $this -> load -> view('guest/main_product2.php', $data);
            }
        }

        function news($slug = ""){
            global $lang;
            $data = $this -> main_model -> general();
            
            
            if(!$slug){
                redirect('error-404');
            } else if ($this -> categories_news_model -> Get_details($slug)) {
                $data['parent'] = $parent = $this -> categories_news_model -> Get_details($slug);
                $parent_list = $this -> categories_news_model -> Get_categories_tree($data['parent'] -> CategoriesNewsID);
                $parent_list[] = $data['parent'] -> CategoriesNewsID;
                $data['news'] = new StdClass();
                $data['news'] -> Slug = 0;

                if($parent -> SEOTitle){ $data['SEOTitle'] = $parent -> SEOTitle;}
                else {$data['SEOTitle'] = $parent -> Title;}
                if($parent -> SEOKeyword){ $data['SEOKeyword'] = $parent -> SEOKeyword;}
                if($parent -> SEODescription){ $data['SEODescription'] = substr($parent -> SEODescription,0,170);}

                $this -> load -> library('pagination');
                $config["base_url"] = base_url() .'tin-tuc/'. $parent -> Slug;
                $config["total_rows"] = $this -> news_model -> Get_pagination_number($parent_list);
                $config["per_page"] = $data["per_page"] = 8;
                $config["uri_segment"] = 3;
                $this -> pagination -> initialize($config);
                        
                $data['page'] = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['newsList'] = $this -> news_model -> Get_pagination_news($config["per_page"], $offset, $parent_list);
                $data['links'] = $this -> pagination -> create_links();
                $breadcrumb_list = $this -> categories_news_model -> Get_breadcrumb($parent -> CategoriesNewsID);
                $breadcrumb_list = array_reverse($breadcrumb_list);
                $this -> breadcrumb -> append_crumb('Trang chủ', base_url());
                foreach ($breadcrumb_list as $bl){
                    $this -> breadcrumb -> append_crumb($bl -> Title, base_url() .'tin-tuc/'. $bl -> Slug);
                }

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(7);

                $data['breadcrumb'] = $this -> breadcrumb -> output();
                $data['menu'] = $this -> menu_model -> Menu_get_all('tin-tuc/' . $slug);

                $this -> load -> view('guest/main_news1.php', $data);
            } else {
                $data['news'] = $news = $this -> news_model -> Get_details($slug);
                if(empty($data['news'])) {
                    redirect('error-404');
                }
                $data['parent'] = $parent = $this -> categories_news_model -> Get_details_by_id($news -> CategoriesNewsID);
                $data['news_hightlight'] = $this -> news_model -> get_news_hightlight($news -> Hightlight);
                $data['news_tag'] = $this -> news_model -> get_news_tags($news -> Tags);

                if($news -> SEOTitle){ $data['SEOTitle'] = $news -> SEOTitle;}
                else {$data['SEOTitle'] = $news -> Title;}
                if($news -> SEOKeyword){ $data['SEOKeyword'] = $news -> SEOKeyword;}
                if($news -> SEODescription){ $data['SEODescription'] = substr($news -> SEODescription,0,170);}

                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $breadcrumb_list = $this -> categories_news_model -> Get_breadcrumb($news -> CategoriesNewsID);
                $breadcrumb_list = array_reverse($breadcrumb_list);
                foreach ($breadcrumb_list as $bl){
                    $this -> breadcrumb -> append_crumb($bl -> Title, base_url() . 'tin-tuc/' . $bl -> Slug);
                }
                $data['breadcrumb'] = $this -> breadcrumb -> output();

                $this -> news_model -> Update_view($data['news'] -> NewsID);

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);

                $data['menu'] = $this -> menu_model -> Menu_get_all('tin-tuc/' . $slug);
                $this -> load -> view('guest/main_news2.php', $data);
            }
        }

        function news_tags($tags){
            global $lang;
            $data = $this -> main_model -> general();

            if(!$tags){
                redirect('error-404');
            } else {
                $data['tag'] = $tag = $this -> news_model -> Get_tag_details($tags);

                if($tag -> SEOTitle){ $data['SEOTitle'] = $tag -> SEOTitle;}
                else {$data['SEOTitle'] = $tag -> Title;}
                if($tag -> SEOKeyword){ $data['SEOKeyword'] = $tag -> SEOKeyword;}
                if($tag -> SEODescription){ $data['SEODescription'] = $tag -> SEODescription;}

                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'tag-tin-tuc/' . $tags;
                $config["total_rows"] = $this -> news_model -> Get_tag_pagination_number($tag -> TagsID);
                $config["per_page"] = $data["per_page"] = 12;
                $config["uri_segment"] = 3;
                $this -> pagination -> initialize($config);
                        
                $data['page'] = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['newsList'] = $this -> news_model -> Get_tag_pagination_news($config["per_page"], $offset, $tag -> TagsID);
                $data['links'] = $this -> pagination -> create_links();

                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Tags: " . $tag -> Title, base_url() ."tag-tin-tuc/". $tag -> Slug);
                $data['breadcrumb'] = $this -> breadcrumb -> output();

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);

                $this -> load -> view('guest/main_tag_news.php', $data);
            }
        }

        function search(){
            global $lang;
            $data = $this -> main_model -> general();

            $option = array();
            if ($this->input->get('t')) {
                $option['t'] = $this->input->get('t');
            }

            $this -> load -> library('pagination');
            $config["base_url"] = base_url() . 'tim-kiem';
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config["total_rows"] = $this -> products_model -> Get_search_pagination_number($option);
            $config["per_page"] = $data["per_page"] = 999;
            $config["uri_segment"] = 3;
            $this -> pagination -> initialize($config);
                        
            $data['page'] = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
            $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
            $data['productsList'] = $this -> products_model -> Get_search_pagination_products($config["per_page"], $offset, $option);
            $data['links'] = $this -> pagination -> create_links();
            $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
            $this -> breadcrumb -> append_crumb("Tìm kiếm", $config['first_url']);

            $data['breadcrumb'] = $this -> breadcrumb -> output();
			
			$data['latest_news'] = $this -> news_model -> Get_latest_news(3);
            $data['parent'] = new StdClass();
            $data['parent'] -> Title = "";

            $this -> load -> view('guest/main_product1.php', $data);
        }

        function products_tags($tags){
            global $lang;
            $data = $this -> main_model -> general();

            if(!$tags){
                redirect('error-404');
            } else {
                $data['tag'] = $tag = $this -> products_model -> Get_tag_details($tags);

                if($tag -> SEOTitle){ $data['SEOTitle'] = $tag -> SEOTitle;}
                else {$data['SEOTitle'] = $tag -> Title;}
                if($tag -> SEOKeyword){ $data['SEOKeyword'] = $tag -> SEOKeyword;}
                if($tag -> SEODescription){ $data['SEODescription'] = $tag -> SEODescription;}

                $this -> load -> library('pagination');
                $config["base_url"] = base_url() . 'tag-san-pham/' . $tags;
                $config["total_rows"] = $this -> products_model -> Get_tag_pagination_number($tag -> TagsID);
                $config["per_page"] = $data["per_page"] = 12;
                $config["uri_segment"] = 3;
                $this -> pagination -> initialize($config);
                        
                $data['page'] = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
                $offset = ($data['page']  == 0) ? 0 : ($data['page'] * $config['per_page']) - $config['per_page'];
                $data['productsList'] = $this -> products_model -> Get_tag_pagination_products($config["per_page"], $offset, $tag -> TagsID);
                $data['links'] = $this -> pagination -> create_links();

                $this -> breadcrumb -> append_crumb("Trang chủ", base_url());
                $this -> breadcrumb -> append_crumb("Tags: " . $tag -> Title, base_url() ."tag-san-pham/". $tag -> Slug);
                $data['breadcrumb'] = $this -> breadcrumb -> output();

                $data['SellerProducts'] = $this -> products_model -> Get_seller_products(6);
                $data['latest_news'] = $this -> news_model -> Get_latest_news(3);

                $this -> load -> view('guest/main_tag_products.php', $data);
            }
        }
        
        function lien_he(){
            global $lang;
            
            $data = $this -> main_model -> general();
            $data['lang'] = $lang;
            $data['message'] = "";
            $data['SEOTitle'] = "Liên hệ";
            $data['menu'] = $this -> menu_model -> Menu_get_all('lien-he');
            $this -> breadcrumb -> append_crumb('Trang chủ', base_url());
            $this -> breadcrumb -> append_crumb("Liên hệ", base_url() .'lien-he');
            $data['breadcrumb'] = $this -> breadcrumb -> output();

            $this->form_validation->set_rules('fullname', "Họ và tên", 'trim|required');
            $this->form_validation->set_rules('phone', "Số điện thoại", 'trim|required');
            $this->form_validation->set_rules('email', 'Địa chỉ Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('contactDetail', 'Câu hỏi và bình luận' , 'trim|required');
                
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>', '</div>');
                
            if($this -> form_validation -> run()) {
                $subjectLine = "Thông tin liên hệ khách hàng đến Máy bơm nước từ " . $this -> input -> post('fullname');

                $Body  = "Thông tin liên hệ khách hàng:<br/>";
                $Body .= "Họ tên  : ".$this -> input -> post('fullname')."<br/>";
                $Body .= "Phone   : ".$this -> input -> post('phone')."<br/>";
                $Body .= "Email   : ".$this -> input -> post('email')."<br/>";
                $Body .= "Nội dung liên hệ:<br/>".$this -> input -> post('contactDetail');
                        
                
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'thanh.pham@htsb.com.vn', // change it to yours
                    'smtp_pass' => 'Snowwolf!', // change it to yours
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
                $this -> load -> library('email',$config);
                $this -> email -> set_newline("\r\n");
                $this -> email -> from('thanh.pham@htsb.com.vn');
                $this -> email -> to('thanh.phamquang1991@gmail.com');
                        
                $this -> email -> subject($subjectLine);
                $this -> email -> message($Body);
                        
                if($this->email->send()){
                    $data['message'] = "Đăng ký liên hệ của bạn đã được gửi. Chúng tôi sẽ liên hệ với bạn một cách nhanh nhất. Xin cảm ơn.";
                }
                else{ show_error($this->email->print_debugger()); }
                $this->load->view('guest/main_contact', $data);
            } else {
                $this->load->view('guest/main_contact', $data);
            }
        }

        function gio_hang() {
            global $lang;
            $data = $this -> main_model -> general();
            
            $this -> load -> view('guest/main_cart1', $data);
        }

        function don_hang() {
            //exit('f');
            if ($this -> cart -> total_items() < 1) {
                redirect('gio-hang');
            }
            // if ($this -> flexi_auth -> is_logged_in()) {
            //     redirect('giao-hang'); } 
            else {
                session_start();
                global $lang;
                if ($this -> input -> post('submit_search')) {
                    redirect('tim-kiem/' . urlencode($this -> input -> post('keyword')), 'refresh');
                }
                $data = $this -> main_model -> general();
                $data['message'] = "";
                $data['cart_guest'] = array();
                if(isset($_SESSION['cart_guest'])) {
                    $data['cart_guest'] = $_SESSION['cart_guest'];
                }

                if ($this->input->post('submit_guest')) {
                    //var_dump($_POST); exit();
                    $this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
                    $this->form_validation->set_rules('phone', 'Điện thoại', 'trim|required');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                    $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required');
                }
                // else if ($this->input->post('submit_user')) {
                //     $this->form_validation->set_rules('username', 'Tài khoản', 'trim|required');
                //     $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
                // }
                $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>', '</div>');
                if (!$this -> form_validation -> run()) {
                    //var_dump($data); exit();
                    $this -> load -> view('guest/main_cart2', $data);
                }
                else {
                    if ($this -> input-> post('submit_guest')){
                        $cart_guest = array(
                            'fullname' => $this -> input -> post('fullname'),
                            'phone' => $this -> input -> post('phone'),
                            'email' => $this -> input -> post('email'),
                            'address' => $this -> input -> post('address'),
                        );
                        //var_dump($cart_guest); exit('l');

                        $_SESSION['cart_guest'] = $cart_guest;
                        //var_dump($_SESSION['cart_guest']); exit('lojgf');
                        redirect('thanh-toan'); 
                    }
                    // else if ($this -> input-> post('submit_user')){
                    //     $this -> flexi_auth -> login(
                    //         $this -> input -> post('username'),
                    //         $this -> input -> post('password'),
                    //         true);
                    //     $data['message'] = $this -> flexi_auth -> get_messages();
                    //     if ($this -> flexi_auth -> is_logged_in()) {
                    //         unset($_SESSION['cart_guest']);
                    //         redirect('giao-hang');
                    //     } else{
                    //         $this -> load -> view('guest/main_cart2', $data);
                    //     }
                    // }
                }
            }
        }

        function giao_hang(){
            if ($this -> cart -> total_items() < 1) {
                redirect('gio-hang');
            } else {
                session_start();
                $data = $this -> main_model -> general();
                if ($this -> input -> post('submit_search')) {
                    redirect('tim-kiem/' . $this -> input -> post('keyword'), 'refresh');
                }
                $data['seo'] = $this -> main_model -> get_seo_default();
                $data['title'] = lang("main.Cart");
                $data['message'] = "";
                $data['select_city'] = $this -> main_model -> get_city();
                $data['address_list'] = $this -> main_model -> get_user_shipping($data['current_user'] -> uacc_id);
                $data['updateshipping'] = array();

                if ($this -> input -> post('submit2')) {
                    $this->form_validation->set_rules('update_address', 'Địa chỉ', 'trim|required');

                    if (!$this -> form_validation -> run()) {
                        redirect('giao-hang');
                    } else {
                        $this -> main_model -> update_user_shipping($this -> input -> post('update_id'));
                        redirect('giao-hang');
                    }
                }

                if ($this -> input -> post('submit_update')) {
                    $data['updateshipping'] = $this -> main_model -> get_user_shipping_by_id($this -> input -> post('id'));
                }
                if ($this -> input -> post('submit_delete')) {
                    $this -> main_model -> delete_user_shipping($this -> input -> post('id'));
                    redirect('giao-hang');
                }

                if (!$this -> form_validation -> run()) {
                    $this -> load -> view('guest/main_cart2_5', $data);
                }

                if ($this -> input -> post('submit_insert')) {
                    $this -> form_validation -> set_rules('insert_address', 'Địa chỉ', 'trim|required');
                    if ($this -> form_validation -> run()) {
                        $ShipAddressID = $this -> main_model -> insert_user_shipping($data['current_user'] -> uacc_id);
                        redirect('giao-hang');
                    }
                } else if ($this -> input -> post('submit_select')) {
                    $_SESSION['cart_ship'] = $this -> input -> post('id');
                    redirect('thanh-toan');
                }
            }
        }

        function thanh_toan(){
            session_start();
            //var_dump($_SESSION['cart_guest']);
            //exit('test');
            $this -> load -> model('cart_model');
            if ($this -> cart -> total_items() < 1) {
                redirect('gio-hang');
            }
            global $lang;
            
            $data = $this -> main_model -> general();
            

            $grand_total = 0;
            if ($cart = $this->cart->contents()) {
                foreach ($cart as $item) {
                    $grand_total = $grand_total + $item['subtotal'];
                }
            }
            $data['grand_total'] = $grand_total;
            
            if(isset($_SESSION['cart_guest'])) {
                $cart_guest = $_SESSION['cart_guest'];
                $data['user_info'] = array(
                    'fullname' =>  $cart_guest['fullname'],
                    'address' => $cart_guest['address'],
                    'phone' =>  $cart_guest['phone'],
                    'email' => $cart_guest['email'],
                    'shipping_address' => $cart_guest['address']
                );

                if ($this -> input -> post('submit_cart')) {
                    $customer_id = $this -> cart_model -> add_customer();
                    $order_id = $this -> cart_model -> add_orders(0, $customer_id);
                    $this -> cart_model -> add_orders_item($order_id);

                    $subjectLine = "Thông tin đặt hàng đến Máy bơm nước từ " . $data['user_info']['fullname'];
                    $Body  = "Thông tin khách hàng đặt mua sản phẩm:<br/>";
                    $Body .= "Họ tên : ". $data['user_info']['fullname'] ."<br/>";
                    $Body .= "Phone : ". $data['user_info']['phone'] ."<br/>";
                    $Body .= "Địa chỉ : ". $data['user_info']['address'] ."<br/>";
                    $Body .= "Email : ". $data['user_info']['email'] ."<br/>";
                    $Body .= "Tổng giá trị hóa đơn : ". number_format($grand_total,0, "", ".") ." VNĐ<br/><br/>";
                    $Body .= "Địa chỉ giao hàng : ". $data['user_info']['shipping_address'] ."<br/>";

                    $Body .= "Danh sách sản phẩm : <br/><br/>";
                    
                    if ($cart = $this->cart->contents()) {
                        foreach ($cart as $item) {
                            $Body .= "Tên sản phẩm : ". urldecode($item['name'])  ."<br/>";
                            $Body .= "Đường dẫn : <a href='". base_url() . urldecode($item['slug'])  ."'></a><br/>";
                            $Body .= "Giá tiền : ". number_format($item['price'],0, "", ".")  ." VNĐ<br/>";
                            $Body .= "Số lượng : ". $item['qty']  ."<br/>";
                            $Body .= "Thành tiền : ". number_format($item['price'] * $item['qty'],0, "", ".")  ." VNĐ<br/><br/>";
                        }
                    }
                    
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'thanh.pham@htsb.com.vn', // change it to yours
                        'smtp_pass' => 'Snowwolf!', // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE
                    );
                    $this -> load -> library('email',$config);
                    $this -> email -> set_newline("\r\n");
                    $this -> email -> from('thanh.pham@htsb.com.vn');
                    $this -> email -> to('thanh.phamquang1991@gmail.com');
                    $this -> email -> to($data['user_info']['email']);
                        
                    $this -> email -> subject($subjectLine);
                    $this -> email -> message($Body);
                            
                    $this->email->send();

                    $this->cart->destroy();
                    $message = "Xin chúc mừng ! Đơn hàng của bạn đã được gửi đi. Chúng tôi sẽ liên hệ và giao hàng đến với bạn một cách nhanh nhất. Xin cảm ơn.";
                    $this -> trang_chu($message);
                } else {
                    $this -> load -> view('guest/main_cart3', $data);
                }
            } 
            // else if ($this -> flexi_auth -> is_logged_in() == true) {
            //     if(!isset($_SESSION['cart_ship'])) {
            //         redirect('giao-hang');
            //     }
            //     $current_user = $this -> flexi_auth -> get_user_by_id($this -> flexi_auth -> get_user_id()) -> row();
            //     $selected_address = $this -> main_model -> get_user_shipping_by_id($_SESSION['cart_ship']);
            //     $data['user_info'] = array(
            //         'fullname' =>  $current_user -> user_fullname,
            //         'address' => $current_user -> user_address,
            //         'city' => $current_user -> user_city,
            //         'phone' =>  $current_user -> user_phone,
            //         'email' => $current_user -> uacc_email,
            //         'shipping_address' => $selected_address -> shipping_address,
            //         'shipping_city' => $selected_address -> shipping_city,
            //         'shipping_address_type' => $selected_address -> shipping_address_type
            //     );

            //     if ($this -> input -> post('submit_cart')) {
            //         $order_id = $this -> cart_model -> add_orders(1, $current_user -> uacc_id);
            //         $this -> cart_model -> add_orders_item($order_id);
            //         $this -> cart_model -> add_orders_shipping($order_id);
                    
            //         $subjectLine = "Thông tin đặt mua hàng từ " . $data['user_info']['fullname'];
            //         $Body  = "Thông tin khách hàng đặt mua sản phẩm:<br/>";
            //         $Body .= "Họ tên : ". $data['user_info']['fullname'] ."<br/>";
            //         $Body .= "Phone : ". $data['user_info']['phone'] ."<br/>";
            //         $Body .= "Địa chỉ : ". $data['user_info']['address'] ."<br/>";
            //         $Body .= "Email : ". $data['user_info']['email'] ."<br/>";
            //         $Body .= "Tổng hóa đơn : ". number_format($grand_total,0, "", ".") ." VNĐ<br/><br/>";
            //         $Body .= "Địa chỉ giao hàng : ". $data['user_info']['shipping_address'] ."<br/>";
            //         $Body .= "Thành phố : ". $data['user_info']['city'] ."<br/>";
            //         $Body .= "Hình thức thanh toán : ". $data['user_info']['shipping_address_type'] ."<br/>";

            //         $Body .= "Danh sách sản phẩm : <br/><br/>";
                    
            //         if ($cart = $this->cart->contents()) {
            //             foreach ($cart as $item) {
            //                 $Body .= "Tên sản phẩm : ". urldecode($item['name'])  ."<br/>";
            //                 $Body .= "Mã sản phẩm : ". $item['code']  ."<br/>";
            //                 $Body .= "Giá tiền : ". number_format($item['price'],0, "", ".")  ." VNĐ<br/>";
            //                 $Body .= "Số lượng : ". $item['qty']  ."<br/>";
            //                 $Body .= "Thành tiền : ". number_format($item['price'] * $item['qty'],0, "", ".")  ." VNĐ<br/><br/>";
            //             }
            //         }
                    
            //         $this->load->library('email');
                    
            //         $config['protocol'] = 'sendmail';
            //         $config['charset'] = 'utf-8';
            //         $config['wordwrap'] = TRUE;
            //         $config['mailtype'] = 'html';
            //         $this -> email -> initialize($config);
                    
            //         $this -> email -> from($data['user_info']['email'], $data['user_info']['fullname']);
            //         $this -> email -> to('duong_dan_den_email_nhan_dat_hang@gmail.com'); 
            //         //$this -> email-> cc($this -> input -> post('email'));
                    
            //         $this -> email -> subject($subjectLine);
            //         $this -> email -> message($Body);
            //         $this -> email -> send();

            //         $this->cart->destroy();
            //         $this -> load -> view('guest/main_cart_success', $data);
            //     } else {
            //         $this -> load -> view('guest/main_cart3', $data);
            //     }
            // }
            else {
                redirect('');
            }
        }

        function addcart() {
            $this -> load -> model('cart_model');
            $insert_room = array(
                'id' => $this -> input -> post('id'),
                'qty' => $this -> input -> post('qty'),
                'price' => $this -> input -> post('price'),
                'name' => urlencode($this -> input-> post('name')),
                'slug' => $this -> input -> post('slug'),
                'image' => $this -> input-> post('image'),
                'SKU' => $this -> input-> post('SKU')
            );
            $this -> cart -> insert($insert_room);
            redirect('gio-hang');
        }

        function removecart($rowid) {
            $data = $this -> main_model -> general();
            if ($rowid == "all"){
                $this -> cart -> destroy();
             } else {
                $data = array(
                    'rowid'   => $rowid,
                    'qty'     => 0
                );
                $this -> cart -> update($data);
            }
            redirect('gio-hang');
        }

        function update_cart(){
            $data = $this -> main_model -> general();
            $this -> load -> model('cart_model');
            foreach($_POST['cart'] as $cart)
            {
                $price = $cart['price'];
                $amount = $price * $cart['qty'];
                
                $this -> cart_model -> update_cart($cart['rowid'], $cart['qty'], $price, $amount);
            }
            redirect('gio-hang');
        }
    }
?>