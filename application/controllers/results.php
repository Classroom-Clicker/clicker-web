<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "basecontroller.php";
/*
 * This class is the Results controller.
 * This controller is found at the URI '/results'
 */
class Results extends BaseController {

	function __construct(){
		parent::__construct();
		$this->load->model('quiz', 'quiz');
		$this->load->model('quizsession', 'quizSession');
		$this->load->model('useranswer', 'course');
	}

	/**
	 * quiz
	 * This function is called to display results of a quizz
	 */
	public function quiz($aQuizId) {
		if(!isset($aQuizId)){
			show_404();
		}
		// TODO real permission check
		$wQuiz = Quiz::getQuizById($this->db, $aQuizId);
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');
			if($currentUser->getId() != $wQuiz->getUserId()){
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
		}


		$wData['wQuiz'] = $wQuiz;
		$wSessions = Quizsession::getQuizSessionsByQuizId($this->db, $aQuizId);
		if($wSessions != null){
			$wData['wSessions'] = $wSessions;

			$wRequest = $this->db->prepare('SELECT MAX(number) AS "max" FROM Questions where quiz_id=:quiz_id;');
			$wRequest->bindParam(":quiz_id", $aQuizId, PDO::PARAM_INT);
			$wRequest->execute();
			$wReponse = $wRequest->fetch();
			$wQuestionMax = $wReponse['max'];
			$wData['wQuestionMax'] = $wQuestionMax;

			$wResults;
			foreach ($wSessions as $wSession) {
				if($wSession->getStatus() == 0){
					$wSessionId = $wSession->getId();
					$wResults[$wSessionId]['id'] = $wSessionId;
					$wResults[$wSessionId]['max'] = $wQuestionMax;
					$wResults[$wSessionId]['date'] = $wSession->getDateBegin();
					for($wI = 1; $wI <= $wQuestionMax; $wI++){

						// get the question id
						$wRequest = $this->db->prepare('SELECT Q.id FROM Questions Q JOIN Quizzes Z ON Z.id=Q.quiz_id WHERE Z.id=:id AND Q.number=:number;');
						$wRequest->bindParam(":id", $aQuizId, PDO::PARAM_INT);
						$wRequest->bindParam(":number", $wI, PDO::PARAM_INT);
						$wRequest->execute();
						$wResponse = $wRequest->fetch();
						$wQuestionId = $wResponse['id'];

						// get how many correct answers
						$wRequest = $this->db->prepare('SELECT COUNT(*) as "count" FROM Answers A JOIN UserAnswers U ON A.id=U.answer_id JOIN UserQuestions V ON U.userquestion_id=V.id JOIN Questions Q ON V.question_id=Q.id WHERE Q.id=:id AND V.quizsession_id=:quizsession_id AND A.correct=1;');
						$wRequest->bindParam(":id", $wQuestionId, PDO::PARAM_INT);
						$wRequest->bindParam(":quizsession_id", $wSessionId, PDO::PARAM_INT);
						$wRequest->execute();
						$wResponse = $wRequest->fetch();
						$wResults[$wSessionId][$wI]['correct'] = $wResponse['count'];

						// get how many incorrect answers
						$wRequest = $this->db->prepare('SELECT COUNT(*) as "count" FROM Answers A JOIN UserAnswers U ON A.id=U.answer_id JOIN UserQuestions V ON U.userquestion_id=V.id JOIN Questions Q ON V.question_id=Q.id WHERE Q.id=:id AND V.quizsession_id=:quizsession_id AND A.correct=0;');
						$wRequest->bindParam(":id", $wQuestionId, PDO::PARAM_INT);
						$wRequest->bindParam(":quizsession_id", $wSessionId, PDO::PARAM_INT);
						$wRequest->execute();
						$wResponse = $wRequest->fetch();
						$wResults[$wSessionId][$wI]['incorrect'] = $wResponse['count'];
					}
				}
			}
			$wData['wResults'] = $wResults;
			$this->load->view('results', $wData);
		}else{
			// no results to display
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function deleteSession($aSessionId){
		// TODO permission check
		$this->quizSession->delete($this->db, $aSessionId);
		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}
}

/* End of file results.php */
/* Location: ./application/controllers/results.php */
