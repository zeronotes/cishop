<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Memberships_model extends Cms_Base_model {
		function __construct() {
			parent::__construct();
		}

		function validate() {
			$selectClause = " select UsersID, admin.RolesID,roles.Title as RolesTitle, Username,Passwords 
										from admin inner join roles on roles.RolesID = admin.RolesID where Username = ? and Passwords = ?";
			
			$password =  $this -> input -> post('password') ? $this -> input -> post('password') : "";
			$username =  $this -> input -> post('username') ? $this -> input -> post('username') : "";

			$query = $this -> db -> query($selectClause, array($username,$password));

			if($query->num_rows() == 1) {
				return $query;
			}

			return null;
		}

		function return_permissions($rolesid = false) {
			if($rolesid !== false) {
				$selectClause = " select * from permissions where RolesID = ? "; 

				$result = $this -> db -> query($selectClause, array($rolesid));

				return $result -> result_array();
			}
		}

		function update_last_logged($userid = false) {
			if($userid !== false) {
				$data = array("LastedLogin" => date('Y-m-d H:i:s', time()));
				$this -> db -> update("admin",$data,array("UsersID" => $userid));
				if($this -> db -> affected_rows() > 0)
					return true;
				return false;
			}
		}

		function change_password() {

			$oldpassword = $this -> input -> post('oldpassword');
			$newpassword = $this -> input -> post('password');
			$username = $this->session->userdata('username');

			$data = array("Passwords" => $newpassword);
			$this -> db -> update("admin",$data,array("Username" => $username,"Passwords" => $oldpassword));
			
			if($this -> db -> affected_rows() > 0)
				return true;
			return false;

		}
	}
?>