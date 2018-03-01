<?php
    class Admin_products_ajaxhandler extends CMS_AdminController {
        function __construct(){

        	parent::__construct();
          // ../modules/ajaxhandle/models/ajax_products_model
          $this -> load -> model('ajax_products_model');
        }

        function index() {
        	echo 'hello';
        }

        // function is_logged_in() {
        //   $is_logged_in = $this -> session -> userdata('is_logged_in');

        //   if(!isset($is_logged_in) || !$is_logged_in) {
        //     if ($this -> isAjax()) {

        //        echo json_encode(array('url' => '','imgname' => '',"msg" => "Error: Phiên làm việc đã kết thúc. Đăng nhập lại để thao tác!"));
        //        die();
        //     }
        //   }
        // }

        public function Main_Image_Upload() {
          $data = $this -> Upload_Single_Image();
          echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message']));
        }

        public function Multi_Image_Upload() {
          $data = $this -> Upload_Multi_Image();
          $temp = array();
          foreach ($data as $dt){
            $temp[] = array('url' => $dt['url_thumbs'],'imgname' => $dt['file_name'], 'msg' => $dt['message']);
          }
          echo json_encode($temp);
        }

        function updateSKU() {
        	$result = $this -> ajax_products_model -> Ajax_Update_Product_SKU();
        	$a = '';
        	$result !== false ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }

        function Update_Publish() {
        	$result = $this -> ajax_products_model -> Ajax_Update_Product_Publish();
        	$a = '';
        	$result ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }

        function Update_Orders() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_Orders();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }

        function Update_IsNew() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_IsNew();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }

        function Update_IsHot() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_IsHot();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }

        function Update_IsSellers() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_IsSellers();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }

        function Update_IsPromotion() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_IsPromotion();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }
        function Update_IsStock() {
          $result = $this -> ajax_products_model -> Ajax_Update_Product_IsStock();
          $a = '';
          $result ? $a = '1' : $a = '0';
          echo json_encode($a);
        }

        function updateSellPrice(){
        	$result = $this -> ajax_products_model -> Ajax_Update_Product_SellPrice();
        	$a = '';
        	$result ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }

        function updateListPrice() {
        	$result = $this -> ajax_products_model -> Ajax_Update_Product_ListPrice();
        	$a = '';
        	$result ? $a = '1' : $a = '0';
        	echo json_encode($a);
        }

        function Check_Title() {
            $result = $this -> ajax_products_model -> Ajax_Check_Title();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

        function Check_Title_Except() {
            $result = $this -> ajax_products_model -> Ajax_Check_Title_Except();
            $a = '';
            $result ? $a = '1' : $a = '0';
            echo json_encode($a);
        }

/*********** Ben duoi la cac method thao tac voi anh? cua product
************************************************************************************************/
        public function Update_Product_Image_Orders() {
          $msg = "";
          $imageid = $this -> input -> post('imageid');
          $order = $this -> input -> post('order');

          if($imageid !== false && $order !== false) {

            if(!$this -> ajax_products_model -> Ajax_Edit_Order_Image_Product($imageid,$order)){

              $msg = "Đã có lỗi xảy ra, xin thử lại sau!";

            }else {

              $msg = "Đã cập nhật!";

            }
          }

          echo json_encode(array("msg" => $msg));
        }

        // chon anh chinh co product
        public function Update_Product_Main_Image($prdid = false) {
          $msg = "";
          $imageid = $this -> input -> post('imageid');

          if($imageid !== false && $prdid !== false) {

            if(!$this -> ajax_products_model -> Ajax_Edit_Main_Image_Product($prdid,$imageid)){

              $msg = "Đã có lỗi xảy ra, xin thử lại sau!";

            }else {

              $msg = "Đã cập nhật!";

            }
          }

          echo json_encode(array("msg" => $msg));
        }

        // xoa anh cua product khi chinh sua
        public function Delete_Product_Image($prdid = false) {
          $msg = "a";
          $imageid = $this -> input -> post('imageid');

          if($imageid !== false && $prdid !== false) {

            if($this -> ajax_products_model -> Ajax_Edit_Delete_Image_Product($imageid,$prdid)){

              $msg = "Đã xóa ảnh!";

            }else {

              $msg = "Đã có lỗi xảy ra, xin thử lại sau!";

            }
          }

          echo json_encode(array("msg" => $msg));
        }

        public function products_upload_images($action = false,$prdid = false){
          /*
          ** Xem cu the method Upload_single_image trong : "../core/CMS_BaseController.php"
          */
          $TitleText = $this -> input -> get('TitleText');
          $AltText = $this -> input -> get('AltText');

          $data = $this -> Upload_Single_Image2();
          $imageid = "";
          switch ($action) //start switch......
          {
            case "edit" : {

            }// end case edit.....
            case "add" : {
              //$imageid = $this -> ajax_products_model -> Ajax_Edit_Get_Id_ImageNewest()['ImageProductsID'];

            }
            default : {
              break;
            }
          }// end switch .....
          echo json_encode(array('url' => $data['url_thumbs'],'imgname' => $data['file_name'], 'msg' => $data['message'], 'imageid' => $imageid,'TitleText' => $TitleText,'AltText' => $AltText));
        }

        // public function a_products_upload_images($action = false,$prdid = false){

        //   $msg = "";
        //   $url= "";
        //   $imageid= "";
        //   $imgname = "";
        //   $file_element_name = 'userfile';

        //   $gallery_path;

        //   $name = $_FILES[$file_element_name]["name"];

        //   $config['upload_path'] = './resources/uploads/images/';
        //   $config['allowed_types'] = 'gif|jpg|png';
        //   $config['max_size']  = 2097152;
        //   $config['encrypt_name'] = TRUE;

        //   $this->load->library('upload', $config);

        //   if($action !== false ) {
        //       if (!empty($name)){

        //         if (!$this->upload->do_upload($file_element_name))
        //         {

        //           $msg = $this->upload->display_errors('','');

        //         }else{
        //           $data = $this->upload->data();

        //           $gallery_path = realpath(APPPATH . '../resources/uploads/images');
        //           $config = array(

        //             'source_image' => $data['full_path'],
        //             'new_image' => $gallery_path . '/thumbs',
        //             'maintain_ratio' => true,
        //             // 'create_thumb' => true,
        //             // 'thumb_marker' => '_150_100',
        //             'width' => 150,
        //             'height' => 100

        //           );

        //           $this->load->library('image_lib', $config);
        //           $this->image_lib->resize();

        //           $url = base_url().'resources/uploads/images/thumbs/'.$data['file_name'];
        //           $imgname = $data['file_name'];

        //           switch ($action) //start switch......
        //           {
        //             case "edit" : {

        //               if($prdid !== false) {
        //                 if(!$this -> ajax_products_model -> Ajax_Edit_Insert_Image_When_Upload($prdid,$data['file_name'])){
        //                   //
        //                   $msg = "Error: Chưa lưu được vào cơ sở dữ liệu! Thử lại sau.";
        //                 }else {
        //                   $imageid = $this -> ajax_products_model -> Ajax_Edit_Get_Id_ImageNewest()['ImageProductsID'];
        //                 }

        //               }
        //               break;

        //             }// end case edit.....
        //             case "add" : {
        //               //$imageid = $this -> ajax_products_model -> Ajax_Edit_Get_Id_ImageNewest()['ImageProductsID'];
        //               break;

        //             }
        //             default : {
        //               break;
        //             }
        //           }// end switch .....
        //         }

        //         @unlink($_FILES[$file_element_name]);

        //       }else {

        //         $msg = "Error: Chưa chọn file cần upload!";

        //       }

        //     echo json_encode(array('url' => $url,'imgname' => $imgname, 'msg' => $msg, 'imageid' => $imageid));

        //   }
        // }

/*********** Ben duoi la cac ham de test :D
************************************************************************************************/
        //start..........
        public function upload_file($action = false){

          $msg = "";
          $url= "";
          $file_element_name = 'userfile';

          $gallery_path;

          $name = $_FILES[$file_element_name]["name"];

          $config['upload_path'] = './resources/uploads/images/';
          $config['allowed_types'] = 'gif|jpg|png';
          $config['max_size']  = 2097152;
          $config['encrypt_name'] = TRUE;

          $this->load->library('upload', $config);
          if (!empty($name)){

            if (!$this->upload->do_upload($file_element_name))
            {
              $msg = $this->upload->display_errors('','');

            }else{

              $data = $this->upload->data();

              $gallery_path = realpath(APPPATH . '../resources/uploads/images');
              $config = array(

                'source_image' => $data['full_path'],
                'new_image' => $gallery_path . '/thumbs',
                'maintain_ratio' => true,
                // 'create_thumb' => true,
                // 'thumb_marker' => '_150_100',
                'width' => 150,
                'height' => 100

              );

              $this->load->library('image_lib', $config);
              $this->image_lib->resize();

              $url = base_url().'resources/uploads/images/thumbs/'.$data['file_name'];

            }

            @unlink($_FILES[$file_element_name]);

          }else {

            $msg = "Error: Chưa chọn file cần upload!";

          }

            echo json_encode(array('url' => $url, 'msg' => $msg));
        }
        //end.............
    }
?>