<?php
	class Main_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function general() {
			global $data;
			global $lang;
			$data['current_lang'] = $this -> lang -> mci_current();
			$data['current_url'] = $this -> getUrl();
			$data['current_function'] = $this -> router -> fetch_method();
			$this -> lang -> load('main');
			$this -> load -> model('logo_model');
			$this -> load -> model('favicon_model');
			$this -> load -> model('webinfor_model');
			$this -> load -> model('seo_default_model');

			$this -> load -> model('menu_model');
			$this -> load -> model('support_online_model');
			$this -> load -> model('categories_product_model');
			$this -> load -> model('sorting_brand_model');
			$this -> load -> model('categories_news_model');
			$this -> load -> model('news_model');
			$this -> load -> model('products_model');
			$this -> load -> model('footer_model');
			//$this -> load -> model('testimonials_model');
			$this -> load -> model('ads_model');
			$this -> load -> model('partners_model');

			$data['lang'] = $lang;

			$data['menu'] = $this -> menu_model -> Menu_get_all();
			$data['menuResponsive'] = $this -> menu_model -> MenuResponsive_get_all();
			$data['hotline'] = $this -> support_online_model -> Get_All_Hotline();
			$data['support_online'] = $this -> support_online_model -> Get_All_Support_Online();
			$data['footers'] = $this -> footer_model -> Footer_get_all();
			$data['adv_left'] = $this -> ads_model -> Ads_get_for_show(1);
			$data['logo'] = $this -> logo_model -> Logo_get();
			$data['gioithieu'] = $this -> news_model -> Get_details_by_id(1);
			$data['congtrinh'] = $this -> news_model -> Get_hot(25,4);
			$data['menu_cate'] = $this -> categories_product_model -> Category_get_all_for_menu();
			$data['cate_menu'] = $this -> categories_product_model -> Category_get_all_for_menu();

			$data['HotProducts'] = $this -> products_model -> Get_hot_products(5);
			$data['NewProducts'] = $this -> products_model -> Get_new_products(8);
            $data['SellerProducts'] = $this -> products_model -> Get_seller_products(5);
            $data['PromoProducts'] = $this -> products_model -> Get_promotion_products(8);

			$data['child_news_1'] = $this -> news_model -> Get_child_news(17, 1);
			$data['child_news_2'] = $this -> news_model -> Get_child_news(17, 3, 1);

			$data['sanpham1'] = $this -> categories_product_model -> Get_child_products(1,4,0);
			$data['sanpham2'] = $this -> categories_product_model -> Get_child_products(2,4,0);
			$data['sanpham3'] = $this -> categories_product_model -> Get_child_products(3,4,0);
			$data['sanpham4'] = $this -> categories_product_model -> Get_child_products(4,4,0);
			$data['sanpham5'] = $this -> categories_product_model -> Get_child_products(5,4,0);
			$data['sanpham6'] = $this -> categories_product_model -> Get_child_products(6,4,0);
			$data['sanpham7'] = $this -> categories_product_model -> Get_child_products(7,4,0);
			$data['sanpham8'] = $this -> categories_product_model -> Get_child_products(8,4,0);
			
			$data['cart_counter'] = 0;
			if($this->cart->contents()){
				$data['cart_counter'] = $this->cart->total_items();
			}

			$data['message'] = "";

			$favicon = $this -> favicon_model -> Favicon_get();
					($favicon !== false && (count($favicon) > 0)) ? $data['favicon'] = $favicon['IconURL'] : $data['favicon'] = "";


			$seo = $this -> seo_default_model -> Get_seo_default();
			((count($seo) > 0) && $seo['SEOTitle'] ) ? $data['SEOTitle'] = $seo['SEOTitle'] : $data['SEOTitle'] = "Default";
			((count($seo) > 0) && $seo['SEOKeyword'] ) ? $data['SEOKeyword'] = $seo['SEOKeyword'] : $data['SEOKeyword'] = "Default";
			((count($seo) > 0) && $seo['SEODescription'] ) ? $data['SEODescription'] = $seo['SEODescription'] : $data['SEODescription'] = "Default";


			return $data;
		}
	}
?>