<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This class is the Cas controller.
* Every controller extends that one so that the cas client and certificates are always set
*/
class Cas extends CI_Controller {

	/**
	 * Create the cas client and set the certificate
	 * This allow the use of every cas function later
	 */
	function __construct(){
		parent::__construct();
		phpCAS::client(CAS_VERSION_2_0, 'websso.wwu.edu', 443, '/cas');
		//at the moment add the following line and comment out the two after that
		phpCAS::setCasServerCACert("application/config/CA_CAS_FILE.pem");
	}
}

/* End of file cas.php */
/* Location: ./application/controllers/cas.php */