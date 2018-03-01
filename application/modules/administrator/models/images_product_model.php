<?php 
	class Images_product_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		// get all images for each product
		public function Prd_image_get_all($prdid = false) {
			if($prdid !== false) {
				$selectClause = "";

				$selectClause .= " ImageProductsID,CAST(IsMainImage as UNSIGNED INT) as IsMainImage,Title,Description,ImageURL,TitleText,AltText,Orders,ProductsID from imageproducts where ProductsID = ".$prdid;

				$this -> db -> select($selectClause);

				$result = $this -> db -> get();

				return $result;
			} 
		}

		private function check_field_image() {

		}

		/*
		** Insert tung anh vao db. Chua bao gom cac thong tin khac nhu Description, Title.....
		** @param : + $imageurl : ten hoac url moi~ anh? cua product
		**			+ $prdid : ID cua product can them anh?
		**			+ $mainimg : Dung de xac dinh xem anh nao se la anh chi cho product 
		**						( Tam dung url/name cua anh? luc submit len server de xac dinh anh? chinh ).
		**			+ $orders : Thu tu hien thi cua anh? khi hien thi len web.
		*/
		public function Prd_image_insert_single($imageurl = false,$titleText = false,$altText = false,$prdid = false,$mainimg = false,$orders = 999) {
			if($imageurl !== false && $prdid !== false){
				if($orders == "") $orders = 999;
				$data = array(
							'ImageURL' => $imageurl,
							'Orders' => $orders,
							'TitleText' => $titleText,
							'AltText' => $altText,
							'ProductsID' => $prdid,
					);
				$imageurl == $mainimg ? $data['IsMainImage'] = 1 : $data['IsMainImage'] = 0;
				$this -> db -> insert('imageproducts',$data);

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		// insert images for product, return true or false. $PrdImgObject contain all of product information.
		public function Prd_image_insert() {

			$data = array(
						'ImageURL' => $this -> input -> post(''),
						'IsMainImage' => $this -> input -> post('IsMainImage'),
						'Title' => $this -> input -> post('Title'),
						'Description' => $this -> input -> post('Description'),
						'AltText' => $this -> input -> post('AltText'),
						'TitleText' => $this -> input -> post('TitleText'),
						'Orders' => $this -> input -> post('Orders'),
						'ProductsID' => $this -> input -> post('ProductsID'),
						'CreatedBy' => $this -> session -> userdata('userid') // get from session
					);
			$this -> db -> insert('imageproducts',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;

		}

		// update images for each prooduct. 
		public function Prd_image_update($imageid = false) {
			if($imageid !== false) {
				$data = array(
							'ImageURL' => $this -> input -> post(''),
							'IsMainImage' => $this -> input -> post('IsMainImage'),
							'Title' => $this -> input -> post('Title'),
							'Description' => $this -> input -> post('Description'),
							'AltText' => $this -> input -> post('AltText'),
							'TitleText' => $this -> input -> post('TitleText'),
							'Orders' => $this -> input -> post('Orders'),
							'ProductsID' => $this -> input -> post('ProductsID'),
							'CreatedBy' => $this -> session -> userdata('userid') // get from session
						);
				$this -> db -> update('imageproducts',$data,array('ImagesID' => $imageid));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
		}

		// delete image of each product
		public function Prd_image_delete($imageid = false) {
			if($imageid !== false) {
				$this -> db -> delete('imageproducts',array('ImagesID' => $imageid));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
		}
	}
?>