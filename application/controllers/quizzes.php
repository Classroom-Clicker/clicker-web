<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "baseController.php";
/*
 * This class is the Quizzes controller.
 * This controller is found at the URI '/quizzes'
 */
class Quizzes extends BaseController {

	function __construct(){
		parent::__construct();
		$this->load->model('Question','question');
		$this->load->model('Answer',"answer");
	}

	public function edit($aQuizId) {
		$data['quiz_id'] = $aQuizId;
		$questions = $this->question->getQuestionsByQuizId($this->db,$aQuizId);
		$qCount = count($questions);
		$data['count'] = $qCount;
		for($i = 0; $i<$qCount; $i++){
			$answers = $this->question->getAnswers($this->db,$questions[$i]);
		}
		$data['questions'] = $questions;
		$this->load->view('edit_quiz',$data);
	}

	public function save($aQuestionId,$aNumber,$aQuizId){
		$question = new Question();
		$question->setId($aQuestionId);
		$question->setNumber($aNumber);
		$question->setQuizId($aQuizId);
		$question->setType(1);
		$question->setQuestion($this->input->post('question'));
		$question->save($this->db);
		//var_dump($question); 
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
					//print 'The problem is in the model';
					//var_dump($answer);
					$this->answer->deleteByNumber($this->db,$answer->getNumber(),$answer->getQuestionId());
				}
				$i += 1;
		}
		$this->edit($aQuizId);
	}

	public function deleteQuestion($aId){
		$this->question->delete($this->db,$aId);
	}
}

/* End of file quizzes.php */
/* Location: ./application/controllers/quizzes.php */
