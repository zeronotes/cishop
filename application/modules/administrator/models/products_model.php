<?php
	class Products_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Products_get_all_for_select_box() {
			$this -> db -> select('ProductsID,Title');
			$this -> db -> from('products');
			$this -> db -> where('Publish', 1);
			$this -> db -> order_by('CreatedDate', 'asc');
			$query = $this -> db -> get();
			return $query -> result_array();
		}
        public function Products_get_all_sitemap() {
			$this -> db -> select('Slug,CreatedDate');
			$this -> db -> from('products');
			$this -> db -> where('Publish', 1);
			$this -> db -> order_by('CreatedDate', 'Desc');
			$query = $this -> db -> get();
			return $query -> result_array();
		}
		/*
			fill all products into product view
				image,
				SKU,
				product title,
				price,
				list price(gia thi truong),
				ispublist  (hien thi hoac khong hien thi)

		*/
		public function Products_get_all($limit_start=false,$limit_show=false,$whereClause = false) {

			$selectClause = "";

			$selectClause .= " products.ProductsID,products.SKU,products.Title,CAST(products.Publish as UNSIGNED INT) as Publish,products.Orders,products.ImageURL, ";
			$selectClause .= " CAST(products.IsNew as UNSIGNED INT) as IsNew,CAST(products.IsHot as UNSIGNED INT) as IsHot,CAST(products.IsSellers as UNSIGNED INT) as IsSellers,CAST(products.IsPromotion as UNSIGNED INT) as IsPromotion,CAST(products.IsStock as UNSIGNED INT) as IsStock, ";
			$selectClause .= " (select count(ProductsID) from products ";
			if($whereClause !== false) {
				//$whereClause = $whereClause;
				$selectClause .= ' where '.$whereClause;
			}
			$selectClause .= "	) as count, ";
			$selectClause .= " (select ImageURL from imageproducts where ProductsID = products.ProductsID and IsMainImage = 1 limit 1) as Image ";
			$selectClause .= " from products as products ";
			if($whereClause !== false) {
				//$whereClause = $whereClause;
				$selectClause .= ' where '.$whereClause;
			}
			$selectClause .= " order by products.Orders asc, products.CreatedDate desc";

			$this -> db -> select($selectClause);
			$this -> db -> limit($limit_show,$limit_start);
			$result = $this -> db -> get();

			return $result;
		}

		// get all of product information by id
		public function Products_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = "";

				$this -> db -> select(" prd.ProductsID,prd.SKU,prd.Title,prd.Title_en,prd.Title_fr,prd.Description,prd.Description_en,prd.Description_fr,prd.Desc,prd.Desc_en,prd.Desc_fr,prd.CategoriesProductsID,prd.SortingBrandID,prd.SortingResID,prd.SortingChannelID,
								   prd.Body,prd.Body2,prd.Body_en,prd.Body_fr,CAST(prd.IsNew as UNSIGNED INT) as IsNew,CAST(prd.IsSellers as UNSIGNED INT) as IsSellers,
								   CAST(prd.IsPromotion as UNSIGNED INT) as IsPromotion,CAST(prd.IsStock as UNSIGNED INT) as IsStock,CAST(prd.IsHot as UNSIGNED INT) as IsHot,prd.Hightlight,prd.ImageURL,prd.ImageTitle,prd.ImageAlt,
								   CAST(prd.ShowPrice as UNSIGNED INT) as ShowPrice,prd.Tags,
        						   prd.SellPrice,prd.ListPrice,CAST(prd.Publish as UNSIGNED INT) as Publish,prd.Orders,prd.SEOTitle,prd.SEOKeyword,prd.SEODescription,
        						   (select Username from admin where UsersID = prd.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = prd.ModifiedBy) as ModifiedBy,");

        		$this -> db -> select("DATE_FORMAT(prd.CreatedDate,'%T %m-%d-%Y') as CreatedDate",false);
				$this -> db -> select("DATE_FORMAT(prd.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate",false);

        		$this -> db -> from("products as prd");

        		$this -> db -> where("prd.ProductsID = ".$id.";");

        		$result = $this -> db -> get();

        		return $result;
			}else {
				show_404();
			}
		}

		public function Product_get_rating($limit_start=false,$limit_show=false) {
			$selectClause = " select (select count(productsrating.ProductsID)
								from productsrating) as count ,prdRate.ProductsRatingID,prdRate.ProductsID,prd.Title,
								prdRate.Marks,prdRate.Comments,prdRate.CreatedDate,prdRate.UnRead
									from productsrating as prdRate left join products as prd on prdRate.ProductsID = prd.ProductsID
								order by prdRate.CreatedDate desc limit ?,? ";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;
		}

		private function Product_get_newsest_id() {
			// select auto_increment from information_schema.TABLES where TABLE_NAME ='tablename' and TABLE_SCHEMA='database_name';
			$this -> db -> select("auto_increment");
			$this -> db -> from("information_schema.TABLES");
			$this -> db -> where('TABLE_NAME', 'products');
			$this -> db -> where('TABLE_SCHEMA', $this -> db -> database);
			$query = $this -> db -> get();
			return $query -> row_array();
		}

        // function nay theo function cho products ben duoi
        public function check_input_field() {

        	/*
        	**	Kiem tra dau vao cua du lieu submit len server.
        	*/
            $this -> input -> post('prdTitle') ? $Title = $this -> input -> post('prdTitle') : $Title = "";
            $this -> input -> post('prdSKU') ? $SKU = $this -> input -> post('prdSKU') : $SKU = "";
            $this -> input -> post('prdTitle_en') ? $Title_en = $this -> input -> post('prdTitle_en') : $Title_en = "";
            $this -> input -> post('prdTitle_fr') ? $Title_fr = $this -> input -> post('prdTitle_fr') : $Title_fr = "";
            $this -> input -> post('prdTitle') ? $Slug = $this -> gen_slug( $this -> input -> post('prdTitle') ) : $Slug = "";
            $this -> input -> post('prdDescription') ? $Description = $this -> input -> post('prdDescription') : $Description = "";
            $this -> input -> post('prdDescription_en') ? $Description_en = $this -> input -> post('prdDescription_en') : $Description_en = "";
            $this -> input -> post('prdDescription_fr') ? $Description_fr = $this -> input -> post('prdDescription_fr') : $Description_fr = "";
            $this -> input -> post('prdDesc') ? $Desc = $this -> input -> post('prdDesc') : $Desc = "";
            $this -> input -> post('prdDesc_en') ? $Desc_en = $this -> input -> post('prdDesc_en') : $Desc_en = "";
            $this -> input -> post('prdDesc_fr') ? $Desc_fr = $this -> input -> post('prdDesc_fr') : $Desc_fr = "";
            $this -> input -> post('prdBody') ? $Body = $this -> input -> post('prdBody') : $Body = "";
            $this -> input -> post('prdBody2') ? $Body2 = $this -> input -> post('prdBody2') : $Body2 = "";
            $this -> input -> post('prdBody_en') ? $Body_en = $this -> input -> post('prdBody_en') : $Body_en = "";
            $this -> input -> post('prdBody_fr') ? $Body_fr = $this -> input -> post('prdBody_fr') : $Body_fr = "";
            $this -> input -> post('prdMainImage') ? $MainImage = $this -> input -> post('prdMainImage') : $MainImage = "";
			$this -> input -> post('prdImageTitle') ? $ImageTitle = $this -> input -> post('prdImageTitle') : $ImageTitle = "";
			$this -> input -> post('prdImageAlt') ? $ImageAlt = $this -> input -> post('prdImageAlt') : $ImageAlt = "";
            $this -> input -> post('prdOrders') ? ( is_numeric($this -> input -> post('prdOrders')) ?  $Orders = $this -> input -> post('prdOrders') : $Orders = 0 )  : $Orders = 999;
            $this -> input -> post('prdSellPrice') ? $SellPrice = $this -> input -> post('prdSellPrice') : $SellPrice = "";
            $this -> input -> post('prdListPrice') ? $ListPrice = $this -> input -> post('prdListPrice') : $ListPrice = "";
            $this -> input -> post('prdTags') ? $prdTags = implode(",",$this -> input -> post('prdTags')) : $prdTags = "";

            $this -> input -> post('prdPageTitle') ? $SEOTitle = $this -> input -> post('prdPageTitle') : $SEOTitle = "";
            $this -> input -> post('prdMetaKeywords') ? $SEOKeyword = $this -> input -> post('prdMetaKeywords') : $SEOKeyword = "";
            $this -> input -> post('prdMetaDesc') ? $SEODescription = $this -> input -> post('prdMetaDesc') : $SEODescription = "";
            /* cac tuy chon : + IsNew : san pham moi
            ** 				  +	IsPromotion : san pham khuyen mai
            **				  + IsSellers : San pham ban chay
            **				  + Publish : cho phep hien thi hay khong
			*/
			$this -> input -> post('prdIsNew') ? $IsNew = 1 : $IsNew = 0;
            $this -> input -> post('prdIsHot') ? $IsHot = 1 : $IsHot = 0;
            $this -> input -> post('prdIsSellers') ? $IsSellers = 1 : $IsSellers = 0;
            $this -> input -> post('prdIsPromotion') ? $IsPromotion = 1 : $IsPromotion = 0;
            $this -> input -> post('prdIsStock') ? $IsStock = 1 : $IsStock = 0;
            $this -> input -> post('prdPublish') ? $Publish = 1 : $Publish = 0;

            $this -> input -> post('prdCategoriesProductsID') ? $CategoriesProductsID =  $this -> input -> post('prdCategoriesProductsID') : $CategoriesProductsID = 0;
            $this -> input -> post('prdSortingBrandID') ? $SortingBrandID =  $this -> input -> post('prdSortingBrandID') : $SortingBrandID = 0;
            $this -> input -> post('prdSortingResID') ? $SortingResID =  $this -> input -> post('prdSortingResID') : $SortingResID = 0;
            $this -> input -> post('prdSortingChannelID') ? $SortingChannelID =  $this -> input -> post('prdSortingChannelID') : $SortingChannelID = 0;
            $this -> input -> post('prdHightlight') ? $prdHightlight = implode(",",$this -> input -> post('prdHightlight')) : $prdHightlight = "";
            $this -> input -> post('submit_type') ? $submit_type = $this -> input -> post('submit_type') : $submit_type = "single";

            $data = array(
						'Title' => $Title,
						'SKU' => $SKU,
						'Title_en' => $Title_en,
						'Title_fr' => $Title_fr,
						'Description' => $Description,
						'Description_en' => $Description_en,
						'Description_fr' => $Description_fr,
						'Desc' => $Desc,
						'Desc_en' => $Desc_en,
						'Desc_fr' => $Desc_fr,
						'Body' => $Body,
						'Body2' => $Body2,
						'Body_en' => $Body_en,
						'Body_fr' => $Body_fr,
						'ImageURL' => $MainImage,
						'ImageTitle' => $ImageTitle,
						'ImageAlt' => $ImageAlt,
						'SellPrice' => $SellPrice,
						'ListPrice' => $ListPrice,
						'IsNew' => $IsNew,
						'IsHot' => $IsHot,
						'IsSellers' => $IsSellers,
						'IsPromotion' => $IsPromotion,
						'IsStock' => $IsStock,
						'Publish' => $Publish,
						'Orders' => $Orders,
						'Slug' => $Slug,
						'Tags' => $prdTags,
						'SEOTitle' => $SEOTitle,
						'SEOKeyword' => $SEOKeyword,
						'SEODescription' => $SEODescription,
						'CategoriesProductsID' => $CategoriesProductsID,
						'SortingBrandID' => $SortingBrandID,
						'SortingResID' => $SortingResID,
						'SortingChannelID' => $SortingChannelID,
						'Hightlight' => $prdHightlight
					);
            return $data;
        }

		//add new product
		public function Products_insert() {
			// @param : recicedata lay ve du lieu khi submit form sau khi da kiem tra cac dieu kien cho phep
			$receivedata = $this -> check_input_field();
			$data = array(
						'Title' => $receivedata['Title'],
						'SKU' => $receivedata['SKU'],
						'Title_en' => $receivedata['Title_en'],
						'Title_fr' => $receivedata['Title_fr'],
						'Description' => $receivedata['Description'],
						'Description_en' => $receivedata['Description_en'],
						'Description_fr' => $receivedata['Description_fr'],
						'Desc' => $receivedata['Desc'],
						'Desc_en' => $receivedata['Desc_en'],
						'Desc_fr' => $receivedata['Desc_fr'],
						'Body' => $receivedata['Body'],
						'Body2' => $receivedata['Body2'],
						'Body_en' => $receivedata['Body_en'],
						'Body_fr' => $receivedata['Body_fr'],
						'ImageURL' => $receivedata['ImageURL'],
						'ImageTitle' => htmlspecialchars(trim($receivedata['ImageTitle'])),
						'ImageAlt' => htmlspecialchars(trim($receivedata['ImageAlt'])),
						'SellPrice' => $receivedata['SellPrice'],
						'ListPrice' => $receivedata['ListPrice'],
						'IsNew' => $receivedata['IsNew'],
						'IsHot' => $receivedata['IsHot'],
						'IsSellers' => $receivedata['IsSellers'],
						'IsPromotion' => $receivedata['IsPromotion'],
						'IsStock' => $receivedata['IsStock'],
						'Publish' => $receivedata['Publish'],
						'Orders' => $receivedata['Orders'],
						'Slug' => $this -> gen_slug($receivedata['Title']),
						'Tags' => $receivedata['Tags'],
						'SEOTitle' => $receivedata['SEOTitle'],
						'SEOKeyword' => $receivedata['SEOKeyword'],
						'SEODescription' => $receivedata['SEODescription'],
						'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
						'SortingBrandID' => $receivedata['SortingBrandID'],
						'SortingResID' => $receivedata['SortingResID'],
						'SortingChannelID' => $receivedata['SortingChannelID'],

						'CreatedBy' => $this -> session -> userdata('userid'), // get from session
						'Hightlight' => $receivedata['Hightlight']
					);
			$this -> db -> insert('products',$data);

			/*
			** Kiem tra xem viec insert vao db co thanh cong hay khong
			*/
			if($this -> db -> affected_rows() > 0) {

				/*
				** Lay ra id cua product vua insert thanh cong vao db,
				** de xac dinh viec insert cho cac anh? thuoc product nay
				*/
				$prdid = $this -> db -> insert_id();

				/*
				** Khi insert thanh cong product thi kiem tra xem co anh duoc nguoi dung them vao khong
				** Neu co thi tiep tuc insert vao database cac anh duoc them cho product boi nguoi dung
				**
				** @param : + imgarray : Chua tat ca cac anh ma nguoi dung quyet dinh them vao product.
				*/
				$imgarray = $this -> input -> post("imgsinsert");
				$imgTitleArray = $this -> input -> post("imgsTitleText");
				$imgAltArray = $this -> input -> post("imgsAltText");
				$orderarray = $this -> input -> post("txtPositionNum");
				$mainimg = $this -> input -> post("mainimage");
				if($imgarray != false) {

					/*
					** Xac dinh xem anh nao se la anh chinh cho product
					** Hien tai dung ten anh de xac dinh. Chua co phuong an phu hop nen tam thoi nhu vay.
					*/
					$this -> input -> post("mainimage") ? $mainimg = $this -> input -> post("mainimage") : $mainimg = "";

					/*
					** Load image model de thuc hien insert anh vao db
					** model co path nhu sau : ../modules/administrator/models/images_product_model.php
					*/
					$this -> load -> model("images_product_model");

					/*
					** Neu co anh? nguoi dung them vao, thi insert vao db bang cach dung vong lap for ben duoi
					*/
					for($i=0; $i < count($imgarray); $i++){
                        /*
						** Thuc hien insert vao db
						** @param : + $imgarray[$i] : url cua anh muon insert vao db
						**			+ $prdid : Chcinh id cua product muon insert anh? cho no
						**			+ $orderarray[$i] : la thu tu hien thi cua tung anh. co the rong~ cung~ duoc.
                        */
                        if(is_array($imgarray[$i])) {
                        	if($mainimg == "") {
	                        	$mainimg = $imgarray[0]['value'];
	                        }
                        	$this -> images_product_model -> Prd_image_insert_single($imgarray[$i]['value'],$imgTitleArray[$i]['value'],$imgAltArray[$i]['value'],$prdid,$mainimg,$orderarray[$i]['value']);
                        }else{
                        	if($mainimg == "") {
	                        	$mainimg = $imgarray[0];
	                        }
                        	$this -> images_product_model -> Prd_image_insert_single($imgarray[$i],$imgTitleArray[$i],$imgAltArray[$i],$prdid,$mainimg,$orderarray[$i]);
                        }
                    }
				}
				return true;
			}

			return false;
		}

		public function Products_fast_insert() {
			// @param : recicedata lay ve du lieu khi submit form sau khi da kiem tra cac dieu kien cho phep
			$receivedata = $this -> check_input_field();
			if($receivedata['submit_type'] && $receivedata['submit_type'] == 'single'){
				foreach ($something as $records){
					$temp_id = $this -> Product_get_newsest_id();
					$newest_id = $temp_id['auto_increment'];
					$data = array(
								'Title' => 'Sản phẩm nhanh số ' . $newest_id,
								'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
								'SortingBrandID' => $receivedata['SortingBrandID'],
								'Publish' => $receivedata['Publish'],
								'Orders' => $receivedata['Orders'],
								'Slug' => $this -> gen_slug('Sản phẩm nhanh số ' . $newest_id),
								'ImageURL' => $records,
								'CreatedBy' => $this -> session -> userdata('userid'), // get from session
							);
					$this -> db -> insert('products',$data);

					/*
					** Kiem tra xem viec insert vao db co thanh cong hay khong
					*/
					if($this -> db -> affected_rows() > 0) {
						return true;
					}
					return false;
				}
			} else if($receivedata['submit_type'] && $receivedata['submit_type'] == 'multi'){
				$temp_id = $this -> Product_get_newsest_id();
				$newest_id = $temp_id['auto_increment'];
				$data = array(
							'Title' => 'Sản phẩm nhanh số ' . $newest_id,
							'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
							'SortingBrandID' => $receivedata['SortingBrandID'],
							'Publish' => $receivedata['Publish'],
							'Orders' => $receivedata['Orders'],
							'Slug' => $this -> gen_slug('Sản phẩm nhanh số ' . $newest_id),
							'ImageURL' => $something[0],
							'CreatedBy' => $this -> session -> userdata('userid'), // get from session
						);
				$this -> db -> insert('products',$data);

				/*
				** Kiem tra xem viec insert vao db co thanh cong hay khong
				*/
				if($this -> db -> affected_rows() > 0) {

					$prdid = $this -> db -> insert_id();
					$imgarray = array_shift($something);
					if($imgarray != false) {

						$this -> load -> model("images_product_model");

						/*
						** Neu co anh? nguoi dung them vao, thi insert vao db bang cach dung vong lap for ben duoi
						*/
						for($i=0; $i < count($imgarray); $i++){
	                        /*
							** Thuc hien insert vao db
							** @param : + $imgarray[$i] : url cua anh muon insert vao db
							**			+ $prdid : Chcinh id cua product muon insert anh? cho no
							**			+ $orderarray[$i] : la thu tu hien thi cua tung anh. co the rong~ cung~ duoc.
	                        */
	                        $this -> images_product_model -> Prd_image_insert_single($imgarray[$i],"","",$prdid,"",999);
	                    }
					}
					return true;
				}
				return false;
			} else {
				return false;
			}
		}

		//update product
		public function Products_update($id = false) {
			if($id !== false) {
				$receivedata = $this -> check_input_field();
				$data = array(
							'Title' => $receivedata['Title'],
							'SKU' => $receivedata['SKU'],
							'Title_en' => $receivedata['Title_en'],
							'Title_fr' => $receivedata['Title_fr'],
							'Description' => $receivedata['Description'],
							'Description_en' => $receivedata['Description_en'],
							'Description_fr' => $receivedata['Description_fr'],
							'Desc' => $receivedata['Desc'],
							'Desc_en' => $receivedata['Desc_en'],
							'Desc_fr' => $receivedata['Desc_fr'],
							'Body' => $receivedata['Body'],
							'Body2' => $receivedata['Body2'],
							'Body_en' => $receivedata['Body_en'],
							'Body_fr' => $receivedata['Body_fr'],
							'ImageURL' => $receivedata['ImageURL'],
							'ImageTitle' => htmlspecialchars(trim($receivedata['ImageTitle'])),
							'ImageAlt' => htmlspecialchars(trim($receivedata['ImageAlt'])),
							'SellPrice' => $receivedata['SellPrice'],
							'ListPrice' => $receivedata['ListPrice'],
							'IsNew' => $receivedata['IsNew'],
							'IsHot' => $receivedata['IsHot'],
							'IsSellers' => $receivedata['IsSellers'],
							'IsPromotion' => $receivedata['IsPromotion'],
							'IsStock' => $receivedata['IsStock'],
							'Publish' => $receivedata['Publish'],
							'Orders' => $receivedata['Orders'],
							'Slug' => $this -> gen_slug($receivedata['Title']),
							'Tags' => $receivedata['Tags'],
							'SEOTitle' => $receivedata['SEOTitle'],
							'SEOKeyword' => $receivedata['SEOKeyword'],
							'SEODescription' => $receivedata['SEODescription'],
							'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
							'SortingBrandID' => $receivedata['SortingBrandID'],
							'SortingResID' => $receivedata['SortingResID'],
							'SortingChannelID' => $receivedata['SortingChannelID'],

							'ModifiedBy' => $this -> session -> userdata('userid'), // get from session
							'ModifiedDate' => date('Y-m-d H:i:s', time()),
							'Hightlight' => $receivedata['Hightlight']
						);
				$this -> db -> update('products',$data,array('ProductsID' => $id));

				if($this -> db -> affected_rows() > 0) {

					/*
					** Lay ra id cua product vua insert thanh cong vao db,
					** de xac dinh viec insert cho cac anh? thuoc product nay
					*/
					$prdid = $id;

					
					/*
					** Khi insert thanh cong product thi kiem tra xem co anh duoc nguoi dung them vao khong
					** Neu co thi tiep tuc insert vao database cac anh duoc them cho product boi nguoi dung
					**
					** @param : + imgarray : Chua tat ca cac anh ma nguoi dung quyet dinh them vao product.
					*/
					$imgarray = $this -> input -> post("imgsinsert");
					$imgTitleArray = $this -> input -> post("imgsTitleText");
					$imgAltArray = $this -> input -> post("imgsAltText");
					$orderarray = $this -> input -> post("txtPositionNum");
					$mainimg = $this -> input -> post("mainimage");
					if($imgarray != false) {

						/*
						** Xac dinh xem anh nao se la anh chinh cho product
						** Hien tai dung ten anh de xac dinh. Chua co phuong an phu hop nen tam thoi nhu vay.
						*/
						$this -> input -> post("mainimage") ? $mainimg = $this -> input -> post("mainimage") : $mainimg = "";

						/*
						** Load image model de thuc hien insert anh vao db
						** model co path nhu sau : ../modules/administrator/models/images_product_model.php
						*/
						$this -> load -> model("images_product_model");

						/*
						** Neu co anh? nguoi dung them vao, thi insert vao db bang cach dung vong lap for ben duoi
						*/
						for($i=0; $i < count($imgarray); $i++){
	                        /*
							** Thuc hien insert vao db
							** @param : + $imgarray[$i] : url cua anh muon insert vao db
							**			+ $prdid : Chcinh id cua product muon insert anh? cho no
							**			+ $orderarray[$i] : la thu tu hien thi cua tung anh. co the rong~ cung~ duoc.
	                        */
	                        if(is_array($imgarray[$i])) {
	                        	if($mainimg == "") {
		                        	$mainimg = $imgarray[0]['value'];
		                        }
	                        	$this -> images_product_model -> Prd_image_insert_single($imgarray[$i]['value'],$imgTitleArray[$i]['value'],$imgAltArray[$i]['value'],$prdid,$mainimg,$orderarray[$i]['value']);
	                        }else{
	                        	if($mainimg == "") {
		                        	$mainimg = $imgarray[0];
		                        }
	                        	$this -> images_product_model -> Prd_image_insert_single($imgarray[$i],$imgTitleArray[$i],$imgAltArray[$i],$prdid,$mainimg,$orderarray[$i]);
	                        }
	                    }
					}
					return true;
				}

				return false;
			}else {
				show_404();
			}
		}

		//delete product
		public function Products_delete($prdid = false) {
			if($prdid !== false) {
				$this -> db -> delete('products',array('ProductsID' => $prdid));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}

		public function Products_rating_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('productsrating',array('ProductsRatingID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>