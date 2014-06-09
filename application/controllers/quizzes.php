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
		$this->load->model('question','question');
		$this->load->model('answer',"answer");
	}	

	public function edit($aQuizId) {
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');

			$data['quiz_id'] = $aQuizId;
			if($aQuizId != 'null'){
				$wQuiz = $this->quiz->getQuizById($this->db,$aQuizId);
				//TODO super basic permission check should be updated to our permissions system
				if($currentUser->getId() != $wQuiz->getUserId()){
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}

				$data['quiz_name'] = $wQuiz->getName();
			}
			else{
				$data['quiz_name'] = "";
			}
			$questions = $this->question->getQuestionsByQuizId($this->db,$aQuizId);
			$qCount = count($questions);
			$data['count'] = $qCount;
			$data['questions'] = $questions;
			$this->load->view('edit_quiz',$data);
		}
		else{
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function save($aQuestionId,$aNumber,$aQuizId){
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');
			if($aQuizId != 'null'){
				$quiz = $this->quiz->getQuizById($this->db,$aQuizId);
				//TODO super basic permission check should be updated to our permissions system
				if($currentUser->getId() != $quiz->getUserId()){
					redirect('/', 'refresh');
				}
				$quizName = $this->input->post('quizName');
				if($quiz->getName() != $quizName){
					$quiz->setName($quizName);
					$quiz->save($this->db);
				}
			}
			else{
				$quiz = new Quiz();
				$quiz->setId(null);
				$quiz->setName($this->input->post('quizName'));
				$quiz->setCourseId(1);
				$quiz->setParentQuiz(null);
				$quiz->setUserId($currentUser->getId());
				$quiz->save($this->db);
				$aQuizId = $quiz->getId();
				var_dump($quiz);
			}

			$question = new Question();
			$question->setId($aQuestionId);
			$question->setNumber($aNumber);
			$question->setQuizId($aQuizId);
			$question->setType(1);
			$question->setQuestion($this->input->post('question'));
			$question->save($this->db);
			$question->getId();

			$numAnswers = 6;
			$i = 0;
			$radio = $this->input->post('answer');
			while($i < $numAnswers){
					$answer = new Answer();
					$answer->setId(null);
					$answer->setQuestionId(intval($question->getId(),10));
					$answer->setNumber($i+1);
					$answer->setValue($this->input->post('text'.$i));
					
					if(isset($radio) and $radio == $i){
						$answer->setCorrect(1);
					}
					else{
						$answer->setCorrect(0);
					}
					if($this->input->post('text'.$i) != '' and $this->input->post('text'.$i) != ' '){
						$answer->save($this->db);
					}
					else{
						$this->answer->deleteByNumber($this->db,$answer->getNumber(),$answer->getQuestionId());
					}
					$i += 1;
			}
			redirect('/quizzes/edit/'.$aQuizId, 'refresh');
		}
		else{
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function deleteQuestion($aId,$aQuizId){
		//TODO add proper permissions
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');
			if($aQuizId != 'null'){
				$quiz = $this->quiz->getQuizById($this->db,$aQuizId);
				//TODO super basic permission check should be updated to our permissions system
				if($currentUser->getId() != $quiz->getUserId()){
					redirect('/', 'refresh');
				}
			}
			$this->question->delete($this->db, $aId);
			redirect('/quizzes/edit/'.$aQuizId, 'refresh');
		}
		else{
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function sessionStart($aQuizId){
		// TODO add proper permissions
		if(phpCas::isAuthenticated()){
			$wCurrentUser = $this->session->userdata('user');
			//if($wCurrentUser->isAllowed('start_quizz', $aQuizId)){ // allowed}
			// load Sessions
			$this->load->model('quizSession','quizSession');
			date_default_timezone_set('UTC');

			$wSession = new QuizSession();
			$wSession->setQuizId($aQuizId);
			$wSession->setUserId($wCurrentUser->getId());
			$wSession->setDateBegin(date('Y-m-d'));
			$wSession->setStatus(1);

			$wSession->save($this->db);

			redirect('/quizzes/session/'.$wSession->getId(), 'refresh');
		}
		else{
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function session($aSessionId){
		$this->load->model('quizSession','quizSession');

		if(phpCas::isAuthenticated()){
			$wCurrentUser = $this->session->userdata('user');
			$wSession =QuizSession::getQuizSessionById($this->db, $aSessionId);	
			if($wSession && $wCurrentUser->getId() == $wSession->getUserId()){
				if($wSession->getStatus() != 0){
					$wData['wQuizSession'] = $wSession;
					$this->load->view('prof_view_quiz',$wData);
				} else {
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}else {
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
		}else {
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function sessionChangeStatus($aSessionId, $aNewStatus){
		$this->load->model('quizSession','quizSession');

		if(phpCas::isAuthenticated()){
			$wCurrentUser = $this->session->userdata('user');
			$wSession =QuizSession::getQuizSessionById($this->db, $aSessionId);	
			
			if($wSession && $wCurrentUser->getId() == $wSession->getUserId()){
				$wSession->setStatus($aNewStatus);
				$wSession->save($this->db);
				if($aNewStatus == 0){
					redirect('/', 'refresh');
				}else{
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			} else {
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
		} else {
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}


}
/* End of file quizzes.php */
/* Location: ./application/controllers/quizzes.php */
