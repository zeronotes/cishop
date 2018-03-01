<?php
	class People_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAllTabs() {
			$selectClause = " select * from tabs_nhansu ";

			$result = $this -> db -> query($selectClause);

			if($result -> num_rows() > 0 ) {
				return $result -> result_array();
			}
			return array();
		}

		public function Speakers_All($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {

			$selectClause = " select (select count(Id) from speakers where ". $whereClause .") as count,
									Id,FullName,FullName_en,ImgUrl,Orders, CAST(Publish as UNSIGNED INT) AS Publish
										from speakers where ". $whereClause ." order by CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}

			return array();

		}

		public function Speakers_Id($id = false) {

			$selectClause = " select Id,tabs_nhansu,FullName,FullName_en,Description,Description_en,Position,Position_en,ImgUrl,ImgInformation,ImgInformation_en,Orders, CAST(Publish as UNSIGNED INT) AS Publish
										from speakers where Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}

			return array();

		}

		private function Check_Input_Fields() {

			$this -> input -> post('tabs_nhansu') ? $tabs_nhansu = $this -> input -> post('tabs_nhansu') : $tabs_nhansu = 0;
			$this -> input -> post('FullName') ? $FullName = $this -> input -> post('FullName') : $FullName = "";
			$this -> input -> post('FullName_en') ? $FullName_en = $this -> input -> post('FullName_en') : $FullName_en = "";
			$this -> input -> post('Position') ? $Position = $this -> input -> post('Position') : $Position = "";
			$this -> input -> post('Position_en') ? $Position_en = $this -> input -> post('Position_en') : $Position_en = "";
			$this -> input -> post('Description') ? $Description = $this -> input -> post('Description') : $Description = "";
			$this -> input -> post('Description_en') ? $Description_en = $this -> input -> post('Description_en') : $Description_en = "";
			$this -> input -> post('ImageURL') ? $ImageURL = $this -> input -> post('ImageURL') : $ImageURL = "";
			$this -> input -> post('ImgInformation') ? $ImgInformation = $this -> input -> post('ImgInformation') : $ImgInformation = "";
			$this -> input -> post('ImgInformation_en') ? $ImgInformation_en = $this -> input -> post('ImgInformation_en') : $ImgInformation_en = "";
			$this -> input -> post('Orders') ? ( is_numeric($this -> input -> post('Orders')) ?  $Orders = $this -> input -> post('Orders') : $Orders = 999 )  : $Orders = 999;
			$this -> input -> post('Publish') ? $Publish = $this -> input -> post('Publish') : $Publish = 0;

			$data = array(
						'tabs_nhansu' => $tabs_nhansu,
						'FullName' => $FullName,
						'FullName_en' => $FullName_en,
						'Slug' => $this -> gen_slug($FullName),
						'Position' => $Position,
						'Position_en' => $Position_en,
						'Description' => $Description,
						'Description_en' => $Description_en,
						'ImgUrl' => $ImageURL,
						'ImgInformation' => $ImgInformation,
						'ImgInformation_en' => $ImgInformation_en,
						'Orders' => $Orders,
						'Publish' => $Publish,
					);

			return $data;

		}

		public function Speakers_Insert() {
			$receivedata = $this -> Check_Input_Fields();

			$data = array(
						'tabs_nhansu' => $receivedata['tabs_nhansu'] ,
						'FullName' => $receivedata['FullName'] ,
						'FullName_en' => $receivedata['FullName_en'] ,
						'Slug' => $receivedata['Slug'],
						'Description' => $receivedata['Description'] ,
						'Description_en' => $receivedata['Description_en'] ,
						'Position' => $receivedata['Position'] ,
						'Position_en' => $receivedata['Position_en'] ,
						'ImgUrl' => $receivedata['ImgUrl'] ,
						'ImgInformation' => $receivedata['ImgInformation'] ,
						'ImgInformation_en' => $receivedata['ImgInformation_en'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish']
					);

			$this -> db -> insert('speakers',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function Speakers_Update($id = false) {
			$receivedata = $this -> Check_Input_Fields();

			$data = array(
						'tabs_nhansu' => $receivedata['tabs_nhansu'] ,
						'FullName' => $receivedata['FullName'] ,
						'FullName_en' => $receivedata['FullName_en'] ,
						'Slug' => $receivedata['Slug'],
						'Description' => $receivedata['Description'] ,
						'Description_en' => $receivedata['Description_en'] ,
						'Position' => $receivedata['Position'],
						'Position_en' => $receivedata['Position_en'],
						'ImgUrl' => $receivedata['ImgUrl'] ,
						'ImgInformation' => $receivedata['ImgInformation'] ,
						'ImgInformation_en' => $receivedata['ImgInformation_en'] ,
						'Orders' => $receivedata['Orders'] ,
						'Publish' => (int)$receivedata['Publish']
					);

			$this -> db -> update('speakers',$data,array('Id' => $id));

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function  updateOrders() {

			$id = $this -> input -> post("id");
			$this -> input -> post("orders") ? ( is_numeric($this -> input -> post("orders")) ? $orders = $this -> input -> post("orders") : $orders = 999) : $orders = 999;
			if($id !== false && $orders !== false) {
				$data = array('Orders' => $orders );
				$this -> db -> update('speakers',$data,array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}
			return false;

		}

		public function updatePublish() {
			$id = $this -> input -> post('id');
			$this -> input -> post('publish') ? $publish = 1 : $publish = 0;
			if($id !== false && is_numeric($id)) {
				$data = array(	'Publish' => (int)$publish );

				$this -> db -> update('speakers',$data,array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}

			return false;
		}

		public function delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('speakers',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
			}

			return false;
		}
	}
?>