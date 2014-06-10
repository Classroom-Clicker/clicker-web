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

	public function question($aSessionId, $aQuestionNumber){
		if(!isset($aQuestionNumber)){
			show_404();
		}

		$this->load->model('question', 'question');
		$this->load->model('answer', 'answer');

		$wSession = Quizsession::getQuizSessionById($this->db, $aSessionId);
		$wQuestion = Question::getQuestionByNumber($this->db, $aQuestionNumber, $wSession->getQuizId());

		if($wQuestion != null){
			$wAnswers = $wQuestion->getAnswers($this->db);
			$wI = 0;
			$wTotalCount = 0;
			foreach ($wAnswers as $wAnswer) {
				$wI++;
				$wRequest = $this->db->prepare('SELECT U.username FROM Answers A JOIN UserAnswers B ON A.id=B.answer_id JOIN UserQuestions C ON B.userquestion_id=C.id JOIN Users U ON C.user_id=U.id WHERE C.question_id=:question_id AND A.id=:answer_id AND C.quizsession_id=:quizsession_id ORDER BY U.username;');
				$wRequest->bindParam(":question_id", $wAnswer->getQuestionId(), PDO::PARAM_INT);
				$wRequest->bindParam(":quizsession_id", $aSessionId, PDO::PARAM_INT);
				$wRequest->bindParam(":answer_id", $wAnswer->getId(), PDO::PARAM_INT);
				$wRequest->execute();
				$wCount = 0;
				while($wResponse = $wRequest->fetch()){
					$wData['wUserAnswers'][$wI]['users'][] = $wResponse['username'];
					$wCount++;
				}
				$wData['wUserAnswers'][$wI]['count'] = $wCount;
				$wTotalCount += $wCount;
			}
			
			$wData['wUserAnswers']['count'] = $wTotalCount;
			$wData["wQuestion"] = $wQuestion;
			$wData["wAnswers"] = $wAnswers;
			$this->load->view('results_details', $wData);
		}else{
			// no results to display
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}

	public function deleteSession($aSessionId){
		// TODO real permission check
		$wQuiz = quizSession::getQuizSessionsById($this->db, $aSessionId);
		if(phpCas::isAuthenticated()){
			$currentUser = $this->session->userdata('user');
			if($currentUser->getId() != $wQuiz->getUserId()){
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
		}

		$this->quizSession->delete($this->db, $aSessionId);
		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}
}

/* End of file results.php */
/* Location: ./application/controllers/results.php */
