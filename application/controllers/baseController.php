<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This class is the BaseController controller.
* Every controller extends that one so that the database, the cas client and certificates are always set
*/
class BaseController extends CI_Controller {

	/**
	 * Create the cas client and set the certificate
	 * This allow the use of every cas function later
	 */
	function __construct(){
		parent::__construct();
		// load the database config
		include APPPATH.'config/database'.EXT;
		// create the database
		try{
			//to connect
			$this->db = new PDO($db['default']['dbdriver'].':host='.$db['default']['hostname'].'; dbname='.$db['default']['database'], $db['default']['username'], $db['default']['password']);
		} catch(PDOException $e) {
			echo 'Please contact Admin: '.$e->getMessage();
		}
		phpCAS::client(CAS_VERSION_2_0, 'websso.wwu.edu', 443, '/cas');
		//at the moment add the following line and comment out the two after that
		phpCAS::setCasServerCACert("application/config/CA_CAS_FILE.pem");
	}
}

/* End of file baseController.php */
/* Location: ./application/controllers/baseController.php */