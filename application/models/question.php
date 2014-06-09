<?php

/**
 * This class is the model used to handle Questions. The class contains the factory
 * functions needed to create Questions.
 */

Class Question {

	private $id;
	private $number;
	private $quiz_id;
	private $type;
	private $question;

	function __construct5($aId,$aNumber,$aQuizId,$aType,$aQuestion){
		$this->id = $aId;
		$this->number = $aNumber;
		$this->quiz_id = $aQuizId;
		$this->type = $aType;
		$this->question = $aQuestion;
	}

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->id;
		$var['number'] = (int)$this->name;
		$var['quiz_id'] = (int)$this->user_id;
		$var['type'] = (int)$this->user_id;
		$var['question'] = (String)$this->user_id;

		return json_encode($var);
	}

	/**
	 * getId 
	 * getter of Question id
	 *
	 * @return an integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getNumber 
	 * getter of Question number
	 *
	 * @return an integer
	 */
	public function getNumber(){
		return $this->number;
	}

	/**
	 * getQuizId
	 * getter of Question quiz_id
	 *
	 * @return an integer
	 */
	public function getQuizId(){
		return $this->quiz_id;
	}

	/**
	 * getType
	 * getter of Question type
	 *
	 * @return an integer
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * getQuestion
	 * getter of Question question
	 *
	 * @return a String
	 */
	public function getQuestion(){
		return $this->question;
	}

	/**
	 * setId 
	 * setter of Question id
	 *
	 * @param an integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setNumber 
	 * setter of Question number
	 *
	 * @param an integer
	 */
	public function setNumber($aNumber){
		$this->number = $aNumber;
	}

	/**
	 * setQuizId
	 * setter of Question quiz_id
	 *
	 * @param an integer
	 */
	public function setQuizId($aQuizId){
		$this->quiz_id = $aQuizId;
	}

	/**
	 * setType
	 * setter of Question type
	 *
	 * @param an integer
	 */
	public function setType($aType){
		$this->type = $aType;
	}


	/**
	 * setQuestion
	 * setter of Question type
	 *
	 * @param a string question
	 */
	public function setQuestion($aQuestion){
		$this->question = $aQuestion;
	}


	/**
	 * getAnswers
	 * getter of array of Answers
	 *
	 * @return an array of Answers
	 */
	public function getAnswers($aDb){
		$wRequest = $aDb->prepare("SELECT * FROM Answers WHERE question_id=:question_id");
		$wRequest->bindParam(":question_id", $this->id);
		$wRequest->execute();
		return $wRequest->FetchAll(PDO::FETCH_CLASS,"Answer");
	}

	/**
	 * getQuestionById
	 * Returns a Question object that is found using the given id 
	 * 
	 * @param $aDb PDO object db
	 * @param $aId  The id of the Question
	 * @return  a Question object
	 */
	public static function getQuestionById($aDb, $aId){
		$wRequest = $aDb->prepare("Select id,number,quiz_id,type,question FROM Questions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wQuestion = $wRequest->fetchObject("Question");
		return $wQuestion;
	}


	/**
	 * getQuestionByNumber
	 * Returns a Question object that is found using the given id 
	 * 
	 * @param $aDb PDO object db
	 * @param $aId  The id of the Question
	 * @return  a Question object
	 */
	public static function getQuestionByNumber($aDb, $aNumber){
		$wRequest = $aDb->prepare("Select id,number,quiz_id,type,question FROM Questions WHERE number=:number;");
		$wRequest->bindParam(":number", $aNumber);
		$wRequest->execute();
		$wQuestion = $wRequest->fetchObject("Question");
		return $wQuestion;
	}

	/**
	 * getQuestionsQuizId
	 * Returns an array Question object that is found using the given quiz id 
	 * 
	 * @param $aDb PDO object db
	 * @param $aId  The id of the Question
	 * @return  an array Question objects
	 */
	public static function getQuestionsByQuizId($aDb, $aId){
		$wRequest = $aDb->prepare("Select id,number,quiz_id,type,question FROM Questions WHERE quiz_id=:quiz_id;");
		$wRequest->bindParam(":quiz_id", $aId);
		$wRequest->execute();
		$wQuestion = $wRequest->FetchAll(PDO::FETCH_CLASS,"Question");
		return $wQuestion;
	}

	/**
	 * save
	 * Saves or updates a Question in the database
	 * 
	 * @param $aDb PDO object db
	 */
	public function save($aDb){
		$wRequest = $aDb->prepare("INSERT INTO Questions (id, number, quiz_id, type, question)  
									VALUES (:id,:number,:quiz_id,:type,:question)
									ON DUPLICATE KEY UPDATE number=:number,quiz_id=:quiz_id,type=:type,question=:question");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":number", $this->number,PDO::PARAM_INT);
		$wRequest->bindParam(":quiz_id", $this->quiz_id,PDO::PARAM_INT);
		$wRequest->bindParam(":type", $this->type,PDO::PARAM_INT);
		$wRequest->bindParam(":question", $this->question,PDO::PARAM_STR);
		$wRequest->execute();
		$tempId = $aDb->lastInsertId();
		if($tempId != 0){
			$this->id = $tempId;
		}

	}	

	/**
	 * delete
	 * Deletes a Question in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId an integer id
	 */
	public static function delete($aDb,$aId){
		$wRequest = $aDb->prepare("DELETE FROM Questions WHERE id=:id");
		$wRequest->bindParam(":id",$aId);  
		$wRequest->execute();

	}

}?>
