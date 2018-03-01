<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Cart_model extends CI_Model {
    	public function __construct()
    	{
            
    	}

    	function update_cart($rowid, $qty, $price, $amount) {
     		$data = array(
    			'rowid'   => $rowid,
    			'qty'     => $qty,
    			'price'   => $price,
    			'amount'  => $amount
    		);
    		$this -> cart -> update($data);
    	}
        
        function add_customer(){
            $FullName = $_SESSION['cart_guest']['fullname'];
            $Address = $_SESSION['cart_guest']['address'];
            $Phone = $_SESSION['cart_guest']['phone'];
            $Email = $_SESSION['cart_guest']['email'];
            $data = array(
                'FullName' => $FullName,
                'Address' => $Address,
                'Phone' => $Phone,
                'Email' => $Email,
            );
            $this -> db -> insert('customers', $data);
            return $this -> db -> insert_id();
        }
        
        function add_orders($is_user, $customer_id){
            $IsUser = $is_user;
            $CustomersID = $customer_id;
            $Notes = $this -> input -> post('Notes');
            $data = array(
                'IsUser' => $IsUser,
                'CustomersID' => $CustomersID,
                'Notes' => $Notes
            );
            $this -> db -> insert('orders', $data);
            return $this -> db -> insert_id();
        }
        
        function get_order_by_id($order_id){
                $this -> db -> from("orders");
                $this -> db -> where("OrdersID", $order_id);
                $query = $this -> db -> get();
                return $query -> result();
            }
        
        function add_orders_item($order_id){
            $cart = $this->cart->contents();
           	foreach ($cart as $item) {
                $data = array(
                    'OrderID' => $order_id,
                    'ProductsID' => $item['id'],
                    // 'Slug' => $item['slug'],
                    'Quantity' => $item['qty'],
                    'Price' => $item['price'],
                    // 'Option' => $item['options']['option']
                );
                $this -> db -> insert('orderitems', $data);
            }
        }

        function add_orders_shipping($order_id){
            $OrdersShippingAddress = $this -> input -> post('shipping_address');
            $OrdersShippingCity = $this -> input -> post('shipping_city');
            $OrdersShippingAddressType = $this -> input -> post('shipping_address_type');
            $data = array(
                'OrdersID' => $order_id,
                'OrdersShippingAddress' => $OrdersShippingAddress,
                'OrdersShippingCity' => $OrdersShippingCity,
                'OrdersShippingAddressType' => $OrdersShippingAddressType
            );
            $this -> db -> insert('ordershipping', $data);
        }
    }