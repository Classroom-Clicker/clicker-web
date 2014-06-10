<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";
/**
 * This class is the User controller.
 */
class Users extends BaseController {

	/**
	 *
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * Login
	 * This function is called when the user needs to login
	 */
	public function login() {
		phpCAS::forceAuthentication();

		$wUser = $this->userFactory->getUserByUsername($this->db, phpCAS::getUser());
		$this->session->set_userdata('user', $wUser);
		header("Location: ".base_url());
	}

	/**
	 * Logout 
	 * This function is called when the user needs to logout
	 */
	public function logout() {
		$this->session->sess_destroy();
		phpCAS::logout();
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
