<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Adminlogin extends CMS_BaseController {
		function __construct() {
			parent::__construct();
		}

		function index() {
			$this -> is_logged_in();
			if(!isset($_Post['username']) && !isset($_Post['password'])) {
				$this -> loging();
			}else {
				$this -> load -> view('login_form');
			}
		}	

		function loging() {
			$this -> is_logged_in();
			$this -> form_validation -> set_rules('username','Username','trim|required');
			
			$this -> form_validation -> set_rules('password','Password','trim|required');

			if(!$this -> form_validation -> run()) {
				$this -> load -> view('login_form');
			}else {
				$this -> load -> model('memberships_model');
				$query = $this -> memberships_model -> validate();

				if($query != null) {
					$result_array = $query -> result_array();

					// $permissions_list = $this -> memberships_model -> return_permissions($result_array[0]['RolesID']);

					$data = array('username' => $result_array[0]['Username'],
								'userid' => $result_array[0]['UsersID'],
								'role' => $result_array[0]['RolesTitle'],
								'roleid' => $result_array[0]['RolesID'],
								// 'permissions' => $permissions_list,
								'is_logged_in' => true
							);

					$this -> memberships_model -> update_last_logged($result_array[0]['UsersID']);
					$this -> session -> set_userdata($data);

					$_SESSION['KCFINDER'] = array(); 
					$_SESSION['KCFINDER']['disabled'] = false;

					// check oldurl if exist server will redirect to oldurl
					$oldurl = $this -> session -> userdata('oldurl');
					if($oldurl !== false) {
						// unset before redirect
						$this -> session -> unset_userdata('oldurl');
						redirect($oldurl);
					}
					redirect(base_url().'administrator');
					
				}else {
					$data['fail'] = "Username or password invalid!";
					$this -> load -> view('login_form',$data);
				}
			}
		}

		function logout() {
			$this -> session -> sess_destroy();
			redirect(base_url().'administrator/login');
		}

		function is_logged_in() {
        	$is_logged_in = $this -> session -> userdata('is_logged_in');

        	if(isset($is_logged_in) && $is_logged_in) {
        		redirect(base_url().'administrator');
        	}
		}
	}
?>