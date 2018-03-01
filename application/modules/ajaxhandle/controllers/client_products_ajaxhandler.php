<?php
    class Client_products_ajaxhandler extends CMS_BaseController {
        function __construct(){

        	parent::__construct();
          // ../modules/ajaxhandle/models/ajax_products_model
          $this -> load -> model('ajax_products_model');
        }
        
        function Ajax_Get_All_Product_Client($keyword = false) {
            $keyword = $this -> input -> post('keyword');
            $dssp = $this -> ajax_products_model -> Ajax_Get_All_Product($keyword,15,0);
            
            //$data['response'] = 'true'; //Set response
            $data['message'] = array(); //Create array
            foreach($dssp -> result_array() as $row){
         	      $data['message'][] = array('ProductsID'=> $row['ProductsID'], 'Title'=> $row['Title'], 'Slug' => $row['Slug'], 'SellPrice' => $row['SellPrice'], 'Image' => $row['ImageURL']); //Add a row to array
            }
            echo json_encode($data);
        }
    }
?>