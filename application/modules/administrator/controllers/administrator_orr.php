<?php
    class Administrator extends CMS_AdminController {
        function __construct()
        {
        	parent::__construct();
        }

        function index() {
            $this -> load -> view('includes/header');
            $this -> load -> view('home');
            $this -> load -> view('includes/footer');
        }

/*********** Ben duoi la cac method thao tac voi products
************************************************************************************************/

        /*
        **  dieu huong cho cac thao tac voi product
        **  @param : + action => neu co action (edit, add) thi thuc thi theo action
        **           + prdid => la id cua product truyen vao de lay ra hoac cap nhat thong tin cua product
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function products($action = false, $prdid = false,$submit = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_product($prdid);
                        break;
                    }
                    case 'add' : {
                        $this -> add_product();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {// show alll....
                $this -> default_product();
            }
        }

        private function default_product() {

            global $PermissView;

            $roleid = $this -> session -> userdata('roleid');

            $flag = $this -> hasPermission('Product',$roleid,$PermissView);

            if($flag) {
                $this -> load -> model('products_model');
                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');
                $cate = $this->input->get('cate');

                $whereClause = " 1=1 ";
                if($key) {
                    $whereClause .= " and products.Title like '%".$key."%'";
                }
                if($cate && $cate != '') {
                    $whereClause .= " and products.CategoriesProductsID =".$cate;
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;
                    $this -> load -> model('categories_product_model');
                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();

                    $productlist = $this -> products_model -> Products_get_all($start,$show,$whereClause);
                    $data['products_list'] = $productlist -> result_array();
                }

                if(count($data['products_list']) > 0)
                    $count = $data['products_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> products_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('products_view');
                $this -> load -> view('includes/footer');
            }else {
                echo "Do not have permission";
            }
        }

        private function add_product() {
            global $PermissAddNew;

            $roleid = $this -> session -> userdata('roleid');

            $flag = $this -> hasPermission('Product',$roleid,$PermissAddNew);

            if($flag) {
                $this -> load -> model('products_model');
                $this -> load -> model('categories_product_model');
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $data['categories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                if(!$this -> isAjax()) {

                    $this -> form_validation -> set_rules('prdTitle','Tên Sản Phẩm','trim|required');

                    $this -> form_validation -> set_rules('prdSellPrice','Giá bán','trim|required|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('products_add_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> products_model -> Products_insert()) {
                            redirect(base_url()."administrator/products");
                        }else {
                            echo "fail";
                        }

                    }
                }else {
                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('products_add_view');
                    $this -> load -> view('includes/footer');
                }
            }else {
                echo "Do not have permissions";
            }
        }

        private function edit_product($prdid = false) {

            global $PermissEdit;

            $roleid = $this -> session -> userdata('roleid');

            $flag = $this -> hasPermission('Product',$roleid,$PermissEdit);

            if($flag) {

                if($prdid !== false) {
                    $this -> load -> model('categories_product_model');
                    $this -> load -> model('districts_model');
                    $this -> load -> model('products_model');
                    $this -> load -> model('images_product_model');

                    $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                    $product = $this -> products_model -> Products_get_by_id($prdid);
                    $data['product'] = $product -> row_array();

                    if(count($data['product']) <= 0) show_404();
                    $images = $this -> images_product_model -> Prd_image_get_all($prdid);
                    $data['images'] = $images -> result_array();

                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                    $data['districts_list'] = $this -> districts_model -> getAllForSelect();


                    // thuc hien khi form edit product duoc submit len server
                    if(!$this -> isAjax()){

                        $this -> form_validation -> set_rules('prdTitle','Tên Sản Phẩm','trim|required');

                        $this -> form_validation -> set_rules('prdSellPrice','Giá bán','trim|required|numeric');
                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('products_edit_view');
                            $this -> load -> view('includes/footer');

                        }else {

                            if($this -> products_model -> Products_update($prdid)) {
                                redirect($this -> getUrl());

                            }else {
                                echo "fail";
                            }

                        }
                    }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('products_edit_view');
                        $this -> load -> view('includes/footer');

                    }
                }else {

                    redirect(base_url().'administrator/products');

                }
            }else {
                echo "Do not have permission";
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi products */



/*********** Ben duoi la cac method thao tac voi productsrating
************************************************************************************************/
        public function productsrating() {
            $this -> load -> model('products_model');
            $currentpage = $this->input->get('page');


            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $rate_list = $this -> products_model -> Product_get_rating($start,$show);
                $data['rating_list'] =  $rate_list -> result_array();
            }

            if(count($data['rating_list']) > 0)
            $count = $data['rating_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> products_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


            $this -> load -> view('includes/header',$data);
            $this -> load -> view('products_rating_view');
            $this -> load -> view('includes/footer');
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi productsrating */



/*********** Ben duoi la cac method thao tac voi orders
************************************************************************************************/

        /*
        **  dieu huong cho cac thao tac voi orders
        **  @param : + action => neu co action (edit, add) thi thuc thi theo action
        **           + oderid => la id cua orders truyen vao de lay ra hoac cap nhat thong tin cua orders
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function orders($action = false, $orderid = false, $submit = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($orderid !== false && is_numeric($orderid)) {
                            $this -> load -> model('orders_model');

                            $order = $this -> orders_model -> Get_orders_by_id($orderid);
                            $data['order'] = $order -> row_array();

                            $orderitems_list = $this -> orders_model -> Get_orders_items($orderid);
                            $data['order']['orderitems_list'] = $orderitems_list -> result_array();

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('orders_details_view');
                            $this -> load -> view('includes/footer');
                            break;
                        }else {
                            redirect(base_url().'administrator/orders');
                        }
                    }
                    case 'add' : {
                        echo 'add';
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {

                $this -> load -> model('orders_model');
                $currentpage = $this->input->get('page');

                $key = $this->input->get('key');
                $stt = $this->input->get('stt');
                $pay = $this->input->get('pay');

                $whereClause = " 1=1 ";
                if($key) {
                    $whereClause .= " and cus.FullName like '%".$key."%'";
                }
                if($stt && $stt != '' && is_numeric($stt)) {
                    $whereClause .= " and orders.OrderStatusID =".$stt;
                }
                if($pay && $pay != '' && is_numeric($pay)) {
                    $whereClause .= " and orders.PaymentsID =".$pay;
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $orders_list = $this -> orders_model -> Get_all_orders($start,$show,$whereClause);
                    $data['orders_list'] = $orders_list -> result_array();
                }

                if(count($data['orders_list']) > 0)
                $count = $data['orders_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> orders_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $orderstatus_list = $this -> orders_model -> Get_all_orders_status();
                $data['orderstatus_list'] = $orderstatus_list -> result_array();

                $payments_list = $this -> orders_model -> Get_all_payments_method();
                $data['payments_list'] = $payments_list -> result_array();

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('orders_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi orders */



/*********** Ben duoi la cac method thao tac voi news
************************************************************************************************/

        /*
        **  dieu huong cho cac thao tac voi news
        **  @param : + action => neu co action (edit, add) thi thuc thi theo action
        **           + newid => la id cua news truyen vao de lay ra hoac cap nhat thong tin cua news
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function news($action = false, $newid = false,$submit = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_news($newid);
                        break;
                    }
                    case 'add' : {
                        $this -> add_news();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> default_news();
            }
        }

        private function default_news() {
            $this -> load -> model('news_model');
            $currentpage = $this->input->get('page');

            $key = $this->input->get('key');
            $cate = $this->input->get('cate');

            $whereClause = '0=0';
            if($key) {
                $whereClause .= " and news.Title like '%".$key."%'";
            }
            if($cate && $cate != '') {
                $whereClause .= " and news.CategoriesNewsID =".$cate;
            }

            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;
                $this -> load -> model('categories_news_model');
                $data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();

                $news_list = $this -> news_model -> News_get_all($start,$show,$whereClause);
                $data['news_list'] = $news_list -> result_array();
            }

            if(count($data['news_list']) > 0)
            $count = $data['news_list'][0]['count'];
            else $count = 0;

            // if($currentpage > ceil($count/$show)) {
            //     show_404();
            // }

            $data['link'] = $this -> news_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('news_view');
            $this -> load -> view('includes/footer');
        }

        private function add_news() {
            $this -> load -> model('news_model');
            $this -> load -> model('categories_news_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
            if(!$this -> isAjax()){

                $this -> form_validation -> set_rules('newsTitle','Tiêu đề tin tức','trim|required');

                $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> news_model -> News_insert()) {
                        redirect(base_url()."administrator/news");
                    }else {
                        echo "fail";
                    }
                    //echo "kjashdjahsjdhs";
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('news_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        private function edit_news($newid = false) {
            $this -> load -> model('news_model');
            if($newid !== false) {
                $this -> load -> model('categories_news_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $news = $this -> news_model -> News_get_by_id($newid);
                $data['news'] = $news -> row_array();

                if(count($data['news']) <= 0) show_404();


                $data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();


                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('newsTitle','Tiêu đề tin tức','trim|required');

                    $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                    $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('news_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> news_model -> News_update($newid)) {
                            redirect($this -> getUrl());
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {

                redirect(base_url().'administrator/news');

            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi news  */



/*********** Ben duoi la cac method thao tac voi Ads
************************************************************************************************/

        public function ads($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {

                        if($id !== false) {
                            $this -> load -> model('ads_model');
                            $this -> load -> model('ads_groups_model');

                            $ads = $this -> ads_model -> Ads_get_by_id($id);
                            $data['ads'] = $ads -> row_array();

                            $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                            $data['adsgroups_list'] = $adsgroups_list -> result_array();

                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề của quảng cáo','trim|required');
                                $this -> form_validation -> set_rules('Orders','Thứ tự của quảng cáo','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_rules('Height','Chiều cao của quảng cáo','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_rules('Width','Chiều dài của quảng cáo','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('ads_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> ads_model -> Ads_update($id)) {
                                        redirect($this -> getUrl());

                                    }else {
                                        echo "fail";
                                    }

                                }
                            }
                        }
                        break;
                    }
                    case 'add' : {

                        $this -> load -> model('ads_model');
                        $this -> load -> model('ads_groups_model');

                        $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                        $data['adsgroups_list'] = $adsgroups_list -> result_array();

                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề của quảng cáo','trim|required');
                            $this -> form_validation -> set_rules('Orders','Thứ tự của quảng cáo','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_rules('Height','Chiều cao của quảng cáo','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_rules('Width','Chiều dài của quảng cáo','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('ads_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> ads_model -> Ads_insert()) {
                                    redirect(base_url().'administrator/ads');
                                }else {
                                    echo "fail";
                                }

                            }
                        }
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> load -> model('ads_groups_model');
                $this -> load -> model('ads_model');

                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');
                $cate = $this->input->get('cate');

                $whereClause = " 1 = 1 ";
                if($key) {
                    $whereClause .= " and Title like '%".$key."%' ";
                }
                if($cate && $cate != '') {
                    $whereClause .= " and AdsGroupsID = ".$cate;
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                    $data['adsgroups_list'] = $adsgroups_list -> result_array();

                    $ads_list = $this -> ads_model -> Ads_get_all($start,$show,$whereClause);
                    $data['ads_list'] = $ads_list -> result_array();
                }

                if(count($data['ads_list']) > 0)
                $count = $data['ads_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> ads_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                $this -> load -> view('includes/header',$data);
                $this -> load -> view('ads_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi Ads  */



/*********** Ben duoi la cac method thao tac voi SEo
************************************************************************************************/
        public function seo($action = false) {
            $this -> load -> model("seo_default_model");
            if($action !== false ) {
                if($action == "save") {
                    if($this -> seo_default_model -> Update_SEO_information()) {
                        redirect(base_url()."administrator/seo");
                    }else {
                        echo 'fail';
                    }
                }
            }else {
                $data['seo'] = $this -> seo_default_model -> Get_SEO_information();
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('seo_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi SEo  */



/*********** Ben duoi la cac method thao tac voi Menu
************************************************************************************************/
        public function menu($action = false, $menuid = false) {

            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($menuid !== false) {
                            $this -> load -> model('categories_news_model');
                            $this -> load -> model('menu_model');

                            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                            $menu = $this -> menu_model -> Menu_get_by_id($menuid);
                            $data['menu'] = $menu -> row_array();

                            if(count($data['menu']) <= 0) show_404();
                            else $data['menu']['StaticContentJs'] = $this -> objecthelper -> convert_html_to_text_for_js($data['menu']['StaticContent']);


                            //$data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box() -> result_array();
                            $data['parentmenu_list'] = $this -> menu_model -> Menu_get_except_by_id($menuid);

                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề menu','trim|required');

                                // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                                // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('menu_edit_view');
                                    $this -> load -> view('includes/footer');
                                    //echo $data['menu']['StaticContentJs'];

                                }else {

                                    if($this -> menu_model -> Menu_update($menuid)) {
                                        redirect($this -> getUrl());
                                    }else {
                                        echo "fail";
                                    }

                                }
                            }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('menu_edit_view');
                                $this -> load -> view('includes/footer');

                            }
                        }else {

                            redirect(base_url().'administrator/menu');

                        }

                        break;
                    }
                    case 'add' : {
                        $this -> load -> model('categories_news_model');
                        $this -> load -> model('menu_model');

                        $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                        $data['parentmenu_list'] = $this -> menu_model -> Menu_get_all_to_select();

                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề menu','trim|required');

                            // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                            // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('menu_add_view');
                                $this -> load -> view('includes/footer');
                                //echo $data['menu']['StaticContentJs'];

                            }else {

                                if($this -> menu_model -> Menu_insert()) {
                                    redirect(base_url()."administrator/menu");
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('menu_add_view');
                            $this -> load -> view('includes/footer');

                        }
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> load -> model('menu_model');
                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 30;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $data['menu_list'] = $this -> menu_model -> Menu_get_all($start,$show);
                }

                if(count($data['menu_list']) > 0)
                $count = $data['menu_list'][0]['count'];
                else $count = 0;

                // if($currentpage > ceil($count/$show)) {
                //     show_404();
                // }

                $data['link'] = $this -> menu_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('menu_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi Menu  */



/*********** Ben duoi la cac method thao tac voi quan ly footer
************************************************************************************************/
        public function footer($action = false) {
            $this -> load -> model("footer_model");
            if($action !== false) {
                if($action == "save"){
                   if($this -> footer_model ->Footer_update()){
                        redirect(base_url()."administrator/footer");
                   }
                }
            }else {
                $data['footer'] = $this -> footer_model -> Get_Information();
                if(count($data['footer']) <= 0) {
                    $data['footer'] = "";
                }
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('footer_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly footer  */



/*********** Ben duoi la cac method thao tac voi quan ly logo
************************************************************************************************/

        public function logo($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'add' : {
                        $this -> load -> model('logo_model');


                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề của logo','trim|required');

                            $this -> form_validation -> set_rules('logoDescription','Mô tả của logo','trim|numeric');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('logo_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> logo_model -> Logo_insert()) {
                                    redirect(base_url().'administrator/logo');

                                }else {
                                    echo "fail";
                                }

                            }
                        }
                        break;
                    }
                    case 'edit' : {
                        if($id !== false) {
                            $this -> load -> model('logo_model');

                            $logo = $this -> logo_model -> Logo_get_by_id($id);
                            $data['logo'] = $logo -> row_array();


                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề của logo','trim|required');

                                $this -> form_validation -> set_rules('logoDescription','Mô tả của logo','trim|numeric');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('logo_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> logo_model -> Logo_update($id)) {
                                        redirect($this -> getUrl());

                                    }else {
                                        echo "fail";
                                    }

                                }
                            }
                        }
                        break;
                    }
                    default : {
                        show_404();
                        break;
                    }
                }
            }else {

                $this -> load -> model('logo_model');
                $currentpage = $this->input->get('page');

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;
                    $logo_list = $this -> logo_model -> Logo_get_all($start,$show);
                    $data['logo_list'] = $logo_list -> result_array();
                }

                if(count($data['logo_list']) > 0)
                $count = $data['logo_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> logo_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                $this -> load -> view('includes/header',$data);
                $this -> load -> view('logo_view');
                $this -> load -> view('includes/footer');
            }

        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly logo  */



/*********** Ben duoi la cac method thao tac voi quan ly favicons
************************************************************************************************/

        public function favicons($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($id !== false) {
                            $this -> load -> model('favicon_model');

                            $favicons = $this -> favicon_model -> Favi_get_by_id($id);
                            $data['favicons'] = $favicons -> row_array();

                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('IconURL','Icon','trim|required');

                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('favicons_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> favicon_model -> Favi_update($id)) {
                                        redirect($this -> getUrl());
                                    }else {
                                        echo "fail";
                                    }

                                }
                            }

                        }else {
                            show_404();
                        }
                        break;
                    }
                    case 'add' : {

                        if(!$this -> isAjax()){
                            $this -> load -> model('favicon_model');

                            $this -> form_validation -> set_rules('IconURL','Icon','trim|required');

                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('favicons_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> favicon_model -> Favi_insert()) {
                                    redirect(base_url().'administrator/favicons');
                                }else {
                                    echo "fail";
                                }

                            }
                        }
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> load -> model('favicon_model');

                $currentpage = $this->input->get('page');


                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $favicon_list = $this -> favicon_model -> Favi_get_all($start,$show);
                    $data['favicon_list'] = $favicon_list -> result_array();
                }

                if(count($data['favicon_list']) > 0)
                $count = $data['favicon_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> favicon_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('favicons_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly favicons  */



/*********** Ben duoi la cac method thao tac voi quan ly banners
************************************************************************************************/

        public function banners($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($id !== false) {
                            $this -> load -> model('Banner_model');

                            $banner = $this -> Banner_model -> Banner_get_by_id($id);
                            $data['banner'] = $banner -> row_array();
                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề của banner','trim|required');
                                $this -> form_validation -> set_rules('Orders','Thứ tự của banner','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_rules('ImageURL','Ảnh banner','trim|required');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('banner_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> Banner_model -> Banner_update($id)) {
                                        redirect($this -> getUrl());
                                    }else {
                                        echo "fail";
                                    }

                                }
                            }
                        }
                        break;
                    }
                    case 'add' : {

                        $this -> load -> model('Banner_model');

                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề của banner','trim|required');
                            $this -> form_validation -> set_rules('Orders','Thứ tự của banner','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_rules('Body','Mô tả của banner','trim|required');
                            $this -> form_validation -> set_rules('ImageURL','Ảnh banner','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('banner_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> Banner_model -> Banner_insert()) {
                                    redirect(base_url().'administrator/banners');
                                }else {
                                    echo "fail";
                                }

                            }

                        }
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {

                $this -> load -> model('Banner_model');

                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');

                $whereClause = " 1 = 1 ";
                if($key) {
                    $whereClause .= " and Title like '%".$key."%' ";
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $banners_list = $this -> Banner_model -> Banner_get_all($start,$show,$whereClause);
                    $data['banners_list'] = $banners_list -> result_array();
                }

                if(count($data['banners_list']) > 0)
                $count = $data['banners_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> Banner_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('banner_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly banners  */



/*********** Ben duoi la cac method thao tac voi quan ly Recruitment
************************************************************************************************/

        public function recruitments($action = false) {
            $this -> load -> model("recruitments_model");
            if($action !== false) {
                if($action == "save"){
                   if($this -> recruitments_model -> Recruitment_update()){
                        redirect(base_url()."administrator/recruitments");
                   }
                }
            }else {
                $data['recruitment'] = $this -> recruitments_model -> Recruitments_get();
                if(count($data['recruitment']) <= 0) {
                    $data['recruitment'] = "";
                }
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('recruitment_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly Recruitment  */



/*********** Ben duoi la cac method thao tac voi hotline
************************************************************************************************/
        public function hotline($action = false,$hotlineid = false) {
            $this -> load -> model("hotline_model");
            if($action !== false) {
                switch($action) {
                    case "add" : {
                        $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                        if(!$this -> isAjax()){


                            $this -> form_validation -> set_rules('hotlineTitle','Tiêu đề hotline','trim|required');

                            $this -> form_validation -> set_rules('hotlinePhone','Số điện thoại','trim|required');
                            // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('hotline_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> hotline_model -> Hotline_insert()) {
                                    redirect(base_url().'administrator/hotline');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/hotline');
                        }
                        break;
                    }
                    case "edit" : {
                        if($hotlineid !== false) {

                            $hotline = $this -> hotline_model -> Get_HotLine_By_Id($hotlineid);
                            $data['hotline'] = $hotline -> row_array();
                            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';


                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('hotlineTitle','Tiêu đề hotline','trim|required');

                                $this -> form_validation -> set_rules('hotlinePhone','Số điện thoại','trim|required');
                                // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('hotline_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> hotline_model -> Hotline_update($hotlineid)) {
                                        redirect($this -> getUrl());
                                    }else {
                                        echo "fail";
                                    }

                                }
                            }else {
                                redirect(base_url().'administrator/hotline');
                            }
                        }
                        break;
                    }
                    default : {
                        break;
                    }
                }
            }else {

                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 30;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $hotline_list = $this -> hotline_model -> Get_All_Hotline($start,$show);
                    $data['hotline_list'] = $hotline_list -> result_array();
                }

                if(count($data['hotline_list']) > 0)
                    $count = $data['hotline_list'][0]['count'];
                else $count = 0;

                $data['link'] = $this -> hotline_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('hotline_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly hotline  */



/*********** Ben duoi la cac method thao tac voi ho tro truc tuyen
************************************************************************************************/
        public function supportonline($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('support_online_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['support'] = $this -> support_online_model -> Get_support_by_id($id);

                            if(count($data['support']) > 0) {
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('supportTitle','Tiêu đề hỗ trợ trực tuyến','trim|required');

                                    $this -> form_validation -> set_rules('supportPhone','Số điện thoại','trim|required');
                                    $this -> form_validation -> set_rules('supportEmail','Email','trim|required|valid_email');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {


                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('supportonline_edit_view');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> support_online_model -> Support_update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/supportonline');
                                }
                            }else {
                                show_404();
                            }
                        }

                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('supportTitle','Tiêu đề hỗ trợ trực tuyến','trim|required');

                            $this -> form_validation -> set_rules('supportPhone','Số điện thoại','trim|required');
                            $this -> form_validation -> set_rules('supportEmail','Email','trim|required|valid_email');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {


                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('supportonline_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> support_online_model -> Support_insert()) {
                                    redirect(base_url().'administrator/supportonline');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/supportonline');
                        }
                        break;
                    }
                    default:
                        break;
                }
            }else {

                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 30;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $support_list = $this -> support_online_model -> Get_all_suppport($start,$show);
                    $data['support_list'] = $support_list -> result_array();
                }

                if(count($data['support_list']) > 0)
                    $count = $data['support_list'][0]['count'];
                else $count = 0;

                $data['link'] = $this -> support_online_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('supportonline_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi ho tro truc tuyen */



/*********** Ben duoi la cac method thao tac voi categories
************************************************************************************************/


        /*
        **  dieu huong cho cac thao tac voi categories
        **  @param : + module => la ten cua module can truy cap toi (prduct, news, .....)
        **           + action => neu co action (edit, add) thi thuc thi theo action
        **           + cateid => la id cua categories truyen vao de lay ra hoac cap nhat thong tin cua categories
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function categories($module = false,$action = false, $cateid = false,$submit = false) {
            if($module !== false && $module == "product") {
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            $this -> edit_product_category($cateid);
                            break;
                        }
                        case 'add' : {
                            $this -> add_product_category();
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_product_categories();
                }

            }else if($module !== false && $module == "news") {
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            $this -> edit_news_categories($cateid);
                            break;
                        }
                        case 'add' : {
                            $this -> add_news_categories();
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_news_category();
                }
            }else if($module !== false && $module == "ads"){
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            if($cateid !== false) {
                                if(!$this -> isAjax()) {
                                    $this -> load -> model('ads_groups_model');

                                    $adsgroups = $this -> ads_groups_model -> Ads_groups_get_by_id($cateid);
                                    $data['adsgroups'] = $adsgroups -> row_array();

                                    $this -> form_validation -> set_rules('Title','Tên nhóm quảng cáo','trim|required');

                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('ads_group_edit_view');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> ads_groups_model -> Ads_groups_update($cateid)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }
                                    }
                                }
                            }

                            break;
                        }
                        case 'add' : {

                            if(!$this -> isAjax()) {
                                $this -> load -> model('ads_groups_model');

                                $this -> form_validation -> set_rules('Title','Tên nhóm quảng cáo','trim|required');

                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('ads_group_add_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> ads_groups_model -> Ads_groups_insert()) {
                                        redirect(base_url()."administrator/categories/ads");
                                    }else {
                                        echo "fail";
                                    }
                                    echo "jahskjdha";
                                }
                            }
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {

                    $this -> load -> model('ads_groups_model');
                    $currentpage = $this->input->get('page');
                    if($currentpage == '') $currentpage = 1;
                    $start;
                    $show = 30;
                    if(isset($currentpage) && $currentpage != '') {
                        $start = ($currentpage-1)*$show;

                        $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_all($start,$show);
                        $data['adsgroups_list'] = $adsgroups_list -> result_array();
                    }

                    if(count($data['adsgroups_list']) > 0)
                    $count = $data['adsgroups_list'][0]['count'];
                    else $count = 0;

                    if($currentpage > ceil($count/$show)) {
                        //show_404();
                    }

                    $data['link'] = $this -> ads_groups_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('ads_group_view');
                    $this -> load -> view('includes/footer');

                }
            }else if($module !== false && $module == "districts"){
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            if($cateid !== false) {
                                if(!$this -> isAjax()) {
                                    $this -> load -> model('districts_model');

                                    $districts = $this -> districts_model -> getById($cateid);
                                    $data['districts'] = $districts;

                                    $this -> form_validation -> set_rules('Title','Tên quận huyện','trim|required');

                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('district_edit_view');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> districts_model -> update($cateid)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }
                                    }
                                }
                            }

                            break;
                        }
                        case 'add' : {

                            if(!$this -> isAjax()) {
                                $this -> load -> model('districts_model');

                                $this -> form_validation -> set_rules('Title','Tên quận huyện','trim|required');

                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('district_add_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> districts_model -> insert()) {
                                        redirect(base_url()."administrator/categories/districts");
                                    }else {
                                        echo "fail";
                                    }
                                    echo "jahskjdha";
                                }
                            }
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {

                    $this -> load -> model('districts_model');
                    $currentpage = $this->input->get('page');
                    if($currentpage == '') $currentpage = 1;
                    $start;
                    $show = 30;
                    if(isset($currentpage) && $currentpage != '') {
                        $start = ($currentpage-1)*$show;

                        $district_list = $this -> districts_model -> getAll($start,$show);
                        $data['district_list'] = $district_list;
                    }

                    if(!empty($data['district_list']) && count($data['district_list']) > 0)
                    $count = $data['district_list'][0]['count'];
                    else $count = 0;

                    if($currentpage > ceil($count/$show)) {
                        //show_404();
                    }

                    $data['link'] = $this -> districts_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('district_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }


    /***************** Product categories method
    *******************************************************************************/
        private function default_product_categories() {
            $this -> load -> model('categories_product_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 30;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> categories_product_model -> Category_get_all($start,$show);
            }

            if(count($data['category_list']) > 0)
            $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> categories_product_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('product_categories_view');
            $this -> load -> view('includes/footer');
        }

        private function add_product_category() {

            $this -> load -> model('categories_product_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('product_categories_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> categories_product_model -> Category_insert()) {
                        redirect(base_url()."administrator/categories/product");
                    }else {
                        echo "fail";
                    }
                    //echo "jahskjdha";
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('product_categories_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        private function edit_product_category($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('categories_product_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> categories_product_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> categories_product_model -> Category_get_except_by_id($cateid);
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('product_categories_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> categories_product_model -> Category_update($cateid)) {
                            redirect($this -> getUrl());

                        }else {
                            echo "fail";
                        }
                        //echo "kajshdjhasdkj";

                    }
                }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('product_categories_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

    /*******************************************************************************
    ***************** End Product categories method
    *******************************************************************************/



    /***************** News_Categories categories method
    *******************************************************************************/

        public function default_news_category() {
            $this -> load -> model('categories_news_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 30;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> categories_news_model -> Categoriesnews_get_all($start,$show);
            }

            if(count($data['category_list']) > 0)
                $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> categories_news_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('news_categories_view');
            $this -> load -> view('includes/footer');
        }

        public function add_news_categories() {
            $this -> load -> model('categories_news_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_categories_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> categories_news_model -> Categoriesnews_insert()) {
                        redirect(base_url()."administrator/categories/news");
                    }else {
                        echo "fail";
                    }
                    //echo "jahskjdha";
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('news_categories_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        public function edit_news_categories($cateid) {
            if($cateid !== false ) {
                $this -> load -> model('categories_news_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> categories_news_model -> Categoriesnews_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> categories_news_model -> Categoriesnews_get_except_by_id($cateid);
                if(count($data['category']) <= 0) show_404();

                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('news_categories_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> categories_news_model -> Categoriesnews_update($cateid)) {
                            redirect($this -> getUrl());

                        }else {
                            echo "fail";
                        }
                        //echo "kajshdjhasdkj";

                    }
                }else {// truong hop nguoc lai, thi hiwn thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('product_categories_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

    /*******************************************************************************
    ***************** End News_Categories categories method
    *******************************************************************************/


    /***************** Ads categories method
    *******************************************************************************/

        public function  default_ads_categories() {

        }

    /*******************************************************************************
    ***************** End Ads categories method
    *******************************************************************************/

/************************************************************************************************
*********** ket thuc thao tac voi categories
*******************************************************************************/

/********************** CONFIGS
*********************************************************************************************/

        public function adminpassword() {

            $this -> load -> model("memberships_model");
            $data['msg'] = "";
            if(!$this -> isAjax()){

                $this -> form_validation -> set_rules('oldpassword','Mật khẩu cũ','trim|required');

                $this -> form_validation -> set_rules('password','Mật khẩu','trim|required');
                $this -> form_validation -> set_rules('confirmpassword','Xác nhân mật khẩu','trim|required');

                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('change_password_view');
                    $this -> load -> view('includes/footer');
                }else {

                    if($this -> memberships_model -> change_password()) {
                        redirect(base_url().'administrator/logout');
                    }else {
                        $data['msg'] = "Mật khẩu cũ không đúng";

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('change_password_view');
                        $this -> load -> view('includes/footer');
                    }

                }
            }
        }
/********************** END CONFIGS
*********************************************************************************************/

    }
?>