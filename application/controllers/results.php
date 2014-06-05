<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "BaseController.php";
/*
 * This class is the Results controller.
 * This controller is found at the URI '/results'
 */
class Results extends BaseController {

	function __construct(){
		parent::__construct();
		$this->load->model('Quiz', 'quiz');
		$this->load->model('Quizsession', 'quizsession');
		$this->load->model('Course', 'course');
		$this->load->model('UserAnswer', 'course');
	}

	/**
	 * quiz
	 * This function is called to display results of a quizz
	 */
	public function quiz($aQuizId) {
		if(!isset($aQuizId)){
			show_404();
		}
		
		$aSessionNumber = 0;
		
		$wData['wQuiz'] = Quiz::getQuizById($this->db, $aQuizId);
		$wData['wCourse'] = Course::getCourseById($this->db, $wData['wQuiz']->getCourseId());
		$wSessions = Quizsession::getQuizSessionsByQuizId($this->db, $aQuizId);
		if($wSessions != null){
			$wData['wSessions'] = $wSessions;

		$wRequest = $this->db->prepare('SELECT MAX(number) AS "max" FROM Questions where quiz_id=:quiz_id;');
		$wRequest->bindParam(":quiz_id", $aQuizId, PDO::PARAM_INT);
		$wRequest->execute();
		$wQuestionMax = $wRequest->fetch()['max'];
		$wData['wQuestionMax'] = $wQuestionMax;

		$wResults;
		foreach ($wSessions as $wSession) {
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
				$wQuestionId = $wRequest->fetch()['id'];

				// get how many correct answers
				$wRequest = $this->db->prepare('SELECT COUNT(*) as "count" FROM Answers A JOIN UserAnswers U ON A.id=U.answer_id JOIN UserQuestions V ON U.userquestion_id=V.id JOIN Questions Q ON V.question_id=Q.id WHERE Q.id=:id AND A.correct=1;');
				$wRequest->bindParam(":id", $wQuestionId, PDO::PARAM_STR);
				$wRequest->execute();
				$wResults[$wSessionId][$wI]['correct'] = $wRequest->fetch()['count'];

				// get how many incorrect answers
				$wRequest = $this->db->prepare('SELECT COUNT(*) as "count"  
													FROM Answers A 
													JOIN UserAnswers U ON A.id=U.answer_id 
													JOIN UserQuestions V ON U.userquestion_id=V.id 
													JOIN Questions Q ON V.question_id=Q.id 
													WHERE Q.id=:id AND A.correct=0;');
				$wRequest->bindParam(":id", $wQuestionId, PDO::PARAM_STR);
				$wRequest->execute();
				$wResults[$wSessionId][$wI]['incorrect'] = $wRequest->fetch()['count'];
			}
		}

		$wData['wResults'] = $wResults;
		//var_dump($wData);
		$this->load->view('results', $wData);
		}
	}
}

/* End of file results.php */
/* Location: ./application/controllers/results.php */
