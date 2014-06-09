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
	// status of a session :
	// 0 : finished, results available
	// 1 : in progress, results not available
	// 2 : paused, results not available

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
	 * save
	 * Saves or updates a QuizSession in the database
	 * PDO object db
	 *
	 * @param  $db The database	 
	 */
	public function save($db) {
		$wRequest = $db->prepare("INSERT INTO QuizSessions (id,quiz_id,user_id,date_begin,status)
		VALUES (:id,:quiz_id,:user_id,:date_begin,:status)
		ON DUPLICATE KEY UPDATE quiz_id=:quiz_id, user_id=:user_id, date_begin=:date_begin, status=:status");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":quiz_id", $this->quiz_id,PDO::PARAM_INT);
		$wRequest->bindParam(":user_id", $this->user_id,PDO::PARAM_INT);
		$wRequest->bindParam(":date_begin", $this->date_begin,PDO::PARAM_STR);
		$wRequest->bindParam(":status", $this->status,PDO::PARAM_INT);
		$wRequest->execute();

		// 
		// get the id and set it
		$wNewId = $db->lastInsertId();
		if($wNewId != 0){
			$this->setId($wNewId);
		}
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
		$wRequest = $db->prepare("Select id,quiz_id,user_id,date_begin,status FROM QuizSessions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wQuizSession = $wRequest->fetchObject("QuizSession");
		return $wQuizSession;
	}

	/**
	 * getQuizSessionsByUserId
	 * Returns a QuizSession object that is found using the given id and
	 * PDO object db
	 *
	 * @param  $db2  The database	 
	 * @param  $aId  The id of the QuizSession
	 * @return  a QuizSession object
	 */
	public static function getQuizSessionsByUserId($db, $aUserId){
		$wRequest = $db->prepare("Select id,quiz_id,user_id,date_begin,status FROM QuizSessions WHERE user_id=:user_id AND status>0;");
		$wRequest->bindParam(":user_id", $aUserId);
		$wRequest->execute();
		$wQuizSessions = NULL;
		while($wQuizSession = $wRequest->fetchObject("QuizSession")){
			$wQuizSessions[] = $wQuizSession;
		}
		return $wQuizSessions;
	}

	/**
	 * getQuizSessionsByQuizId
	 * Returns a QuizSession object that is found using the given quiz id and
	 * PDO object db
	 *
	 * @param  $db2  The database	 
	 * @param  $aId  The id of the QuizSession
	 * @return  a QuizSession object
	 */
	public static function getQuizSessionsByQuizId($db, $aQuizId){
		$wRequest = $db->prepare("Select id,quiz_id,user_id,date_begin,status FROM QuizSessions WHERE quiz_id=:quiz_id;");
		$wRequest->bindParam(":quiz_id", $aQuizId);
		$wRequest->execute();
		$wQuizSessions = NULL;
		while($wQuizSession = $wRequest->fetchObject("QuizSession")){
			$wQuizSessions[] = $wQuizSession;
		}
		return $wQuizSessions;
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
