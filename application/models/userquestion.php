<?php

/**
 * This class is the model used to handle UserQuestions. The class contains the factory
 * functions needed to create UserQuestions.
 */

Class UserQuestion {

	private $id;
	private $quizsession_id;
	private $user_id;
	private $question_id;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->id;
		$var['quizsession_id'] = (int)$this->name;
		$var['user_id'] = (int)$this->user_id;
		$var['question_id'] = (int)$this->user_id;


		return json_encode($var);
	}

	/**
	 * getId 
	 * getter of UserQuestion id
	 *
	 * @return an integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getQuizSessionId 
	 * getter of UserQuestion quizsession_id
	 *
	 * @return an integer
	 */
	public function getQuizSessionId(){
		return $this->quizsession_id;
	}

	/**
	 * getUserId
	 * getter of UserQuestion user_id
	 *
	 * @return an integer
	 */
	public function getUserId(){
		return $this->user_id;
	}

	/**
	 * getQuestionId
	 * getter of UserQuestion question_id
	 *
	 * @return an integer
	 */
	public function getQuestionId(){
		return $this->question_id;
	}

	/**
	 * setId 
	 * setter of UserQuestion id
	 *
	 * @param an integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setQuizSessionId 
	 * setter of UserQuestion quizsession_id
	 *
	 * @param an integer
	 */
	public function setQuizSessionId($aQuizSessionId){
		$this->quizsession_id = $aQuizSessionId;
	}

	/**
	 * setUserId
	 * setter of UserQuestion user_id
	 *
	 * @param an integer
	 */
	public function setUserId($aUserId){
		$this->user_id = $aUserId;
	}

	/**
	 * setQuestionId
	 * setter of UserQuestion question_id
	 *
	 * @param an integer
	 */
	public function setQuestionId($aQuestionId){
		$this->question_id = $aQuestionId;
	}


	/**
	 * getUserQuestionById
	 * Returns a UserQuestion object that is found using the given id and the global
	 * 
	 * @param  $aId  The id of the UserQuestion
	 * @param $aDb PDO object db
	 * @return  a UserQuestion object
	 */
	public static function getUserQuestionById($aDb,$aId){
		$wRequest = $aDb->prepare("Select id,quizsession_id,user_id,question_id FROM UserQuestions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wUserQuestion = $wRequest->fetchObject("UserQuestion");
		return $wUserQuestion;
	}

	/**
	 * getUserQuestionByQuizSessionId
	 * Returns a UserQuestion object that is found using the given quizsession_id and the global
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId  The quizsession_id of the UserQuestion
	 * @return  a UserQuestion object
	 */
	public static function getUserQuestionByQuizSessionId($aDb,$aQuizSessionId){
		$wRequest = $aDb->prepare("Select id,quizsession_id,user_id,question_id,UserQuestion FROM UserQuestions WHERE quizsession_id=:quizsession_id;");
		$wRequest->bindParam(":quizsession_id", $aQuizSessionId);
		$wRequest->execute();
		$wUserQuestion = $wRequest->fetchObject("UserQuestion");
		return $wUserQuestion;
	}

	/**
	 * save
	 * Saves or updates a UserQuestion in the database
	 * 
	 * @param $aDb PDO object db
	 */
	public function save($aDb){
		$wRequest = $aDb->prepare("INSERT INTO UserQuestions (id, quizsession_id, user_id, question_id)  
									VALUES (:id,:quizsession_id,:user_id,:question_id)
									ON DUPLICATE KEY UPDATE id=:id, quizsession_id=:quizsession_id, user_id=:user_id, question_id=:question_id");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":quizsession_id", $this->quizsession_id,PDO::PARAM_INT);
		$wRequest->bindParam(":user_id",$this->user_id,PDO::PARAM_INT);
		$wRequest->bindParam(":question_id", $this->question_id,PDO::PARAM_INT);
		$wRequest->execute();
		$tempId = $aDb->lastInsertId();
		if($tempId != 0){
			$this->id = $tempId;
		}
	}

	/**
	 * delete
	 * Deletes a UserQuestion in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId an integer id
	 */
	public static function delete($aDb,$aId){
		$wRequest = $aDb->prepare("DELETE FROM UserQuestions WHERE id=:id");
		$wRequest->bindParam(":id",$aId);  
		$wRequest->execute();
	}

}?>
