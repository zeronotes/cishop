<?php
	class Ads_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ads_get_all($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			$selectClause = " select (select count(AdsID) from ads where "
								.$whereClause. "
								) as count, AdsID,Title,ImageURL,Orders,CAST(Publish as UNSIGNED INT) as Publish,Height,Width from ads
									where ".$whereClause." order by AdsGroupsID asc, Orders asc, CreatedDate desc limit ?,?";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();

		}

		// get all information of an Ads by id
		public function Ads_get_by_id($id = false) {
			if($id !== false) {
				$selectClause = " select AdsID,Title,Description,ImageURL,Orders,CAST(Publish as UNSIGNED INT) as Publish,Height,Width,Link, AdsGroupsID,
									DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
									DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
										(select Username from admin where UsersID = CreatedBy) as CreatedBy,
										(select Username from admin where UsersID = ModifiedBy) as ModifiedBy
											from ads where AdsID = ? ";
				$result = $this -> db -> query($selectClause,array($id));

				if($result -> num_rows() > 0) {
					return $result -> row_array();
				}
				return false;
			}else {
				show_404();
			}
		}

		// get all information of an Ads by slug
		public function Ads_get_by_slug($Slug = false) {

		}

		private function Check_input_fields() {

			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";
			$this -> input -> post('ImageURL') ? $ImageURL = $this -> input -> post('ImageURL') : $ImageURL = "";
			$this -> input -> post('Link') ? $Link = $this -> input -> post('Link') : $Link = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ?  $Orders = $this -> input -> post('Orders') : $Orders = 999 )  : $Orders = 999;
			$this -> input -> post('Publish') ? $Publish = 1 : $Publish = 0;
			$this -> input -> post('Height') ? ( is_numeric($this -> input -> post('Height')) ?  $Height = $this -> input -> post('Height') : $Height = 0 )  : $Height = 0;
			$this -> input -> post('Width') ? ( is_numeric($this -> input -> post('Width')) ?  $Width = $this -> input -> post('Width') : $Width = 0 )  : $Width = 0;
			$this -> input -> post('AdsGroupsID') ? $AdsGroupsID = $this -> input -> post('AdsGroupsID') : $AdsGroupsID = "";

			$data = array(
						'Title' => $Title ,
						'Description' => $Description ,
						'ImageURL' => $ImageURL ,
						'Link' => $Link ,
						'Orders' => $Orders ,
						'Publish' => $Publish ,
						'Height' => $Height ,
						'Width' => $Width ,
						'AdsGroupsID' => $AdsGroupsID,
					);

			return $data;
		}

		// insert an Ads into DB. $CateObject cantain all of Ads information
		public function Ads_insert() {
			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Description' => $receivedata['Description'] ,
						'ImageURL' => $receivedata['ImageURL'] ,
						'Link' => $receivedata['Link'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish'] ,
						'Height' => $receivedata['Height'] ,
						'Width' => $receivedata['Width'] ,
						'AdsGroupsID' => $receivedata['AdsGroupsID'] ,
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('ads',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		// update an Ads
		public function Ads_update($id = false) {
			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'] ,
						'Description' => $receivedata['Description'] ,
						'ImageURL' => $receivedata['ImageURL'] ,
						'Link' => $receivedata['Link'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish'] ,
						'Height' => $receivedata['Height'] ,
						'Width' => $receivedata['Width'] ,
						'AdsGroupsID' => $receivedata['AdsGroupsID'] ,
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

			return $this -> db -> update('ads',$data,array('AdsID' => $id));
		}

		// delete an Ads
		public function Ads_delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('ads',array('AdsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>