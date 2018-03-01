<?php
	class Ads_groups_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function Ads_groups_get_all($limit_start=false,$limit_show=false) {
			$selectClause = " select (select count(AdsGroupsID) from adsgroups) as count, AdsGroupsID,Title,
								DATE_FORMAT(CreatedDate,'%T %d-%m-%Y') as CreatedDate,
								DATE_FORMAT(ModifiedDate,'%T %d-%m-%Y') as ModifiedDate,
									(select Username from admin where UsersID = CreatedBy) as CreatedBy,
									(select Username from admin where UsersID = ModifiedBy) as ModifiedBy
										from adsgroups order by adsgroups.CreatedDate asc limit ?,?";
			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			return $result;
		}

		public function Ads_groups_get_for_select_box() {
			$selectClause = " select AdsGroupsID,Title from adsgroups ";

			$result = $this -> db -> query($selectClause);

			return $result;
		}

		// get all information of an Ads_groups by id
		public function Ads_groups_get_by_id($id = false) {

			if($id !== false) {
				$selectClause = " select (select count(AdsGroupsID) from adsgroups) as count, AdsGroupsID, Title, CategoriesProductsID,
									DATE_FORMAT(CreatedDate,'%T %d-%m-%Y') as CreatedDate,
									DATE_FORMAT(ModifiedDate,'%T %d-%m-%Y') as ModifiedDate,
										(select Username from admin where UsersID = CreatedBy) as CreatedBy,
										(select Username from admin where UsersID = ModifiedBy) as ModifiedBy
											from adsgroups where AdsGroupsID = ? ";

				$result = $this -> db -> query($selectClause,array($id));

				return $result;
			}

			show_404();
		}

		// get all information of an Ads_groups by slug
		public function Ads_groups_get_by_slug($Slug = false) {

		}

		private function Check_input_fields() {
			$this -> input -> post('Title') ? $Title = $this -> input -> post('Title') : $Title = "";
			$this -> input -> post('CategoriesProductsID') ? $CategoriesProductsID = $this -> input -> post('CategoriesProductsID') : $CategoriesProductsID = "";

			$data = array(
						'Title' => $Title,
						'CategoriesProductsID' => $CategoriesProductsID
					);

			return $data;
		}

		// insert an AdsGroups into DB. $CateObject cantain all of Ads information
		public function Ads_groups_insert() {

			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'],
						'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
						'CreatedBy' => $this -> session -> userdata('userid')
					);

			$this -> db -> insert('adsgroups',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;

		}

		// update an AdsGroups
		public function Ads_groups_update($id = false) {

			$receivedata = $this -> Check_input_fields();

			$data = array(
						'Title' => $receivedata['Title'],
						'CategoriesProductsID' => $receivedata['CategoriesProductsID'],
						'ModifiedBy' => $this -> session -> userdata('userid'),
						'ModifiedDate' => date('Y-m-d H:i:s', time())
					);

			return $this -> db -> update('adsgroups',$data,array('AdsGroupsID' => $id));

		}

		// delete an AdsGroups
		public function Ads_groups_delete($id = false) {

			if($id !== false) {
				$this -> db -> delete('adsgroups',array('AdsGroupsID' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>