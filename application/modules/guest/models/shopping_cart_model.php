<?php
	class Shopping_cart_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
			$this -> load -> model('products_model');
		}

		/**
		***	Them 1 san pham vao gio hang, kiem tra xem san pham da co hay chua.
		*** Neu da co thi cong them don vi vao so luong san pham do
		*** $cartArray[$id] : + với $id là ID cua san pham, dung lam chi so cua mang gio hang
		*** 				  + dung de luu du lieu cua san pham muon them vao gio hong(id, ten, gia tien, anh....)
		*********************/
		public function Add($id = false) {
			$cartArray = $this -> session -> userdata('oriflame_cart');
			if($id !== false) {
				if(isset($cartArray[$id])) {
                    $qty = $cartArray[$id]['Quantity'] + 1;
                    $cartArray[$id]['TotalPrice'] = $cartArray[$id]['SellPrice'] * $qty;
                    echo ' _1 : '.$cartArray[$id]['Title'];
                }else {
                    $cartArray[$id] = $this -> products_model -> Get_by_id($id) -> row_array();
                    echo ' _2 : '.$cartArray[$id]['Title'];
                    $qty = 1;
                    if(count($cartArray[$id]) > 0 ) {
                    	$cartArray[$id]['TotalPrice'] = $cartArray[$id]['SellPrice'];
                	}
                }

                if(count($cartArray[$id]) > 0 ) {
	                $cartArray[$id]['Quantity'] = $qty;
	                echo ' _3 : '.$cartArray[$id]['Title'];
	                $data = array('oriflame_cart' => $cartArray);
	                $this -> session -> set_userdata($data);
	                $cartArray = $this -> session -> userdata('oriflame_cart');
	                echo ' fuck : '.$cartArray[$id]['Title'];
	                echo ' |_ count yeah : '.count($cartArray);
	                return true;
	            }
                return false;
			}else {
				return false;
			}
		}

		public function Update($id = fasle, $operator = false, $quantity = false) {
			$cartArray = $this -> session -> userdata('oriflame_cart');
			if($id !== false && $operator !== false) {
				if($operator === 'up') {
                    if(isset($cartArray[$id])) {
                        $cartArray[$id]['Quantity'] += 1;
                        $cartArray[$id]['TotalPrice'] = $cartArray[$id]['SellPrice'] * $cartArray[$id]['Quantity'];
                    }
                }else if($operator === 'down') {
                    if(isset($cartArray[$id])) {
                        if($cartArray[$id]['Quantity'] === 1) {
                            unset($cartArray[$id]);
                        }else {
                            $cartArray[$id]['Quantity'] -= 1;
                            $cartArray[$id]['TotalPrice'] = $cartArray[$id]['SellPrice'] * $cartArray[$id]['Quantity'];
                        }
                    }
                }

                $data = array('oriflame_cart' => $cartArray);
                $this -> session -> set_userdata($data);

                return true;

			}else if ($id !== false && $operator !== false && $quantity !== false && is_numeric($quantity)) {
				if($operator == 'dynamic'){
					if(isset($cartArray[$id])) {
						$cartArray[$id]['Quantity'] = $quantity;
						$cartArray[$id]['totalprice'] = $cartArray[$id]['SellPrice'] * $cartArray[$id]['Quantity'];
					}

					$data = array('oriflame_cart' => $cartArray);
                	$this -> session -> set_userdata($data);

                	return true;
				}
			}
			
			return false;
		}

		public function Remove($id = false) {
			$cartArray = $this -> session -> userdata('oriflame_cart');
			if($id !== false) {
				if(isset($cartArray[$id])) {
                    unset($cartArray[$id]);
                }
                $data = array('oriflame_cart' => $cartArray);
                $this -> session -> set_userdata($data);
                return true;
			}

			return false;

		}

		public function Total_all_price() {
			$cartArray = $this -> session -> userdata('oriflame_cart');
			$total = 0;
			if($cartArray != false && count($cartArray) > 0) {
				foreach ($cartArray as $item => $value) {
					$total += $value['SellPrice'] * $value['Quantity'];
				}
			}
			return $total;
		}

		public function Total_quantity() {
			$cartArray = $this -> session -> userdata('oriflame_cart');
			$total = 0;
			if($cartArray == false) {

			}else if(count($cartArray) > 0) {
				if($cartArray != false) {
					foreach ($cartArray as $item => $value) {
						if(isset($value['Quantity']))
							$total += $value['Quantity'];
					}
				}
			}
			return $total;
		}

		private function Get_customerid_after_insert() {
			
			$selectClause = " select CustomersID from customers order by CustomersID desc limit 1 ";

			$result = $this -> db -> query($selectClause);

			$CusID = $result -> row_array();

			return $CusID['CustomersID'];

		}

		private function Get_orderid_after_insert() {

			$selectClause = " select OrdersID from orders order by OrdersID desc limit 1 ";

			$result = $this -> db -> query($selectClause);

			$OrderID = $result -> row_array();

			return $OrderID['OrdersID'];

		}

		private function Check_input_fields() {
			$this -> input -> post('OrderNotes') ? $OrderNotes = $this -> input -> post('OrderNotes') : $OrderNotes = "";
			$this -> input -> post('OrderPayment') ? $OrderPayment = $this -> input -> post('OrderPayment') : $OrderPayment = 1;

			$this -> input -> post('CusEmail') ? $CusEmail = $this -> input -> post('CusEmail') : $CusEmail = "";
			$this -> input -> post('CusPhone') ? $CusPhone = $this -> input -> post('CusPhone') : $CusPhone = "";
			$this -> input -> post('CusAddress') ? $CusAddress = $this -> input -> post('CusAddress') : $CusAddress = "";
			$this -> input -> post('CusName') ? $CusName = $this -> input -> post('CusName') : $CusName = "";

			$data = array(

						'OrderNotes' => $OrderNotes ,
						'OrderPayment' => $OrderPayment,
						'CusEmail' => $CusEmail,
						'CusPhone' => $CusPhone,
						'CusAddress' => $CusAddress,
						'CusName' => $CusName

					);

			return $data;
		}

		public function Check_out_order() {

			$receivedata = $this -> Check_input_fields();

			$data['shopcart_items'] = $this -> session -> userdata('oriflame_cart');

			if($data['shopcart_items'] && count($data['shopcart_items']) > 0) {

				$sql = "insert into `customers` (`FullName`, `Phone`, `Email`, `Address`, `ShippingAddress`) VALUES (?, ?, ?, ?, ?);";

				$this -> db -> trans_begin();

				$this -> db -> query($sql,array($receivedata['CusName'],$receivedata['CusPhone'],$receivedata['CusEmail'],$receivedata['CusAddress'],$receivedata['CusAddress']));

				if ($this -> db -> trans_status() === FALSE) {

				    $this -> db -> trans_rollback();

				}else{

				    $this -> db -> trans_commit();

				    $sql = " insert into `orders` (`CustomersID`, `Notes`, `DeliveryDate`, `PaymentsID`) VALUES (?, ?, ?, ?); ";

				    $this -> db -> trans_begin();
				   
				  	$this -> db -> query($sql,array($this -> Get_customerid_after_insert(),$receivedata['OrderNotes'],date('Y-m-d H:i:s', time()),$receivedata['OrderPayment'],));

				    if ($this -> db -> trans_status() === FALSE) {

					    $this -> db -> trans_rollback();

					}else{

						$this -> db -> trans_commit();

						$OrderID = $this -> Get_orderid_after_insert();

						foreach ($data['shopcart_items'] as $key => $value) {
							
							$sql = " insert into `orderitems` (`OrderID`, `ProductsID`, `Quantity`, `Price`, `Notes`) VALUES (?, ?, ?, ?, ?); ";

							$this -> db -> trans_begin();

							$this -> db -> query( $sql,array($OrderID,$value['ProductsID'],$value['Quantity'],$value['SellPrice'],'') );

							if ($this -> db -> trans_status() === FALSE) {

							    $this -> db -> trans_rollback();

							}else{

								$this -> db -> trans_commit();


							}
						}
						return true;
						
						
					}


				}
			}else {

			}
			return false;

		}

	}
?>