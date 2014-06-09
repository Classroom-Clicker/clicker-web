<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";
/*
 * This class is the Quizzes controller.
 * This controller is found at the URI '/quizzes'
 */
class Quizzes extends BaseController {

	function __construct(){
		parent::__construct();
		$this->load->model('Question','question');
		$this->load->model('Answer',"answer");
		$this->load->model('Quiz','quiz');
	}

	public function edit($aQuizId) {
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');

			$data['quiz_id'] = $aQuizId;
			if($aQuizId != 'null'){
				$wQuiz = $this->quiz->getQuizById($this->db,$aQuizId);
				//TODO super basic permission check should be updated to our permissions system
				if($currentUser->getId() != $wQuiz->getUserId()){
					redirect('/', 'refresh');
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
			redirect('/', 'refresh');
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
			while($i < $numAnswers){
					$answer = new Answer();
					$answer->setId(null);
					$answer->setQuestionId(intval($question->getId(),10));
					$answer->setNumber($i+1);
					$answer->setValue($this->input->post('text'.$i));
					$radio = $this->input->post('answer'.$i);
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
			redirect('/', 'refresh');
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
	
			$this->question->delete($this->db,$aId);
			redirect('/quizzes/edit/'.$aQuizId, 'refresh');
		}
		else{
			redirect('/', 'refresh');
		}

	}
}
/* End of file quizzes.php */
/* Location: ./application/controllers/quizzes.php */
