<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "cas.php";
/*
 * This class is the Welcome controller.
 * This controller is found at the URI '/' and '/welcome'
 */
class Welcome extends Cas {

	function __construct(){
		parent::__construct();
	}

	public function index() {
		$this->load->view('welcome');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */