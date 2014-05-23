<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "BaseController.php";
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
		header("Location: ".base_url());
	}

	/**
	 * Logout 
	 * This function is called when the user needs to logout
	 */
	public function logout() {
		phpCAS::logout();
		header("Location: ".base_url());
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
