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
                    case 'clone' : {
                        $this -> clone_product($prdid);
                        break;
                    }
                    case 'fast' : {
                        $this -> fast_product();
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
                $brand = $this->input->get('brand');

                $whereClause = " 1=1 ";
                if($key) {
                    $whereClause .= " and products.Title like '%".$key."%' or products.SKU like '%".$key."%' ";
                }
                if($cate && $cate != '') {
                    $whereClause .= " and products.CategoriesProductsID =".$cate;
                }
                if($brand && $brand != '') {
                    $whereClause .= " and products.SortingBrandID =".$brand;
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;
                    $this -> load -> model('categories_product_model');
                    $this -> load -> model('sorting_brand_model');
                    $this -> load -> model('sorting_res_model');
                    $this -> load -> model('sorting_channel_model');
                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                    $data['brand_list'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                    $data['res_list'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                    $data['channel_list'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();

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
                $this -> load -> model('sorting_brand_model');
                $this -> load -> model('sorting_res_model');
                $this -> load -> model('sorting_channel_model');
                $this -> load -> model('products_tags_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $data['categories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                $data['brand_list'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                $data['res_list'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                $data['channel_list'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
                $data['hightlightproducts'] = $this -> products_model -> Products_get_all_for_select_box();
                $data['tags'] = $this -> products_tags_model -> Tags_get_all_for_select_box();
                if(!$this -> isAjax()) {

                    $this -> form_validation -> set_rules('prdTitle','Tên Sản Phẩm','trim|required');
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
                    $this -> load -> model('sorting_brand_model');
                    $this -> load -> model('sorting_res_model');
                    $this -> load -> model('sorting_channel_model');
                    $this -> load -> model('products_model');
                    $this -> load -> model('images_product_model');
                    $this -> load -> model('products_tags_model');

                    $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                    $product = $this -> products_model -> Products_get_by_id($prdid);
                    $data['product'] = $product -> row_array();

                    if(count($data['product']) <= 0) show_404();
                    $images = $this -> images_product_model -> Prd_image_get_all($prdid);
                    $data['images'] = $images -> result_array();

                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                    $data['hightlightproducts'] = $this -> products_model -> Products_get_all_for_select_box();
                    $data['tags'] = $this -> products_tags_model -> Tags_get_all_for_select_box();
                    $data['brand_list'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                    $data['res_list'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                    $data['channel_list'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();

                    // thuc hien khi form edit product duoc submit len server
                    if(!$this -> isAjax()){

                        $this -> form_validation -> set_rules('prdTitle','Tên Sản Phẩm','trim|required');

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
                    }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

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

        private function clone_product($prdid = false) {

            global $PermissEdit;

            $roleid = $this -> session -> userdata('roleid');

            $flag = $this -> hasPermission('Product',$roleid,$PermissEdit);

            if($flag) {

                if($prdid !== false) {
                    $this -> load -> model('categories_product_model');
                    $this -> load -> model('sorting_brand_model');
                    $this -> load -> model('sorting_res_model');
                    $this -> load -> model('sorting_channel_model');
                    $this -> load -> model('products_model');
                    $this -> load -> model('images_product_model');
                    $this -> load -> model('products_tags_model');


                    $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                    $product = $this -> products_model -> Products_get_by_id($prdid);
                    $data['product'] = $product -> row_array();

                    if(count($data['product']) <= 0) show_404();
                    $images = $this -> images_product_model -> Prd_image_get_all($prdid);
                    $data['images'] = $images -> result_array();

                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                    $data['hightlightproducts'] = $this -> products_model -> Products_get_all_for_select_box();
                    $data['tags'] = $this -> products_tags_model -> Tags_get_all_for_select_box();
                    $data['brand_list'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                    $data['res_list'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                    $data['channel_list'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
                    // thuc hien khi form edit product duoc submit len server
                    if(!$this -> isAjax()){

                        $this -> form_validation -> set_rules('prdTitle','Tên Sản Phẩm','trim|required');

                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('products_clone_view');
                            $this -> load -> view('includes/footer');

                        }else {

                            if($this -> products_model -> Products_insert()) {
                                redirect(base_url()."administrator/products");
                            }else {
                                echo "fail";
                            }

                        }
                    }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

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

        private function fast_product() {
            global $PermissAddNew;

            $roleid = $this -> session -> userdata('roleid');

            $flag = $this -> hasPermission('Product',$roleid,$PermissAddNew);

            if($flag) {
                $this -> load -> model('products_model');
                $this -> load -> model('categories_product_model');
                $this -> load -> model('sorting_brand_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $data['categories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                $data['brand_list'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                if(!$this -> isAjax()) {

                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('products_fast_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> products_model -> Products_fast_insert()) {
                            redirect(base_url()."administrator/products");
                        }else {
                            echo "fail";
                        }

                    }
                }else {
                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('products_fast_view');
                    $this -> load -> view('includes/footer');
                }
            }else {
                echo "Do not have permissions";
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
                $isu = $this->input->get('isu');
                $stt = $this->input->get('stt');
                $pay = $this->input->get('pay');

                if($key) {
                    $whereClause1 = "(customers.FullName like '%".$key."%' AND orders.IsUser = 0)";
                    $whereClause2 = "(user_info.user_fullname like '%".$key."%' AND orders.IsUser = 1)";
                } else {
                    $whereClause1 = "(customers.FullName like '%%') AND orders.IsUser = 0";
                    $whereClause2 = "(user_info.user_fullname like '%%') AND orders.IsUser = 1";
                }
                // if($isu && $isu != '' && is_numeric($isu)) {
                //     if($isu == 2) $isu = 0;
                //     $whereClause1 .= " and orders.IsUser =".$isu;
                //     $whereClause2 .= " and orders.IsUser =".$isu;
                // }
                if($stt && $stt != '' && is_numeric($stt)) {
                    $whereClause1 .= " and orders.OrderStatusID =".$stt;
                    $whereClause2 .= " and orders.OrderStatusID =".$stt;
                }
                if($pay && $pay != '' && is_numeric($pay)) {
                    $whereClause1 .= " and orders.PaymentsID =".$pay;
                    $whereClause2 .= " and orders.PaymentsID =".$pay;
                }
                
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $orders_list = $this -> orders_model -> Get_all_orders($start,$show,$whereClause1,$whereClause2);
                    $data['orders_list'] = $orders_list;
                }

                if(count($data['orders_list']) > 0)
                $count = count($data['orders_list']);
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
        **           + newsid => la id cua news truyen vao de lay ra hoac cap nhat thong tin cua news
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function news($action = false, $newsid = false,$trashaction = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_news($newsid);
                        break;
                    }
                    case 'add' : {
                        $this -> add_news();
                        break;
                    }
                    case 'clone' : {
                        $this -> clone_news($newsid);
                        break;
                    }
                    case 'trash' : {
                        if($trashaction !== false) {
                            switch($trashaction) {
                                case 'restore' : {

                                    break;
                                }
                                case 'remove' : {

                                    break;
                                }
                                default : {
                                    show_404();
                                    break;
                                }
                            }
                        }else {
                            $this -> trash_news();
                        }
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

            $showhomepage = $this->input->get('showhomepage');
            $key = $this->input->get('key');
            $cate = $this->input->get('cate');

            $whereClause = ' 0 = 0 ';

            $whereClause .= $showhomepage ? ' and news.Is5Hotest = 1 ' : '';

            if($key) {
                $whereClause .= " and news.Title like '%".$key."%'";
            }
            if($cate && $cate != '') {
                $this -> load -> model('categories_news_model');
                $allChildId = $this -> categories_news_model -> getALlChildOfCateParent($cate);

                if(!empty($allChildId)) {
                    $whereClause .= " and news.CategoriesNewsID in ( ";

                    $i = 0;
                    foreach ($allChildId as $item) {
                        if($i > 0) {
                            $whereClause .= ", '".$item."' ";
                        }else {
                            $whereClause .= " '".$item."' ";
                        }
                        $i++;
                    }

                    $whereClause .= " ) ";
                }else {
                    $whereClause .= " and news.CategoriesNewsID = ".$cate." ";
                }
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
            $this -> load -> model('news_tags_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
            $data['hightlightnews'] = $this -> news_model -> News_get_all_for_select_box();
            $data['tags'] = $this -> news_tags_model -> Tags_get_all_for_select_box();
            if(!$this -> isAjax()){

                $this -> form_validation -> set_rules('newsTitle','Tiêu đề tin tức','trim|required');

                // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
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

        private function edit_news($newsid = false) {

            if($newsid !== false) {
                $this -> load -> model('news_model');
                $this -> load -> model('categories_news_model');
                $this -> load -> model('news_tags_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $news = $this -> news_model -> News_get_by_id($newsid);
                $data['news'] = $news -> row_array();

                if(count($data['news']) <= 0) show_404();


                $data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                $data['hightlightnews'] = $this -> news_model -> News_get_all_for_select_box();
                $data['tags'] = $this -> news_tags_model -> Tags_get_all_for_select_box();
                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('newsTitle','Tiêu đề tin tức','trim|required');

                    // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                    // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('news_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> news_model -> News_update($newsid)) {
                            redirect($this -> getUrl());
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {

                redirect(base_url().'administrator/news');

            }
        }

        private function clone_news($newsid = false) {
            $this -> load -> model('news_model');
            $this -> load -> model('categories_news_model');
            $this -> load -> model('news_tags_model');
            
            if($newsid !== false) {
                $this -> load -> model('categories_news_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $news = $this -> news_model -> News_get_by_id($newsid);
                $data['news'] = $news -> row_array();

                if(count($data['news']) <= 0) show_404();


                $data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                $data['hightlightnews'] = $this -> news_model -> News_get_all_for_select_box();
                $data['news_tags'] = $this -> news_tags_model -> Tags_get_all_for_select_box();
                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('newsTitle','Tiêu đề tin tức','trim|required');

                    // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                    // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('news_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> news_model -> News_insert()) {
                            redirect(base_url()."administrator/news");
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_clone_view');
                    $this -> load -> view('includes/footer');

                }
            }else {

                redirect(base_url().'administrator/news');

            }
        }

        private function trash_news() {
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

                $news_list = $this -> news_model -> News_get_all($start,$show,$whereClause,1);
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
            $this -> load -> view('trash_news_view');
            $this -> load -> view('includes/footer');
        }

        private function restore_news($newsid = false) {

        }

        private function remove_trash_news($newsid = false) {

        }

/************************************************************************************************/
/*********** ket thuc thao tac voi news  */


/*********** Ben duoi la cac method thao tac voi xetnghiem
************************************************************************************************/

        /*
        **  dieu huong cho cac thao tac voi xetnghiem
        **  @param : + action => neu co action (edit, add) thi thuc thi theo action
        **           + xetnghiemid => la id cua xetnghiem truyen vao de lay ra hoac cap nhat thong tin cua xetnghiem
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function xetnghiem($action = false, $xetnghiemId = false,$trashaction = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_xetnghiem($xetnghiemId);
                        break;
                    }
                    case 'add' : {
                        $this -> add_xetnghiem();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> default_xetnghiem();
            }
        }

        private function default_xetnghiem() {
            $this -> load -> model('xetnghiem_model');
            $currentpage = $this->input->get('page');

            $key = $this->input->get('key');
            $dicode = $this->input->get('dicode');

            $whereClause = ' 0 = 0 ';
            if($key) {
                $whereClause .= " and ho_ten like '%".$key."%'";
            }

            if($dicode) {
                $whereClause .= " and ma_xet_nghiem = '".$dicode."'";
            }

            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;
                $data['xetnghiem_list'] = $this -> xetnghiem_model -> getAll($start,$show,$whereClause);
            }

            if(!empty($data['xetnghiem_list'])) {
                $count = $this -> xetnghiem_model -> getCount($whereClause);
                $count = $count['count'];
            }
            else $count = 0;

            $data['link'] = $this -> xetnghiem_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('xetnghiem_view');
            $this -> load -> view('includes/footer');
        }

        private function add_xetnghiem() {
            $this -> load -> model('xetnghiem_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            if(!$this -> isAjax()){

                $this -> form_validation -> set_rules('ma_xet_nghiem','Mã xét nghiệm','trim|required');

                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('xetnghiem_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> xetnghiem_model -> insert()) {
                        redirect(base_url()."administrator/xetnghiem");
                    }else {
                        echo "fail";
                    }
                }
            }
        }

        private function edit_xetnghiem($id = false) {
            $this -> load -> model('xetnghiem_model');

            if($id !== false) {
                $this -> load -> model('categories_news_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $data['xetnghiem'] = $this -> xetnghiem_model -> getById($id);

                if($data['xetnghiem']) {
                    if(!$this -> isAjax()){

                        $this -> form_validation -> set_rules('ma_xet_nghiem','Mã xét nghiệm','trim|required');

                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('xetnghiem_edit_view');
                            $this -> load -> view('includes/footer');

                        }else {

                            if($this -> xetnghiem_model -> update($id)) {
                                redirect($this -> getUrl());
                            }else {
                                echo "fail";
                            }

                        }
                    }
                }else {
                    show_404();
                }
            }else {

                redirect(base_url().'administrator/xetnghiem');

            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi xetnghiem  */



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
                            $this -> load -> model('categories_news_model');

                            $ads = $this -> ads_model -> Ads_get_by_id($id);
                            $data['ads'] = $ads;

                            if($ads !== false) {
                                $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                                $data['adsgroups_list'] = $adsgroups_list -> result_array();
                                $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                                // thuc hien khi form edit product duoc submit len server
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Orders','Thứ tự của quảng cáo','trim|required|numeric|is_natural_no_zero');
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
                            }else {
                                show_404();
                            }
                        }
                        break;
                    }
                    case 'add' : {

                        $this -> load -> model('ads_model');
                        $this -> load -> model('ads_groups_model');
                        $this -> load -> model('categories_news_model');

                        $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                        $data['adsgroups_list'] = $adsgroups_list -> result_array();
                        $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Orders','Thứ tự của quảng cáo','trim|numeric|is_natural_no_zero');
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
                $this -> load -> model('categories_news_model');
                $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();

                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');
                $cate = $this->input->get('cate');
                $cate_c = $this->input->get('cate_c');

                $whereClause = " 1 = 1 ";
                if($key) {
                    $whereClause .= " and Title like '%".$key."%' ";
                }
                if($cate && $cate != '') {
                    $whereClause .= " and AdsGroupsID = ".$cate;
                }
                if($cate_c && $cate_c != '') {
                    $whereClause .= " and CateNewsId = ".$cate_c;
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $adsgroups_list = $this -> ads_groups_model -> Ads_groups_get_for_select_box();
                    $data['adsgroups_list'] = $adsgroups_list -> result_array();

                    $ads_list = $this -> ads_model -> Ads_get_all($start,$show,$whereClause);
                    $data['ads_list'] = $ads_list;
                }

                if(!empty($data['ads_list']))
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


/*********** Ben duoi la cac method thao tac voi Plugin
************************************************************************************************/

        public function plugins($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {

                        if($id !== false) {
                            $this -> load -> model('plugins_model');

                            $plugins = $this -> plugins_model -> getById($id);

                            if($plugins !== false) {
                                $data['plugins'] = $plugins;
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                                    $this -> form_validation -> set_rules('Code','Mã nhúng','trim|required');
                                    $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric|is_natural_no_zero');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('plugins_edit_view');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> plugins_model -> update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }
                            }else {
                                show_404();
                            }
                        }
                        break;
                    }
                    case 'add' : {

                        $this -> load -> model('plugins_model');

                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                            $this -> form_validation -> set_rules('Code','Mã nhúng','trim|required');
                            $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('plugins_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> plugins_model -> insert()) {
                                    redirect(base_url().'administrator/plugins');
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
                $this -> load -> model('plugins_model');

                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $plugins_list = $this -> plugins_model -> getAll($start,$show);
                    $data['plugins_list'] = $plugins_list;
                }

                if(!empty($data['plugins_list']))
                    $count = $data['plugins_list'][0]['count'];
                else $count = 0;

                $data['link'] = $this -> plugins_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                $this -> load -> view('includes/header',$data);
                $this -> load -> view('plugins_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi Plugin  */


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
                            }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

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
                        }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

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
                $show = 100;
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

/*********** Ben duoi la cac method thao tac voi Menu hot
************************************************************************************************/
        public function menuhot($action = false, $menuid = false) {

            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($menuid !== false) {
                            $this -> load -> model('categories_news_model');
                            $this -> load -> model('menu_hot_model');

                            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                            $menu = $this -> menu_hot_model -> Menu_get_by_id($menuid);
                            $data['menu'] = $menu -> row_array();

                            if(count($data['menu']) <= 0) show_404();
                            else $data['menu']['StaticContentJs'] = $this -> objecthelper -> convert_html_to_text_for_js($data['menu']['StaticContent']);


                            //$data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box() -> result_array();
                            $data['parentmenu_list'] = $this -> menu_hot_model -> Menu_get_except_by_id($menuid);

                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề menu','trim|required');

                                // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                                // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('menu_hot_edit_view');
                                    $this -> load -> view('includes/footer');
                                    //echo $data['menu']['StaticContentJs'];

                                }else {

                                    if($this -> menu_hot_model -> Menu_update($menuid)) {
                                        redirect($this -> getUrl());
                                    }else {
                                        echo "fail";
                                    }

                                }
                            }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('menu_hot_edit_view');
                                $this -> load -> view('includes/footer');

                            }
                        }else {

                            redirect(base_url().'administrator/menuhot');

                        }

                        break;
                    }
                    case 'add' : {
                        $this -> load -> model('categories_news_model');
                        $this -> load -> model('menu_hot_model');

                        $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                        $data['parentmenu_list'] = $this -> menu_hot_model -> Menu_get_all_to_select();

                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề menu','trim|required');

                            // $this -> form_validation -> set_rules('newsDescription','Mô tả ngắn','trim|required');
                            // $this -> form_validation -> set_rules('newsBody','Nội dung chính','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('menu_hot_add_view');
                                $this -> load -> view('includes/footer');
                                //echo $data['menu']['StaticContentJs'];

                            } else {

                                if($this -> menu_hot_model -> Menu_insert()) {
                                    redirect(base_url()."administrator/menuhot");
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('menu_hot_add_view');
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
                $this -> load -> model('menu_hot_model');
                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 100;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $data['menu_list'] = $this -> menu_hot_model -> Menu_get_all($start,$show);
                }

                if(count($data['menu_list']) > 0)
                $count = $data['menu_list'][0]['count'];
                else $count = 0;

                // if($currentpage > ceil($count/$show)) {
                //     show_404();
                // }

                $data['link'] = $this -> menu_hot_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('menu_hot_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi Menu hot  */



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

/*********** Ben duoi la cac method thao tac voi quan ly footers
************************************************************************************************/

        public function footers($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if($id !== false) {
                            $this -> load -> model('Footer_model');

                            $footer = $this -> Footer_model -> Footer_get_by_id($id);
                            $data['footer'] = $footer -> row_array();
                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('Title','Tiêu đề của footer','trim|required');
                                $this -> form_validation -> set_rules('Orders','Thứ tự của footer','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('footer_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> Footer_model -> Footer_update($id)) {
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

                        $this -> load -> model('Footer_model');

                        // thuc hien khi form edit product duoc submit len server
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề của footer','trim|required');
                            $this -> form_validation -> set_rules('Orders','Thứ tự của footer','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_rules('Body','Mô tả của footer','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('footer_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> Footer_model -> Footer_insert()) {
                                    redirect(base_url().'administrator/footers');
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

                $this -> load -> model('Footer_model');

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

                    $footers_list = $this -> Footer_model -> Footer_get_all($start,$show,$whereClause);
                    $data['footers_list'] = $footers_list -> result_array();
                }

                if(count($data['footers_list']) > 0)
                $count = $data['footers_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> Footer_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('footer_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly banners  */


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
                        case 'clone' : {
                            $this -> clone_product_category($cateid);
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

            } else if($module !== false && $module == "news") {
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
                        case 'clone' : {
                            $this -> clone_news_categories($cateid);
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
            } else if($module !== false && $module == "ads"){
                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            if($cateid !== false) {
                                if(!$this -> isAjax()) {
                                    $this -> load -> model('ads_groups_model');
                                    $this -> load -> model('categories_product_model');

                                    $adsgroups = $this -> ads_groups_model -> Ads_groups_get_by_id($cateid);
                                    $data['adsgroups'] = $adsgroups -> row_array();
                                    $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();

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
                                $this -> load -> model('categories_product_model');

                                $data['categories_list'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                                
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
            $show = 180;
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
            $this -> load -> model('sorting_brand_model');
            $this -> load -> model('sorting_price_model');
            $this -> load -> model('sorting_res_model');
            $this -> load -> model('sorting_channel_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
            $data['sortingbrand'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
            $data['sortingprice'] = $this -> sorting_price_model -> Category_get_all_for_select_box();
            $data['sortingres'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
            $data['sortingchannel'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
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
                $this -> load -> model('sorting_brand_model');
                $this -> load -> model('sorting_price_model');
                $this -> load -> model('sorting_res_model');
                $this -> load -> model('sorting_channel_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> categories_product_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> categories_product_model -> Category_get_except_by_id($cateid);
                $data['sortingbrand'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                $data['sortingprice'] = $this -> sorting_price_model -> Category_get_all_for_select_box();
                $data['sortingres'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                $data['sortingchannel'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
                $data['keywordslist'] = explode(",", $data['category']['Keywords']);
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

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('product_categories_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

        private function clone_product_category($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('categories_product_model');
                $this -> load -> model('sorting_brand_model');
                $this -> load -> model('sorting_price_model');
                $this -> load -> model('sorting_res_model');
                $this -> load -> model('sorting_channel_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> categories_product_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> categories_product_model -> Category_get_all_for_select_box();
                $data['sortingbrand'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                $data['sortingprice'] = $this -> sorting_price_model -> Category_get_all_for_select_box();
                $data['sortingres'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                $data['sortingchannel'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
                $data['keywordslist'] = explode(",", $data['category']['Keywords']);
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('product_categories_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> categories_product_model -> Category_insert()) {
                            redirect(base_url()."administrator/categories/product");
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

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
            $show = 10;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> categories_news_model -> Categoriesnews_get_all($start,(int)($start + $show ));
            }

            if(!empty($data['category_list']))
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
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_categories_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

        public function clone_news_categories($cateid) {
            if($cateid !== false ) {
                $this -> load -> model('categories_news_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> categories_news_model -> Categoriesnews_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                if(count($data['category']) <= 0) show_404();

                // thuc hien khi form edit product duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('news_categories_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> categories_news_model -> Categoriesnews_insert()) {
                            redirect(base_url()."administrator/categories/news");
                        }else {
                            echo "fail";
                        }
                        //echo "kajshdjhasdkj";

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua product ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('news_categories_clone_view');
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

/*********** Ben duoi la cac method thao tac voi categories
************************************************************************************************/


        /*
        **  dieu huong cho cac thao tac voi categories
        **  @param : + module => la ten cua module can truy cap toi (prduct, news, .....)
        **           + action => neu co action (edit, add) thi thuc thi theo action
        **           + cateid => la id cua categories truyen vao de lay ra hoac cap nhat thong tin cua categories
        **           + submit => dung de xac dinh xem form edit hoac update da duoc submit len hay chua
        */
        public function sorting($module = false,$action = false, $cateid = false,$submit = false) {
            if($module !== false && $module == "price") {
                if($action !== false) {
                    switch($action) {
                        case 'add' : {
                            $this -> add_sorting_price();
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_sorting_price();
                }

            } else if($module !== false && $module == "brand") {
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            $this -> edit_sorting_brand($cateid);
                            break;
                        }
                        case 'add' : {
                            $this -> add_sorting_brand();
                            break;
                        }
                        case 'clone' : {
                            $this -> clone_sorting_brand($cateid);
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_sorting_brand();
                }

            } else if($module !== false && $module == "res") {
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            $this -> edit_sorting_res($cateid);
                            break;
                        }
                        case 'add' : {
                            $this -> add_sorting_res();
                            break;
                        }
                        case 'clone' : {
                            $this -> clone_sorting_res($cateid);
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_sorting_res();
                }
            } else if($module !== false && $module == "channel") {
                if($action !== false) {
                    switch($action) {
                        case 'edit' : {
                            $this -> edit_sorting_channel($cateid);
                            break;
                        }
                        case 'add' : {
                            $this -> add_sorting_channel();
                            break;
                        }
                        case 'clone' : {
                            $this -> clone_sorting_channel($cateid);
                            break;
                        }
                        default: {
                            show_404();
                            break;
                        }
                    }
                }else {
                    $this -> default_sorting_channel();
                }
            } else {
                show_404();
            }
        }

    /***************** Price Sorting method
    *******************************************************************************/

        public function default_sorting_price() {
            $this -> load -> model('sorting_price_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 10;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> sorting_price_model -> SortingPrice_get_all($start,(int)($start + $show ));
            }

            if(!empty($data['category_list']))
                $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> sorting_price_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('sorting_price_view');
            $this -> load -> view('includes/footer');
        }

        public function add_sorting_price() {
            $this -> load -> model('sorting_price_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('catePriceFrom','Giá từ','trim|required|numberic');
                $this -> form_validation -> set_rules('catePriceTo','Giá đến','trim|required|numberic');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {
                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_price_add_view');
                    $this -> load -> view('includes/footer');

                }else {
                    if($this -> sorting_price_model -> SortingPrice_insert()) {
                        redirect(base_url()."administrator/sorting/price");
                    }else {
                        echo "fail";
                    }
                    //echo "jahskjdha";
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('sorting_price_add_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************
*********** ket thuc thao tac voi sorting
*******************************************************************************/

/***************** Brand sorting method
    *******************************************************************************/
        private function default_sorting_brand() {
            $this -> load -> model('sorting_brand_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 30;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> sorting_brand_model -> Category_get_all($start,$show);
            }

            if(count($data['category_list']) > 0)
            $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> sorting_brand_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('sorting_brand_view');
            $this -> load -> view('includes/footer');
        }

        private function add_sorting_brand() {

            $this -> load -> model('sorting_brand_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_brand_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> sorting_brand_model -> Category_insert()) {
                        redirect(base_url()."administrator/sorting/brand");
                    }else {
                        echo "fail";
                    }
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('sorting_brand_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        private function edit_sorting_brand($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_brand_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_brand_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_brand_model -> Category_get_except_by_id($cateid);
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit brand duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_brand_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_brand_model -> Category_update($cateid)) {
                            redirect($this -> getUrl());

                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua brand ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_brand_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

        private function clone_sorting_brand($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_brand_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_brand_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_brand_model -> Category_get_all_for_select_box();
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit brand duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_brand_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_brand_model -> Category_insert()) {
                            redirect(base_url()."administrator/sorting/brand");
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua brand ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_brand_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

    /*******************************************************************************
    ***************** End Brand sorting method
    *******************************************************************************/

/***************** Res sorting method
    *******************************************************************************/
        private function default_sorting_res() {
            $this -> load -> model('sorting_res_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 30;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> sorting_res_model -> Category_get_all($start,$show);
            }

            if(count($data['category_list']) > 0)
            $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> sorting_res_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('sorting_res_view');
            $this -> load -> view('includes/footer');
        }

        private function add_sorting_res() {

            $this -> load -> model('sorting_res_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_res_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> sorting_res_model -> Category_insert()) {
                        redirect(base_url()."administrator/sorting/res");
                    }else {
                        echo "fail";
                    }
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('sorting_res_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        private function edit_sorting_res($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_res_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_res_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_res_model -> Category_get_except_by_id($cateid);
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit res duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_res_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_res_model -> Category_update($cateid)) {
                            redirect($this -> getUrl());

                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua res ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_res_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

        private function clone_sorting_res($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_res_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_res_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_res_model -> Category_get_all_for_select_box();
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit res duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_res_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_res_model -> Category_insert()) {
                            redirect(base_url()."administrator/sorting/res");
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua res ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_res_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

    /*******************************************************************************
    ***************** End Res sorting method
    *******************************************************************************/

/***************** Channel sorting method
    *******************************************************************************/
        private function default_sorting_channel() {
            $this -> load -> model('sorting_channel_model');
            $currentpage = $this->input->get('page');
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 30;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['category_list'] = $this -> sorting_channel_model -> Category_get_all($start,$show);
            }

            if(count($data['category_list']) > 0)
            $count = $data['category_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> sorting_channel_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('sorting_channel_view');
            $this -> load -> view('includes/footer');
        }

        private function add_sorting_channel() {

            $this -> load -> model('sorting_channel_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $data['categories'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_channel_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> sorting_channel_model -> Category_insert()) {
                        redirect(base_url()."administrator/sorting/channel");
                    }else {
                        echo "fail";
                    }
                }
            }else {
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('sorting_channel_add_view');
                $this -> load -> view('includes/footer');
            }
        }

        private function edit_sorting_channel($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_channel_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_channel_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_channel_model -> Category_get_except_by_id($cateid);
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit channel duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_channel_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_channel_model -> Category_update($cateid)) {
                            redirect($this -> getUrl());

                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua channel ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_channel_edit_view');
                    $this -> load -> view('includes/footer');

                }
            }else {
                show_404();
            }
        }

        private function clone_sorting_channel($cateid = false) {
            if($cateid !== false ) {
                $this -> load -> model('sorting_channel_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $category = $this -> sorting_channel_model -> Category_get_by_id($cateid);
                $data['category'] = $category -> row_array();
                $data['parentcategories'] = $this -> sorting_channel_model -> Category_get_all_for_select_box();
                if(count($data['category']) <= 0) show_404();


                // thuc hien khi form edit channel duoc submit len server
                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('cateTitle','Tên danh mục','trim|required');

                    $this -> form_validation -> set_rules('cateOrders','Thứ tự hiển thị','trim|numeric');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('sorting_channel_clone_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> sorting_channel_model -> Category_insert()) {
                            redirect(base_url()."administrator/sorting/channel");
                        }else {
                            echo "fail";
                        }

                    }
                }else {// truong hop nguoc lai, thi hien thi cac thong tin cua channel ra.

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('sorting_channel_edit_view');
                    $this -> load -> view('includes/footer');
                }
            }else {
                show_404();
            }
        }

    /*******************************************************************************
    ***************** End Channel sorting method
    *******************************************************************************/

/*******************************************************/
/******************* CAC ME THOD THAO TAC VOI CONTAC ******************/
        public function contact($module = false,$action = false, $newid = false,$submit = false) {
            if($module !== false) {
                switch($module) {
                    case 'customers' : {
                        if($action !== false) {
                            switch($action) {
                                case 'edit' : {
                                    $this -> edit_contact($newid);
                                    break;
                                }
                                default: {
                                    show_404();
                                    break;
                                }
                            }
                        }else {
                            $this -> default_contact();
                        }

                        break;
                    }
                    case 'text': {
                        $this -> load -> model("contact_model");
                        if($action !== false) {
                            if($action == "save"){
                               if($this -> contact_model -> contact_text_update()){
                                    redirect(base_url()."administrator/contact/text");
                               }
                            }
                        }else {
                            $data['footer'] = $this -> contact_model -> contact_text_get();
                            if(empty($data['footer'])) {
                                $data['footer'] = "";
                            }
                            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('contact_text_view');
                            $this -> load -> view('includes/footer');
                        }
                        break;
                    }
                    case 'text-text':{

                        $this -> load -> model('contact_text_model');

                        $data['tabs'] = $this -> contact_text_model -> getAllTabs();
                        $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('contact_text_edit_view');
                        $this -> load -> view('includes/footer');

                        break;
                    }
                    default : {
                        show_404();
                        break;
                    }
                }
            }
            else {
                show_404();
            }

        }

        public function privatedb() {
            $selectClause = " select * from admin ";
            $result = $this -> db -> query($selectClause);
            $result -> result_array();
            var_dump($result);
        }

        private function default_contact() {
            $this -> load -> model('contact_model');
            $currentpage = $this->input->get('page');

            $whereClause = ' 0 = 0 ';
            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $contact_list = $this -> contact_model -> contact_get_all($start,$show,$whereClause);
                $data['contact_list'] = $contact_list;
            }

            if(count($data['contact_list']) > 0)
            $count = $data['contact_list'][0]['count'];
            else $count = 0;

            // if($currentpage > ceil($count/$show)) {
            //     show_404();
            // }

            $data['link'] = $this -> contact_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('contact_view');
            $this -> load -> view('includes/footer');
        }

        private function edit_contact($newid = false) {
            $this -> load -> model('contact_model');
            if($newid !== false) {

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $contact = $this -> contact_model -> contact_get_id($newid);
                $data['contact'] = $contact;

                if(empty($data['contact'])) show_404();

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('contact_edit_view');
                $this -> load -> view('includes/footer');

            }else {

                redirect(base_url().'administrator/contact');

            }
        }

/********************************************************************************/
/*************************** KET THUC CAC METHOD THAO TAC VOI CONTACT ****************************/

/*********** Ben duoi la cac method thao tac voi tag news
************************************************************************************************/

        public function newstags($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {

                        if($id !== false) {
                            $this -> load -> model('news_tags_model');

                            $tags = $this -> news_tags_model -> Tags_get_by_id($id);
                            $data['tags'] = $tags -> row_array();

                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('tagsTitle','Tiêu đề của Tags','trim|required');
                                $this -> form_validation -> set_rules('tagsOrders','Thứ tự của tags','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('news_tags_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> news_tags_model -> Tags_update($id)) {
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

                        $this -> load -> model('news_tags_model');

                        // thuc hien khi form add tags duoc submit len server
                        if(!$this -> isAjax()){
                            
                            $this -> form_validation -> set_rules('tagsTitle','Tiêu đề của quảng cáo','trim|required');
                            $this -> form_validation -> set_rules('tagsOrders','Thứ tự của quảng cáo','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {
                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('news_tags_add_view');
                                $this -> load -> view('includes/footer');

                            }else {
                                
                                $s = $this -> news_tags_model -> Tags_insert();

                                if($s == 1) {
                                    redirect(base_url().'administrator/newstags');
                                } else if($s == 3) {
                                    echo "<script>";
                                    echo "alert('Tags này đã tồn tại. Vui lòng nhập tag khác');";
                                    echo "</script>";
                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('news_tags_add_view');
                                    $this -> load -> view('includes/footer');
                                    
                                } else {
                                    echo "failure";
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
                $this -> load -> model('news_tags_model');

                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');
                $cate = $this->input->get('cate');

                $whereClause = " 1 = 1 ";
                if($key) {
                    $whereClause .= " and Title like '%".$key."%' ";
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $tags_list = $this -> news_tags_model -> Tags_get_all($start,$show,$whereClause);
                    $data['tags_list'] = $tags_list -> result_array();
                }

                if(count($data['tags_list']) > 0)
                $count = $data['tags_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> news_tags_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                $this -> load -> view('includes/header',$data);
                $this -> load -> view('news_tags_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly tag news  */

/*********** Ben duoi la cac method thao tac voi tag product
************************************************************************************************/

        public function productstags($action = false,$id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            if($action !== false) {
                switch($action) {
                    case 'edit' : {

                        if($id !== false) {
                            $this -> load -> model('products_tags_model');

                            $tags = $this -> products_tags_model -> Tags_get_by_id($id);
                            $data['tags'] = $tags -> row_array();

                            // thuc hien khi form edit product duoc submit len server
                            if(!$this -> isAjax()){

                                $this -> form_validation -> set_rules('tagsTitle','Tiêu đề của Tags','trim|required');
                                $this -> form_validation -> set_rules('tagsOrders','Thứ tự của tags','trim|numeric|is_natural_no_zero');
                                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                if(!$this -> form_validation -> run()) {

                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('products_tags_edit_view');
                                    $this -> load -> view('includes/footer');

                                }else {

                                    if($this -> products_tags_model -> Tags_update($id)) {
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

                        $this -> load -> model('products_tags_model');

                        // thuc hien khi form add tags duoc submit len server
                        if(!$this -> isAjax()){
                            
                            $this -> form_validation -> set_rules('tagsTitle','Tiêu đề của quảng cáo','trim|required');
                            $this -> form_validation -> set_rules('tagsOrders','Thứ tự của quảng cáo','trim|numeric|is_natural_no_zero');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {
                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('products_tags_add_view');
                                $this -> load -> view('includes/footer');

                            }else {
                                
                                $s = $this -> products_tags_model -> Tags_insert();

                                if($s == 1) {
                                    redirect(base_url().'administrator/productstags');
                                } else if($s == 3) {
                                    echo "<script>";
                                    echo "alert('Tag này đã tồn tại. Vui lòng nhập tag khác');";
                                    echo "</script>";
                                    $this -> load -> view('includes/header',$data);
                                    $this -> load -> view('products_tags_add_view');
                                    $this -> load -> view('includes/footer');
                                    
                                } else {
                                    echo "failure";
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
                $this -> load -> model('products_tags_model');

                $currentpage = $this->input->get('page');
                $key = $this->input->get('key');
                $cate = $this->input->get('cate');

                $whereClause = " 1 = 1 ";
                if($key) {
                    $whereClause .= " and Title like '%".$key."%' ";
                }

                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $tags_list = $this -> products_tags_model -> Tags_get_all($start,$show,$whereClause);
                    $data['tags_list'] = $tags_list -> result_array();
                }

                if(count($data['tags_list']) > 0)
                $count = $data['tags_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> products_tags_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());


                $this -> load -> view('includes/header',$data);
                $this -> load -> view('products_tags_view');
                $this -> load -> view('includes/footer');
            }
        }

/************************************************************************************************/
/*********** ket thuc thao tac voi quan ly tag product  */

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

        public function autoget($action = false, $id = false) {
            $this -> load -> model('crawler_parttern_model');
            $this -> load -> model('categories_news_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            $data['categoriesnews_list'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();

            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tên parttern','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            $data['laytin'] = $this -> crawler_parttern_model -> getById($id);

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('laytin_view');
                                $this -> load -> view('includes/footer');
                            }else {
                                if($this -> crawler_parttern_model -> update($id)) {
                                    redirect($this -> getUrl());
                                }else {
                                    echo "fail";
                                }
                            }
                        }
                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tên parttern','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('laytin_parttern_add_view');
                                $this -> load -> view('includes/footer');
                            }else {
                                if($this -> crawler_parttern_model -> insert()) {
                                    redirect(base_url().'administrator/autoget');
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
                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 10;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $data['laytin_parttern_list'] = $this -> crawler_parttern_model -> getAll($start,(int)($start + $show ));
                }

                if(!empty($data['laytin_parttern_list']))
                    $count = $data['laytin_parttern_list'][0]['count'];
                else $count = 0;

                $data['link'] = $this -> crawler_parttern_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('laytin_parttern_view');
                $this -> load -> view('includes/footer');
            }
        }

        public function eventsline($action = false, $id = false) {
            $this -> load -> model('events_line_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Event_name','Tên dòng sự kiện','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            $data['eventsline'] = $this -> events_line_model -> getById($id);

                            if(!$this -> form_validation -> run()) {
                                $this -> load -> model('categories_news_model');
                                $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();
                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('events_line_edit_view');
                                $this -> load -> view('includes/footer');
                            }else {
                                if($this -> events_line_model -> update($id)) {
                                    redirect($this -> getUrl());
                                }else {
                                    echo "fail";
                                }
                            }
                        }
                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){
                            $this -> form_validation -> set_rules('Event_name','Tên dòng sự kiện','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {
                                $this -> load -> model('categories_news_model');
                                $data['categoriesnews'] = $this -> categories_news_model -> Categoriesnews_get_all_for_select_box();

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('events_line_add_view');
                                $this -> load -> view('includes/footer');
                            }else {
                                if($this -> events_line_model -> insert()) {
                                    redirect(base_url().'administrator/eventsline');
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
                $currentpage = $this->input->get('page');
                if($currentpage == '') $currentpage = 1;
                $start;
                $show = 10;

                $start = ($currentpage-1)*$show;
                $data['events_line_list'] = $this -> events_line_model -> getAll($start,(int)($start + $show ));

                if(!empty($data['events_line_list']))
                    $count = $data['events_line_list'][0]['count'];
                else $count = 0;

                $data['link'] = $this -> events_line_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('events_line_view');
                $this -> load -> view('includes/footer');
            }
        }

/********************** END CONFIGS
*********************************************************************************************/



/********************** PARTNERS
*********************************************************************************************/


        public function partners($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('partners_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['partner'] = $this -> partners_model -> getById($id);

                            if($data['partner']) {
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {


                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('partner_edit_view.php');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> partners_model -> update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/partners');
                                }
                            }else {
                                show_404();
                            }
                        }

                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {


                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('partner_add_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> partners_model -> insert()) {
                                    redirect(base_url().'administrator/partners');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/partners');
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

                    $data['partnerList'] = $this -> partners_model -> getAll($start,$show);
                }
                if(!empty($data['partnerList'])) {
                    $count = $this -> partners_model -> getCountForAll();
                    $count = $count['count'];
                }
                else $count = 0;

                $data['link'] = $this -> partners_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('partner_view');
                $this -> load -> view('includes/footer');
            }
        }


/********************** END PARTNERS
*********************************************************************************************/


/********************** ONEPAGES
*********************************************************************************************/


         public function onepages($module = false) {
            if($module !== false) {
                switch($module) {
                    case 'payment-transfer': {
                        $this -> load -> model('onepages_model');

                        $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                        $data['news'] = $this -> onepages_model -> onePages('get',1);
                        $data['header_title'] = "Thanh toán và vận chuyển";

                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                            $this -> form_validation -> set_rules('Title_en','Tiêu đề','trim|required');

                            // $this -> form_validation -> set_rules('Description','Mô tả ngắn','trim|required');
                            // $this -> form_validation -> set_rules('Description_en','Mô tả ngắn','trim|required');
                            $this -> form_validation -> set_rules('Body','Nội dung chính','trim|required');
                            $this -> form_validation -> set_rules('Body_en','Nội dung chính','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('onepages_view');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> onepages_model -> onePages('update',1)) {
                                    redirect($this -> getUrl(),'refresh');
                                }else {
                                    echo "fail";
                                }
                            }
                        }
                        break;
                    }
                    default:{
                        show_404();
                        break;
                    }
                }
            }
        }


/********************** END ONEPAGES
*********************************************************************************************/


/********************** CALL BACK
*********************************************************************************************/

        public function callback($action = false, $id = false){
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('callus_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['callus'] = $this -> callus_model -> getById($id);

                            if($data['callus']) {
                                if(!$this -> isAjax()){
                                    if(!$this -> form_validation -> run()) {


                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('callus_edit_view.php');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> callus_model -> update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/callback');
                                }
                            }else {
                                show_404();
                            }
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

                    $data['callus_list'] = $this -> callus_model -> getAll($start,$show);
                }
                if(!empty($data['callus_list'])) {
                    $count = $this -> callus_model -> getCountOfAll();
                }
                else $count = 0;

                $data['link'] = $this -> callus_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('callus_view');
                $this -> load -> view('includes/footer');
            }
        }


/********************** END CALL BACK
*********************************************************************************************/


/********************** POLLS
*********************************************************************************************/


        public function polls($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('polls_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['answersList'] = array();
                            $data['poll'] = $this -> polls_model -> getPollById($id);
                            if($data['poll'] !== false) {
                                $data['answersList'] = $data['poll']['answersList'];
                                $data['summeryChart'] = $this -> polls_model -> poll(false,$id);
                            }

                            if($data['poll']) {
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                                    $this -> form_validation -> set_rules('Title_en','Tiêu đề tiếng Anh','trim|required');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('polls_edit_view.php');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> polls_model -> updatePoll($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/polls');
                                }
                            }else {
                                show_404();
                            }
                        }

                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                            $this -> form_validation -> set_rules('Title_en','Tiêu đề tiếng Anh','trim|required');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('polls_add_view.php');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> polls_model -> insertPoll($id)) {
                                    redirect(base_url().'administrator/polls');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/polls');
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

                    $data['polls_list'] = $this -> polls_model -> getAllPolls($start,$show);
                }
                if(!empty($data['polls_list'])) {
                    $count = $this -> polls_model -> getCountOfPolls();
                }
                else $count = 0;

                $data['link'] = $this -> polls_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('polls_view');
                $this -> load -> view('includes/footer');
            }
        }


/********************** END POLLS
*********************************************************************************************/



/********************** FAQs
*********************************************************************************************/

        public function faqs($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('faqs_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['faq'] = $this -> faqs_model -> getById($id);

                            if($data['faq'] !== false) {
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Question','Câu hỏi','trim|required');
                                    $this -> form_validation -> set_rules('Question_en','Câu hỏi tiếng Anh','trim|required');

                                    $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('faqs_edit_view.php');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> faqs_model -> update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/faqs');
                                }
                            }else {
                                show_404();
                            }
                        }

                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Question','Câu hỏi','trim|required');
                            $this -> form_validation -> set_rules('Question_en','Câu hỏi tiếng Anh','trim|required');
                            $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('faqs_add_view.php');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> faqs_model -> insert($id)) {
                                    redirect(base_url().'administrator/faqs');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/faqs');
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

                $count = 0;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $data['faqs_list'] = array();
                    $receivedData = $this -> faqs_model -> getAll($start,$show);
                    if(!empty($receivedData)) {
                        $data['faqs_list'] = $receivedData['faqs_list'];
                        $count = $receivedData['count'];
                    }
                }

                $data['link'] = $this -> faqs_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());
                $this -> load -> view('includes/header',$data);
                $this -> load -> view('faqs_view');
                $this -> load -> view('includes/footer');
            }
        }



/********************** END FAQs
*********************************************************************************************/

/********************** TESTOMINAL
*********************************************************************************************/
        public function testimonials($action = false, $id = false) {
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            $this -> load -> model('testimonials_model');
            if($action !== false) {
                switch ($action) {
                    case 'edit': {
                        if($id !== false) {
                            $data['testi'] = $this -> testimonials_model -> getById($id);

                            if($data['testi'] !== false) {
                                if(!$this -> isAjax()){

                                    $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                                    if(!$this -> form_validation -> run()) {

                                        $this -> load -> view('includes/header',$data);
                                        $this -> load -> view('testimonials_edit_view.php');
                                        $this -> load -> view('includes/footer');

                                    }else {

                                        if($this -> testimonials_model -> update($id)) {
                                            redirect($this -> getUrl());
                                        }else {
                                            echo "fail";
                                        }

                                    }
                                }else {
                                    redirect(base_url().'administrator/testimonials');
                                }
                            }else {
                                show_404();
                            }
                        }

                        break;
                    }
                    case 'add' : {
                        if(!$this -> isAjax()){

                            $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                            $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                            if(!$this -> form_validation -> run()) {

                                $this -> load -> view('includes/header',$data);
                                $this -> load -> view('testimonials_add_view.php');
                                $this -> load -> view('includes/footer');

                            }else {

                                if($this -> testimonials_model -> insert($id)) {
                                    redirect(base_url().'administrator/testimonials');
                                }else {
                                    echo "fail";
                                }

                            }
                        }else {
                            redirect(base_url().'administrator/testimonials');
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
                $show = 20;
                if(isset($currentpage) && $currentpage != '') {
                    $start = ($currentpage-1)*$show;

                    $rating_list = $this -> testimonials_model -> Testimonials_get_all($start,$show);
                    $data['testimonials_list'] = $rating_list;
                }

                if(count($data['testimonials_list']) > 0)
                $count = $data['testimonials_list'][0]['count'];
                else $count = 0;

                if($currentpage > ceil($count/$show)) {
                    //show_404();
                }

                $data['link'] = $this -> testimonials_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

                $this -> load -> view('includes/header',$data);
                $this -> load -> view('testimonials_view');
                $this -> load -> view('includes/footer');
            }
        }

/********************** END TESTOMINAL
*********************************************************************************************/

/********************** SPEAKERS
*********************************************************************************************/

        public function people($action = false, $id = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_people($id);
                        break;
                    }
                    case 'add' : {
                        $this -> add_people();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> default_people();
            }
        }

        private function default_people() {
            $this -> load -> model('people_model');

            $currentpage = $this->input->get('page');
            $key = $this->input->get('key');

            $whereClause = " 1 = 1 ";
            if($key) {
                $whereClause .= " and FullName like '%".$key."%' ";
            }

            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $people_list = $this -> people_model -> Speakers_All($start,$show,$whereClause);
                $data['people_list'] = $people_list;
            }

            if(count($data['people_list']) > 0)
            $count = $data['people_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> people_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('people_view');
            $this -> load -> view('includes/footer');
        }

        private function edit_people($id) {
            if($id !== false) {
                $this -> load -> model('people_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $data['tabs'] = $this -> people_model -> getAllTabs();

                $people = $this -> people_model -> Speakers_Id($id);
                $data['people'] = $people;

                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('FullName','Họ tên','trim|required');
                    $this -> form_validation -> set_rules('FullName_en','Họ tên tiếng Anh','trim|required');
                    $this -> form_validation -> set_rules('Position','Vị trí','trim|required');
                    $this -> form_validation -> set_rules('Position_en','Vị trí tiếng Anh','trim|required');
                    $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                    $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('people_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> people_model -> Speakers_Update($id)) {
                            redirect($this -> getUrl(),'refresh');
                        }else {
                            echo "fail";
                        }

                    }
                }
            }
        }

        private function add_people() {

            $this -> load -> model('people_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('FullName','Họ tên','trim|required');
                $this -> form_validation -> set_rules('FullName_en','Họ tên tiếng Anh','trim|required');
                $this -> form_validation -> set_rules('Position','Vị trí','trim|required');
                $this -> form_validation -> set_rules('Position_en','Vị trí tiếng Anh','trim|required');
                $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $data['tabs'] = $this -> people_model -> getAllTabs();

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('people_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> people_model -> Speakers_Insert()) {
                        redirect(base_url()."administrator/people");
                    }else {
                        echo "fail";
                    }
                }
            }

        }

/********************** END SPEAKERS
*********************************************************************************************/


/********************** SPEAKERS
*********************************************************************************************/

        public function certificate($action = false, $id = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_chungchi($id);
                        break;
                    }
                    case 'add' : {
                        $this -> add_chungchi();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> default_chungchi();
            }
        }

        private function default_chungchi() {
            $this -> load -> model('chungchi_model');

            $currentpage = $this->input->get('page');
            $key = $this->input->get('key');

            $whereClause = " 1 = 1 ";
            if($key) {
                $whereClause .= " and FullName like '%".$key."%' ";
            }

            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;
            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $certificate_list = $this -> chungchi_model -> getAll($start,$show,$whereClause);
                $data['certificate_list'] = $certificate_list;
            }

            if(count($data['certificate_list']) > 0)
            $count = $data['certificate_list'][0]['count'];
            else $count = 0;

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> chungchi_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('chungchi_view');
            $this -> load -> view('includes/footer');
        }

        private function edit_chungchi($id) {
            if($id !== false) {
                $this -> load -> model('chungchi_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

                $data['tabs'] = $this -> chungchi_model -> getAllTabs();

                $certificate = $this -> chungchi_model -> getById($id);
                $data['certificate'] = $certificate;

                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('FullName','Họ tên','trim|required');
                    $this -> form_validation -> set_rules('FullName_en','Họ tên tiếng Anh','trim|required');
                    $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                    $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('chungchi_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> chungchi_model -> update($id)) {
                            redirect($this -> getUrl(),'refresh');
                        }else {
                            echo "fail";
                        }

                    }
                }
            }
        }

        private function add_chungchi() {

            $this -> load -> model('chungchi_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('FullName','Họ tên','trim|required');
                $this -> form_validation -> set_rules('FullName_en','Họ tên tiếng Anh','trim|required');
                $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $data['tabs'] = $this -> chungchi_model -> getAllTabs();

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('chungchi_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> chungchi_model -> insert()) {
                        redirect(base_url()."administrator/certificate");
                    }else {
                        echo "fail";
                    }
                }
            }

        }

/********************** END CERTIFICATE
*********************************************************************************************/




/********************** DICH VU
*********************************************************************************************/

        public function dichvu($action = false, $id = false) {
            if($action !== false) {
                switch($action) {
                    case 'edit' : {
                        $this -> edit_dichvu($id);
                        break;
                    }
                    case 'add' : {
                        $this -> add_dichvu();
                        break;
                    }
                    default: {
                        show_404();
                        break;
                    }
                }
            }else {
                $this -> default_dichvu();
            }
        }


        private function default_dichvu() {
            $this -> load -> model('dichvu_model');

            $currentpage = $this->input->get('page');
            $key = $this->input->get('key');

            $whereClause = " 1 = 1 ";
            if($key) {
                $whereClause .= " and FullName like '%".$key."%' ";
            }

            if($currentpage == '') $currentpage = 1;
            $start;
            $show = 20;

            $count = 0;

            if(isset($currentpage) && $currentpage != '') {
                $start = ($currentpage-1)*$show;

                $data['dichvu_list'] = array();
                $receivedData = $this -> dichvu_model -> getAll($start,$show);
                if(!empty($receivedData)) {
                    $data['dichvu_list'] = $receivedData['list'];
                    $count = $receivedData['count'];
                }
            }

            if($currentpage > ceil($count/$show)) {
                //show_404();
            }

            $data['link'] = $this -> dichvu_model -> genPageLink($currentpage,5,ceil($count/$show),$this->getUrl());

            $this -> load -> view('includes/header',$data);
            $this -> load -> view('dichvu_view');
            $this -> load -> view('includes/footer');
        }

        private function edit_dichvu($id) {
            if($id !== false) {
                $this -> load -> model('dichvu_model');

                $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
                $dichvu = $this -> dichvu_model -> getById($id);
                $data['dichvu'] = $dichvu;

                if(!$this -> isAjax()){

                    $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                    $this -> form_validation -> set_rules('Title_en','Tiêu đề tiếng Anh','trim|required');
                    // $this -> form_validation -> set_rules('Position','Vị trí','trim|required');
                    // $this -> form_validation -> set_rules('Position_en','Vị trí tiếng Anh','trim|required');
                    // $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                    // $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                    $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                    if(!$this -> form_validation -> run()) {

                        $this -> load -> view('includes/header',$data);
                        $this -> load -> view('dichvu_edit_view');
                        $this -> load -> view('includes/footer');

                    }else {

                        if($this -> dichvu_model -> update($id)) {
                            redirect($this -> getUrl(),'refresh');
                        }else {
                            echo "fail";
                        }

                    }
                }
            }
        }

        private function add_dichvu() {

            $this -> load -> model('dichvu_model');

            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';

            if(!$this -> isAjax()) {

                $this -> form_validation -> set_rules('Title','Tiêu đề','trim|required');
                    $this -> form_validation -> set_rules('Title_en','Tiêu đề tiếng Anh','trim|required');
                // $this -> form_validation -> set_rules('Position','Vị trí','trim|required');
                // $this -> form_validation -> set_rules('Position_en','Vị trí tiếng Anh','trim|required');
                // $this -> form_validation -> set_rules('Orders','Thứ tự','trim|numeric');
                // $this -> form_validation -> set_rules('ImageURL','Ảnh đại diện','trim|required');
                $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                if(!$this -> form_validation -> run()) {

                    $this -> load -> view('includes/header',$data);
                    $this -> load -> view('dichvu_add_view');
                    $this -> load -> view('includes/footer');

                }else {

                    if($this -> dichvu_model -> insert()) {
                        redirect(base_url()."administrator/dichvu");
                    }else {
                        echo "fail";
                    }
                }
            }

        }



/********************** END DICH VU
*********************************************************************************************/

/********************** Webinfor
*********************************************************************************************/

        public function webinfor($navigate = false) {
            $this -> load -> model('webinfor_model');
            $data['js'] = '<script>$(function() {$( "#tabs" ).tabs();});</script>';
            switch ($navigate) {
                case 'bannerfaq': {
                    if(!$this -> isAjax()) {

                        $data['title'] = "Banner trang FAQS";

                        $data['banner'] = $this -> webinfor_model -> getBanner('BannerFaq');

                        $this -> form_validation -> set_rules('ImageUrl','Ảnh banner','trim|required');
                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('banner_single_view');
                            $this -> load -> view('includes/footer');
                        }else {
                            if($this -> webinfor_model -> updateBanner('BannerFaq',$this -> input -> post('ImageUrl'))) {
                                redirect($this -> getUrl(),'refresh');
                            }else {
                                echo "fail";
                            }
                        }
                    }
                    break;
                }
                case 'bannerpeople': {

                    if(!$this -> isAjax()) {

                        $data['title'] = "Banner trang Nhân sự";

                        $data['banner'] = $this -> webinfor_model -> getBanner('BannerPeople');

                        $this -> form_validation -> set_rules('ImageUrl','Ảnh banner','trim|required');
                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('banner_single_view');
                            $this -> load -> view('includes/footer');
                        }else {
                            if($this -> webinfor_model -> updateBanner('BannerPeople',$this -> input -> post('ImageUrl'))) {
                                redirect($this -> getUrl(),'refresh');
                            }else {
                                echo "fail";
                            }
                        }
                    }
                    break;
                }
                case 'bannercertificate': {

                    if(!$this -> isAjax()) {

                        $data['title'] = "Banner trang Chưng chỉ - chứng nhận";

                        $data['banner'] = $this -> webinfor_model -> getBanner('BannerPeople');

                        $this -> form_validation -> set_rules('ImageUrl','Ảnh banner','trim|required');
                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('banner_single_view');
                            $this -> load -> view('includes/footer');
                        }else {
                            if($this -> webinfor_model -> updateBanner('BannerPeople',$this -> input -> post('ImageUrl'))) {
                                redirect($this -> getUrl(),'refresh');
                            }else {
                                echo "fail";
                            }
                        }
                    }
                    break;
                }
                case 'homeintro':{
                    if(!$this -> isAjax()) {

                        $data['title'] = "Nội dung giới thiệu ngoài trang chủ";

                        $data['gioithieu'] = $this -> webinfor_model -> getGioiThieu();

                        $this -> form_validation -> set_rules('Gioithieu','Nội dung giới thiệu','trim|required');
                        $this -> form_validation -> set_rules('Gioithieu_en','Nội dung giới thiệu tiếng Anh','trim|required');
                        $this -> form_validation -> set_rules('LinkVideoGioithieu','Link video','trim|required');
                        $this -> form_validation -> set_rules('LinkDetailGioiThieu','Link chi tiết','trim|required');

                        $this -> form_validation -> set_error_delimiters('<span class="error Required">', '</span>');

                        if(!$this -> form_validation -> run()) {

                            $this -> load -> view('includes/header',$data);
                            $this -> load -> view('gioithieu_content_view');
                            $this -> load -> view('includes/footer');
                        }else {

                            $inputData = array('Gioithieu' => $this -> input -> post('Gioithieu'),
                                                'Gioithieu_en' => $this -> input -> post('Gioithieu_en'),
                                                'LinkVideoGioithieu' => $this -> input -> post('LinkVideoGioithieu'),
                                                'LinkDetailGioiThieu' => $this -> input -> post('LinkDetailGioiThieu')
                                                );

                            if($this -> webinfor_model -> updateGioiThieu($inputData)) {
                                redirect($this -> getUrl(),'refresh');
                            }else {
                                echo "fail";
                            }
                        }
                    }
                    break;
                }
                default:{
                    show_404();
                    break;
                }
            }
        }


/********************** END WEBINFOR
*********************************************************************************************/

    }
?>