<?php

/**
 * This class is the model used to handle QuizSessions. The class contains the factory
 * functions needed to create QuizSessions.
 */

Class QuizSession {

	private $id;
	private $quiz_id;
	private $user_id;
	private $date_begin;
	private $status;
	private $question;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->id;
		$var['quiz_id'] = (int)$this->quiz_id;
		$var['user_id'] = (int)$this->user_id;
		$var['date_begin'] = (string)$this->date_begin;
		$var['status'] = (int)$this->status;
		$var['question'] = (int)$this->question;

		return json_encode($var);
	}

	/**
	 * getId 
	 * getter of QuizSession id
	 *
	 * @return an integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getQuizId
	 * getter of Quiz id
	 *
	 * @return an integer
	 */
	public function getQuizId(){
		return $this->quiz_id;
	}

	/** 
	 * getUserId
	 * getter of User id
	 *
	 * @return an integer
	 */
	public function getUserId() {
		return $this->user_id;
	}

	/**
	 * getDateBegin
	 * getter of begin date
	 *
	 * @return a date string formatted "Y-m-d"
	 */
	public function getDateBegin(){
		return $this->date_begin;
	}

	/**
	 * getStatus
	 * getter of status
	 *
	 * @return an integer
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * getQuestion
	 *
	 * getter of Question
	 * @return an integer
	 */
	public function getQuestion(){
		return $this->question;
	}

	/**
	 * setId 
	 * setter of QuizSession id
	 *
	 * @param am integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setName
	 * setter of Quiz id
	 *
	 * @param an integer
	 */
	public function setQuizId($aQuizId){
		$this->quiz_id = $aQuizId;
	}

	/**
	 * setUserId
	 * setter of User id
	 *
	 * @param an integer
	 */
	public function setUserId($aUserId){
		$this->user_id = $aUserId;
	}

	/**
	 * setDateBegin
	 * setter of begin date
	 *
	 * @param a date string formatted "Y-m-d"
	 */
	public function setDateBegin($aDateBegin){
		$this->date_begin = $aDateBegin;
	}

	/**
	 * setStatus
	 * setter of status
	 *
	 * @param an integer
	 */
	public function setStatus($aStatus){
		$this->status = $aStatus;
	}

	/**
	 * setQuestion
	 * setter of Question
	 *
	 * @param an integer
	 */
	public function setQuestion($aQuestion) {
		$this->question = $aQuestion;
	}

	/**
	 * save
	 * Saves or updates a QuizSession in the database
	 * PDO object db
	 *
	 * @param  $db2  The database	 
	 */
	public function save($db) {
		$wRequest = $db->prepare("INSERT INTO QuizSessions (id,quiz_id,user_id,date_begin,status,question)
		VALUES (:id,:quiz_id,:user_id,:date_begin,:status,:question)
		ON DUPLICATE KEY UPDATE quiz_id=:quiz_id, user_id=:user_id, date_begin=:date_begin, status=:status, question=:question");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":quiz_id", $this->quiz_id,PDO::PARAM_INT);
		$wRequest->bindParam(":user_id", $this->user_id,PDO::PARAM_INT);
		$wRequest->bindParam(":date_begin", $this->date_begin,PDO::PARAM_STR);
		$wRequest->bindParam(":status", $this->status,PDO::PARAM_INT);
		$wRequest->bindParam(":question", $this->question,PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * getQuizSessionById
	 * Returns a QuizSession object that is found using the given id and
	 * PDO object db
	 *
	 * @param  $db2  The database	 
	 * @param  $aId  The id of the QuizSession
	 * @return  a QuizSession object
	 */
	public static function getQuizSessionById($db, $aId){
		$wRequest = $db->prepare("Select id,quiz_id,user_id,date_begin,status,question FROM QuizSessions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wQuizSession = $wRequest->fetchObject("QuizSession");
		return $wQuizSession;
	}

	/**
	 * delete
	 * Deletes a QuizSession that is found using the given QuizSession id and
	 * PDO object db
	 * 
	 * @param  $db2  The database	 
	 * @param  $aId  The id of the QuizSession
	 */
	public static function delete($db, $aId){
		$wRequest = $db->prepare("Delete FROM QuizSessions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
	}
}

?>