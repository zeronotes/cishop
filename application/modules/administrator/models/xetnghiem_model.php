<?php
	class Xetnghiem_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		public function getAll($limit_start=false,$limit_show=false,$whereClause = ' 1 = 1 ') {
			$selectClause = " select Id,ma_xet_nghiem,ho_ten,anh_xet_nghiem,attachment_file,DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate
						from xetnghiem where ".$whereClause." order by CreatedDate desc limit ?,? ";

			$result = $this -> db -> query($selectClause,array($limit_start,$limit_show));

			if($result -> num_rows() > 0) {
				return $result -> result_array();
			}
			return array();
		}

		public function getCount($whereClause = ' 1 = 1 '){
			$selectClause = " select count(Id) as count from xetnghiem where ".$whereClause;

			$result = $this -> db -> query($selectClause);

			return $result -> row_array();
		}

		public function getById($id = false){
			$selectClause = " select Id,ma_xet_nghiem,attachment_file,anh_xet_nghiem,ho_ten,dia_chi,so_dien_thoai,email,
								DATE_FORMAT(ModifiedDate,'%T %m-%d-%Y') as ModifiedDate,
								DATE_FORMAT(CreatedDate,'%T %m-%d-%Y') as CreatedDate,
								 (select Username from admin where UsersID = xetnghiem.CreatedBy) as CreatedBy,
						            (select Username from admin where UsersID = xetnghiem.ModifiedBy) as ModifiedBy
						            from xetnghiem where Id = ? ";

			$result = $this -> db -> query($selectClause,array($id));

			if($result -> num_rows() > 0) {
				return $result -> row_array();
			}
			return false;
		}

		private function check_fields_input() {

			$this -> input -> post('ma_xet_nghiem') ? $ma_xet_nghiem = $this -> input -> post('ma_xet_nghiem') : $ma_xet_nghiem = "";
			$this -> input -> post('attachment_file') ? $attachment_file = $this -> input -> post('attachment_file') : $attachment_file = '';
			$this -> input -> post('anh_xet_nghiem') ? $anh_xet_nghiem = $this -> input -> post('anh_xet_nghiem') : $anh_xet_nghiem = "";
			$this -> input -> post('ho_ten') ? $ho_ten = $this -> input -> post('ho_ten') : $ho_ten = "";
			$this -> input -> post('dia_chi') ? $dia_chi = $this -> input -> post('dia_chi') : $dia_chi = "";
			$this -> input -> post('so_dien_thoai') ? $so_dien_thoai = $this -> input -> post('so_dien_thoai') : $so_dien_thoai = "";
			$this -> input -> post('email') ? $email = $this -> input -> post('email') : $email = "";

			$data = array(
						'ma_xet_nghiem' => $ma_xet_nghiem ,
						'attachment_file' => $attachment_file,
						'anh_xet_nghiem' => $anh_xet_nghiem,
						'ho_ten' => $ho_ten,
						'dia_chi' => $dia_chi,
						'so_dien_thoai' => $so_dien_thoai,
						'email' => $email
					);

			return $data;
		}

		public function insert() {
			$receivedata = $this -> check_fields_input();

			$data = array(
						'ma_xet_nghiem' => $receivedata['ma_xet_nghiem'] ,
						'attachment_file' => $receivedata['attachment_file'] ,
						'anh_xet_nghiem' => $receivedata['anh_xet_nghiem'] ,
						'ho_ten' => $receivedata['ho_ten'] ,
						'dia_chi' => $receivedata['dia_chi'] ,
						'so_dien_thoai' => $receivedata['so_dien_thoai'] ,
						'email' => $receivedata['email'] ,
						'CreatedBy' => $this -> session -> userdata('userid')
					);
			$this -> db -> insert('xetnghiem',$data);

			if($this -> db -> affected_rows() > 0)
				return true;
			return false;
		}

		public function update($id = false ) {
			if($id !== false) {
				$receivedata = $this -> check_fields_input();

				$data = array(
							'ma_xet_nghiem' => $receivedata['ma_xet_nghiem'] ,
							'attachment_file' => $receivedata['attachment_file'] ,
							'anh_xet_nghiem' => $receivedata['anh_xet_nghiem'] ,
							'ho_ten' => $receivedata['ho_ten'] ,
							'dia_chi' => $receivedata['dia_chi'] ,
							'so_dien_thoai' => $receivedata['so_dien_thoai'] ,
							'email' => $receivedata['email'] ,
							'ModifiedBy' => $this -> session -> userdata('userid'),
							'ModifiedDate' => date('Y-m-d H:i:s', time())
						);
				return $this -> db -> update('xetnghiem',$data,array('Id' => $id));
			}else {
				show_404();
			}
		}

		public function delete($id = false) {
			if($id !== false) {
				$this -> db -> delete('xetnghiem',array('Id' => $id));

				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}else {
				show_404();
			}
		}
	}
?>