<?php 
	class Ajax_products_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ajax_Update_Product_SKU() {
			$id = $this -> input -> post('id');
			$sku = $this -> input -> post('SKU');
			if($sku !== false && $id !== false) {
				$data = array('SKU' => $sku,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_Publish() {
			$id = $this -> input -> post('id');
			$publish = $this -> input -> post('Publish');
			if($publish !== false && $id !== false) {
				$data = array('Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_IsNew() {
			$id = $this -> input -> post('id');
			$isnew = $this -> input -> post('IsNew');
			if($isnew !== false && $id !== false) {
				$data = array('IsNew' => (int)$isnew,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_IsHot() {
			$id = $this -> input -> post('id');
			$ishot = $this -> input -> post('IsHot');
			if($ishot !== false && $id !== false) {
				$data = array('IsHot' => (int)$ishot,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_IsSellers() {
			$id = $this -> input -> post('id');
			$issellers = $this -> input -> post('IsSellers');
			if($issellers !== false && $id !== false) {
				$data = array('IsSellers' => (int)$issellers,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_IsPromotion() {
			$id = $this -> input -> post('id');
			$ispromotion = $this -> input -> post('IsPromotion');
			if($ispromotion !== false && $id !== false) {
				$data = array('IsPromotion' => (int)$ispromotion,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_IsStock() {
			$id = $this -> input -> post('id');
			$isstock = $this -> input -> post('IsStock');
			if($isstock !== false && $id !== false) {
				$data = array('IsStock' => (int)$isstock,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_Orders() {
			$id = $this -> input -> post('id');
			$orders = $this -> input -> post('orders');
			if($orders !== false && $id !== false) {
				$data = array('Orders' => (float)$orders,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Update_Product_SellPrice() {
			$id = $this -> input -> post('id');
			$sellprice = $this -> input -> post('SellPrice');
			if($sellprice !== false && $id !== false) {
				$data = array('SellPrice' => $sellprice,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		// cap nhat list price cua product
		public function Ajax_Update_Product_ListPrice() {
			$id = $this -> input -> post('id');
			$listprice = $this -> input -> post('ListPrice');
			if($listprice !== false && $id !== false) {
				$data = array('ListPrice' => $listprice,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Ajax_Check_Title() {
			$title = $this -> input -> post('title');
				
			$this -> db -> select('ProductsID');
			$this -> db -> from('products');
			$this -> db -> where('Title', $title);
			$query = $this -> db -> get();
			if ($query -> num_rows() > 0) {
				return true;
			} else {
				$this -> db -> select('CategoriesProductsID');
				$this -> db -> from('categoriesproducts');
				$this -> db -> where('Title', $title);
				$query2 = $this -> db -> get();
				if ($query2 -> num_rows() > 0) {
					return true;
				}
			}
		}

		public function Ajax_Check_Title_Except() {
			$title = $this -> input -> post('title');
			$id = $this -> input -> post('id');
			
			$this -> db -> select('ProductsID');
			$this -> db -> from('products');
			$this -> db -> where_not_in('ProductsID', $id);
			$this -> db -> where('Title', $title);
			$query = $this -> db -> get();
			if ($query -> num_rows() > 0) {
				return true;
			} else {
				$this -> db -> select('CategoriesProductsID');
				$this -> db -> from('categoriesproducts');
				$this -> db -> where('Title', $title);
				$query2 = $this -> db -> get();
				if ($query2 -> num_rows() > 0) {
					return true;
				}
			}
		}

/*********** Ben duoi la cac method thao tac voi anh? cua product
************************************************************************************************/

		// lay ra id cua image vua them vao db
		public function Ajax_Edit_Get_Id_ImageNewest() {

			$selectClause = " ImageProductsID from imageproducts order by ImageProductsID desc limit 1";

			$this -> db -> select($selectClause);

			$result = $this -> db -> get();

			return $result -> row_array();

		}

		// cap nhat thu tu cho tung anh cua product
		public function Ajax_Edit_Order_Image_Product($imageid = false,$orders = false) {
			if($imageid !== false && $orders !== false) {
				
				$this -> db -> update("imageproducts",array("orders" => $orders),array("ImageProductsID" => $imageid));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		// chon anh chinh cho san pham
		public function Ajax_Edit_Main_Image_Product($prdid = false, $imageid = false) {
			if($prdid !== false && $imageid !== false) {
				
				$this -> db -> update("imageproducts",array("IsMainImage" => 0),array("ProductsID" => $prdid));
				
				// if($this -> db -> affected_rows() > 0){
					
					$this -> db -> update("imageproducts",array("IsMainImage" => 1),array("ImageProductsID" => $imageid));
					
					if($this -> db -> affected_rows() > 0)
						return true;
				//}
			}
			return false;
		}

		// xoa anh cua product
		public function Ajax_Edit_Delete_Image_Product($imageid = false,$prdid = false) {
			if($imageid !== false) {
				$this -> db -> delete("imageproducts",array("ImageProductsID" => $imageid));
				
				if($this -> db -> affected_rows() > 0){
					
					$this -> db -> update('products',array('ModifiedBy' => $this -> session -> userdata('userid'),
															'ModifiedDate' => date('Y-m-d H:i:s', time())
															),
											array('ProductsID' => $prdid)
										  );
					return true;
				}
			}
			return false;
		}

		// Khi nguoi dung upload 1 anh trong form edit product 
		// thi lap tuc insert luon cai anh vua upload vao db
		public function Ajax_Edit_Insert_Image_When_Upload($prdid = false,$imageurl = false) {
			if($prdid !== false && $imageurl !== false) {
				
				$data = array(
							"ProductsID" => $prdid,
							"ImageURL" => $imageurl
						);
				
				$this -> db -> insert("imageproducts",$data);

				if($this -> db -> affected_rows() > 0){
					$this -> db -> update('products',array('ModifiedBy' => $this -> session -> userdata('userid'),
															'ModifiedDate' => date('Y-m-d H:i:s', time())
															),
											array('ProductsID' => $prdid)
										  );
					
					if($this -> db -> affected_rows() > 0)
						return true;
				}
				return false;
			}
		}

/*********** Ben duoi la cac ham de test :D
************************************************************************************************/
		public function Ajax_Update_Product_Images($action = false,$imageid = false) {
			if($action !== false) {
				switch ($action) {
					case "add" : {
						//$this -> db
						break;
					}
					case "delete" : {
						if($imageid !== false) {
							$this -> db -> delete('imageproducts',array("ImageProductsID" => $imageid));
							if($this -> db -> affected_rows() > 0)
								return true;
							return false;
						}
						break;
					}default : {
						show_404();
						break;
					}
				}
			}
		}

		public function Ajax_Get_All_Product($keyword = false,$limit_show = false, $limit_start = false) {
            
            $selectClause = "";

			$selectClause .= " products.ProductsID,products.SKU,products.Slug,products.Title,products.SellPrice,products.ListPrice,CAST(products.Publish as UNSIGNED INT) as Publish,products.Orders,products.ImageURL, ";
			$selectClause .= " (select count(ProductsID) from products ";
			$selectClause .= "	) as count ";
			$selectClause .= " from products as products where products.Title LIKE '%" . $keyword ."%'";
			$selectClause .= " order by products.CreatedDate desc";
            
            //echo $selectClause;
			$this -> db -> select($selectClause);
			$this -> db -> limit($limit_show,$limit_start);
			$result = $this -> db -> get();
			
			return $result;
        }
	}
?>