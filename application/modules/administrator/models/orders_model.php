<?php 
	class Orders_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
			// $this -> auth = new stdClass;
   //          $this -> load -> library('flexi_auth');
   //          $this -> load -> model('flexi_auth_model');
		}


		public function Get_all_orders($limit_start=false,$limit_show=false,$whereClause1 = false, $whereClause2 = false) {
			$this -> db -> select('orders.OrdersID, orders.IsUser, orders.CustomersID, orders.Notes, orders.CreatedDate, orders.UnRead,
									orderstatus.OrderStatusID, orderstatus.Title as OrdersStatusTitle,
									payments.PaymentsID, payments.Title as PaymentsTitle,
									customers.FullName as `cus.Name`');
            $this -> db -> from('orders');
            $this -> db -> join('orderstatus', 'orders.OrderStatusID = orderstatus.OrderStatusID');
            $this -> db -> join('payments', 'orders.PaymentsID = payments.PaymentsID');
            $this -> db -> join('customers', 'orders.CustomersID = customers.CustomersID');
            $this -> db -> where($whereClause1);
            $query = $this -> db -> get();
			$subQuery1 = $this -> db -> last_query();

			// $this -> db -> select('orders.OrdersID, orders.IsUser, orders.CustomersID, orders.Notes, orders.CreatedDate, orders.UnRead,
			// 						orderstatus.OrderStatusID, orderstatus.Title as OrdersStatusTitle,
			// 						payments.PaymentsID, payments.Title as PaymentsTitle,
			// 						user_info.user_fullname as `cus.Name`');
   //          $this -> db -> from('orders');
   //          $this -> db -> join('orderstatus', 'orders.OrderStatusID = orderstatus.OrderStatusID');
   //          $this -> db -> join('payments', 'orders.PaymentsID = payments.PaymentsID');
   //          $this -> db -> join('user_info', 'orders.CustomersID = user_info.uacc_group_fk');
   //          $this -> db -> where($whereClause2);
   //          $query2 = $this -> db -> get();
			// $subQuery2 = $this -> db -> last_query();

			// $this -> db -> select("* from ($subQuery1 UNION $subQuery2) as UNION_TABLE");
			$this -> db -> select("* from ($subQuery1) as UNION_TABLE");
			$this -> db -> order_by('OrdersID', 'desc');
            $this -> db -> limit($limit_show, $limit_start);
            $query = $this -> db -> get();
            $list_order =  $query -> result();
            foreach ($list_order as $list) {
            	// if(ord($list -> IsUser) == 1) {
            	// 	$result1 = $this -> flexi_auth -> get_user_by_id($list -> CustomersID) -> row();
            	// 	$list -> fullname = $result1 -> user_fullname;
            	// } else {
            		$this -> db -> from('customers');
            		$this -> db -> where('CustomersID', $list -> CustomersID);
            		$query2 = $this -> db -> get();
            		$result2 = $query2 -> row();
            		$list -> fullname = $result2 -> FullName;
            	// }
            }
			return $list_order;
		}

		// public function Get_orders_by_id($id = false) {
		// 	if($id !== false && is_numeric($id)) {
		// 		$selectClause = " select orders.OrdersID,orders.CustomersID,DATE_FORMAT(orders.CreatedDate,'%T %m-%d-%Y') as CreatedDate,DATE_FORMAT(orders.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
		// 							(select Username from users where UsersID = orders.ModifiedBy) as ModifiedBy,orders.Notes,orders.UnRead,
		// 			                    (select sum(Price*Quantity) from orderitems where  OrderID = orders.OrdersID ) as TotalPrice,
		// 				                    cus.FullName,cus.Address as CusAddress,cus.Email as CusEmail,cus.Phone as CusPhone,ordstt.OrderStatusID, pay.Title as PayTitle,pay.PaymentsID
		// 				                        from orders inner join customers as cus on orders.CustomersID = cus.CustomersID
		// 				                            left join orderstatus as ordstt on  orders.OrderStatusID = ordstt.OrderStatusID
		// 				                                left join payments as pay on orders.PaymentsID = pay.PaymentsID 
		// 				                                	where orders.OrdersID = ?";
		// 		$result = $this -> db -> query($selectClause,array($id));
				
		// 		$this -> Update_read_status($id);

		// 		return $result;
		// 	}
		// 	show_404();
		// }

		public function Get_orders_by_id($id = false) {
			if($id !== false && is_numeric($id)) {
				$selectClause = " select orders.OrdersID,orders.CustomersID,DATE_FORMAT(orders.CreatedDate,'%T %m-%d-%Y') as CreatedDate,DATE_FORMAT(orders.ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,ModifiedBy,Notes,
									(select sum(Price*Quantity) from orderitems where OrderID = orders.OrdersID ) as TotalPrice,
						                cus.FullName,cus.Address as CusAddress,cus.Email as CusEmail,cus.Phone as CusPhone,ordstt.OrderStatusID, pay.Title as PayTitle,pay.PaymentsID
						                    from orders inner join customers as cus on orders.CustomersID = cus.CustomersID
						                        left join orderstatus as ordstt on  orders.OrderStatusID = ordstt.OrderStatusID
						                            left join payments as pay on orders.PaymentsID = pay.PaymentsID 
						                                where orders.OrdersID = ?";
				$result = $this -> db -> query($selectClause,array($id));
				
				$this -> Update_read_status($id);

				return $result;
			}
			show_404();
		}

		public function Get_orders_items($id = false) {
			if($id !== false && is_numeric($id)) {
				$selectClause = " select ordite.*,prd.Title as ProductTitle,ifnull(ordite.Price,0)*ifnull(ordite.Quantity,0) as Total from orderitems as ordite 
									inner join products as prd on ordite.ProductsID = prd.ProductsID where ordite.OrderID = ?";

				$result = $this -> db -> query($selectClause,array($id));

				return $result;
			}
			show_404();
		}

		public function Get_all_orders_status() {
			$selectClause = " select OrderStatusID,Title from orderstatus";

			$result = $this -> db -> query($selectClause);

			return $result;
		}

		public function Get_all_payments_method() {
			$selectClause = " select PaymentsID,Title from payments";

			$result = $this -> db -> query($selectClause);

			return $result;	
		}

		public function Update_read_status($id = false) {
			if($id !== false && is_numeric($id)) {
				$this -> db -> update('orders',array('UnRead'=>0),array('OrdersID' => $id));
			}else {
				show_404();
			}
		}
	}
?>
