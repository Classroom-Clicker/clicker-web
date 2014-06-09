<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";

/*
 * This class is the Welcome controller.
 * This controller is found at the URI '/' and '/welcome'
 */
class Welcome extends BaseController {

	function __construct(){
		parent::__construct();
		$this->load->model('userfactory', 'userfactory');
		$this->load->model('quiz', 'quiz');
		$this->load->model('quizsession', 'quizSession');
	}

	public function index() {
		if(phpCas::isAuthenticated()) {
			// If user is logged in
			$user = $this->session->userdata('user');
			$quizzes = $this->quiz->getQuizzesByUserId($this->db, $user->getId());
			$sessions = $this->quizSession->getQuizSessionsByUserId($this->db, $user->getId());
			// get quizzes in progress here

			$quizIds = array();
			$quizNames = array();
			$sessionsId = array();

			foreach ($quizzes as $quiz) {
				array_push($quizIds, $quiz->getId());
				array_push($quizNames, $quiz->getName());
			}
			foreach ($sessions as $session) {
				array_push($sessionsId, $session->getId());
			}

			$data['quizIds'] = $quizIds;
			$data['quizNames'] = $quizNames;
			$data['stuff'] = $quizzes;
			$data['sessions'] = $sessions;
			$data['sessionsId'] = $sessionsId;

			$this->load->view('quizzes', $data);
		} else {
			// If user is not logged in
			$this->load->view('welcome');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
