<?php

/**
 * This class is the model used to handle Quizzes. The class contains the factory
 * functions needed to create Quizzes.
 */

Class Quiz extends CI_Model{

	private $id;
	private $name;
	private $course_id;
	private $parentquiz;
	private $user_id;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->id;
		$var['name'] = (String)$this->name;
		$var['course_id'] = (int)$this->course_id;
		$var['parentquiz'] = (int)$this->parentquiz;
		$var['user_id'] = (int)$this->user_id;

		return json_encode($var);
	}

	/**
	 * getId 
	 * getter of Quiz id
	 *
	 * @return an integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getName
	 * getter of Quiz name
	 *
	 * @return a string
	 */
	public function getName(){
		return $this->name;
	}

	/** 
	 * getCourseId
	 * getter of Course id
	 *
	 * @return an integer
	 */
	public function getCourseId() {
		return $this->course_id;
	}

	/**
	 * getParentQuiz 
	 * getter of parent Quiz id
	 *
	 * @return an integer
	 */
	public function getParentQuiz(){
		return $this->parentquiz;
	}

	/**
	 * getUserId
	 * getter of User id
	 *
	 * @return an integer
	 */
	public function getUserId(){
		return $this->user_id;
	}

	/**
	 * setId 
	 * setter of Quiz id
	 *
	 * @param a integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setName
	 * setter of Quiz name
	 *
	 * @param a String
	 */
	public function setName($aName){
		$this->name = $aName;
	}

	/**
	 * setCourseId
	 * setter of Course id
	 *
	 * @param an integer
	 */
	public function setCourseId($aCourseId){
		$this->course_id = $aCourseId;
	}

	/**
	 * setParentQuiz 
	 * setter of parent Quiz
	 *
	 * @param an integer
	 */
	public function setParentQuiz($aParentQuiz){
		$this->parentquiz = $aParentQuiz;
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
	 * save
	 * Saves or updates a Quiz in the database
	 * PDO object db
	 *
	 * @param  $db2  The database
	 */
	public function save($db){
		$wRequest = $db->prepare("INSERT INTO Quizzes (id,name,course_id,parentquiz,user_id)
		VALUES (:id,:name,:course_id,:parentquiz,:user_id)
		ON DUPLICATE KEY UPDATE name=:name, course_id=:course_id, parentquiz=:parentquiz, user_id=:user_id");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":name", $this->name,PDO::PARAM_STR);
		$wRequest->bindParam(":course_id", $this->course_id,PDO::PARAM_INT);
		$wRequest->bindParam(":parentquiz", $this->parentquiz,PDO::PARAM_INT);
		$wRequest->bindParam(":user_id", $this->user_id,PDO::PARAM_INT);
		$wRequest->execute();
		$tempId = $db->lastInsertId();
		if($tempId != 0){
			$this->id = $tempId;
		}
	}

	/**
	 * getQuizById
	 * Returns a Quiz object that is found using the given id and
	 * PDO object db
	 *
	 * @param  $db2  The database	 
	 * @param  $aId  The id of the quiz
	 * @return  a Quiz object
	 */
	public static function getQuizById($db, $aId){
		$wRequest = $db->prepare("Select id,name,course_id,parentquiz,user_id FROM Quizzes WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wQuiz = $wRequest->fetchObject("Quiz");
		return $wQuiz;
	}

	public static function getQuizzesByUserId($db, $aId){
		$wRequest = $db->prepare("Select id,name,course_id,parentquiz,user_id FROM Quizzes WHERE user_id=:user_id;");
		$wRequest->bindParam(":user_id", $aId);
		$wRequest->execute();
		$wQuizzes = $wRequest->fetchAll(PDO::FETCH_CLASS,"Quiz");
		return $wQuizzes;

	}

	/**
	 * delete
	 * Deletes a Quiz that is found using the given Quiz id and
	 * PDO object db
	 * 
	 * @param  $db2  The database
	 * @param  $aId  The id of the Quiz
	 */
	public static function delete($db, $aId){
		$wRequest = $db->prepare("Delete FROM Quizzes WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
	}
}

?>