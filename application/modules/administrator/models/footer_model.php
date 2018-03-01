<?php
	class Footer_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Footer_get_all($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			$selectClause = " select (select count(FooterID) from footer where "
								.$whereClause. "
								) as count, FooterID,Title,ImageURL,Orders,CAST(Publish as UNSIGNED INT) as Publish from footer
									where ".$whereClause." order by Orders asc, CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;

		}

		public function Footer_get_by_id($id = false) {

			$selectClause = " select FooterID,Title,Body,Title_en,Body_en,ImageURL,Orders,CAST(Publish as UNSIGNED INT) as Publish,Link,
								DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
									DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
										(select Username from admin where UsersID = CreatedBy) as CreatedBy,
								            (select Username from admin where UsersID = ModifiedBy) as ModifiedBy
								            	from footer where FooterID = ? ";
			$result = $this -> db -> query($selectClause, array($id));

			return $result;

		}

		private function Check_input_fields() {
			$this -> input -> post('ImageURL') ? $ImageURL = $this -> input -> post('ImageURL') : $ImageURL = "";
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Body') ? $Body = $this -> input -> post('Body') : $Body = "";
			$this -> input -> post('Title_en') ? $Title_en = $this -> input -> post('Title_en') : $Title_en = "";
			$this -> input -> post('Body_en') ? $Body_en = $this -> input -> post('Body_en') : $Body_en = "";
			$this -> input -> post('Link') ? $Link = $this -> input -> post('Link') : $Link = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ? $Orders = $this -> input -> post('Orders') : $Orders = 999 ) : $Orders = 999 ;
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;

			$data = array(
						'ImageURL' => $ImageURL,
						'Title' => $Title,
						'Body' => $Body,
						'Title_en' => $Title_en,
						'Body_en' => $Body_en,
						'Link' => $Link,
						'Orders' => $Orders,
						'Publish' => $Publish
					);

			return $data;
		}

		public function Footer_insert() {
			$receivedata = $this -> Check_input_fields();
			$data = array(
						'ImageURL' => $receivedata['ImageURL'],
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Orders' => $receivedata['Orders'],
						'Body' => $receivedata['Body'],
						'Link' => $receivedata['Link'],
						'Body_en' => $receivedata['Body_en'],
						'Publish' => (int)$receivedata['Publish'],
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('footer',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Footer_update($id = false) {

			if($id !== false && is_numeric($id)) {
				$receivedata = $this -> Check_input_fields();

				$data = array(
						'ImageURL' => $receivedata['ImageURL'],
						'Title' => $receivedata['Title'],
						'Title_en' => $receivedata['Title_en'],
						'Orders' => $receivedata['Orders'],
						'Body' => $receivedata['Body'],
						'Link' => $receivedata['Link'],
						'Body_en' => $receivedata['Body_en'],
						'Publish' => (int)$receivedata['Publish'],
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

				$this -> db -> Update('footer',$data,array('FooterID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			show_404();

		}

		public function  Footer_update_orders() {
			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id !== false && $orders !== false) {
				$data = array(
						'Orders' => $orders,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);
				$this -> db -> update('footer',$data,array('FooterID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;
		}

		public function Footer_update_publish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('publish') ? $publish = 1 : $publish = 0;
			if($id !== false && is_numeric($id)) {
				$data = array(	'Publish' => (int)$publish,
								'ModifiedBy' => $this -> session -> userdata('userid'),
								'ModifiedDate' => date('Y-m-d H:i:s', time())
							);

				$this -> db -> update('footer',$data,array('FooterID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function Footer_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('footer',array('FooterID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			show_404();
		}
	}
?>