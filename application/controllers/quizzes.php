<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";

/*
 * This class is the Quizzes controller.
 * This controller is found at the URI '/quizzes'
 */
class Quizzes extends BaseController {

	function __construct() {
		parent::__construct();
		$this->load->model('userfactory', 'userfactory');
		$this->load->model('quiz', 'quiz');
	}

	public function index() {
		if(phpCas::isAuthenticated()) {
			// If user is logged in
			$user = $this->session->userdata('user');
			$quizzes = $this->quiz->getQuizzesByUserId($this->db, $user->getId());

			$quizIds = array();
			$quizNames = array();

			foreach ($quizzes as $quiz) {
				array_push($quizIds, $quiz->getId());
				array_push($quizNames, $quiz->getName());
			}

			$data['quizIds'] = $quizIds;
			$data['quizNames'] = $quizNames;
			$data['stuff'] = $quizzes;

			$this->load->view('quizzes', $data);
		} else {
			// If user is not logged in
			$this->load->view('welcome');
		}
	}
}

/* End of file quizzes.php */
/* Location: ./application/controllers/quizzes.php */