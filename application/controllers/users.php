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
		if($wUser){
			$this->session->set_userdata('user', $wUser);
			header("Location: ".base_url());
		}else{
			$this->load->model('user', 'user');
			$wUser = null;
			$wUser = new $this->user;
			$wUser->setUsername(phpCAS::getUser());
			$wUser->setEmail('');
			$wUser->setFirstname('');
			$wUser->setLastName('');
			$wUser->save($this->db);

			$wRequest = $this->db->prepare("INSERT INTO UserRoles(user_id,role_id) VALUES(:user_id, 3)");
			$wRequest->bindParam(":user_id", $wUser->getId(), PDO::PARAM_INT);
			$wRequest->execute();			

			$wUser = $this->userFactory->getUserByUsername($this->db, phpCAS::getUser());
			$this->session->set_userdata('user', $wUser);
			header("Location: ".base_url());
		}
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
