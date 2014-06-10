<?php

/**
 * This class is the model used to handle Answers.  The class contains the
 * functions needed to create Answers.
 */


Class Answer {

	private $id;
	private $question_id;
	private $number;
	private $value;
	private $correct;

	function __construct5($aId,$aQuestionId,$aNumber,$aValue,$aCorrect){
		$this->id = $aId;
		$this->question_id = $aQuestionId;
		$this->number = $aNumber;
		$this->value = $aValue;
		$this->correct = $aCorrect;
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
		$var['question_id'] = (String)$this->question_id;
		$var['number'] = (int)$this->number;
		$var['value'] = (int)$this->value;
		$var['correct'] = (int)$this->correct;

		return json_encode($var);
	}


	/**
	 * getId
	 * Getter of Answer id
	 *
	 * @return an integer
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * getQuestionId
	 * Getter for Answer question_id
	 *
	 * @return an integer
	 */
	public function getQuestionId() {
		return $this->question_id;
	}


	/**
	 * getNumber
	 * Getter for Answer number
	 *
	 * @return an integer
	 */
	public function getNumber() {
		return $this->number;
	}


	/**
	 * getValue
	 * Getter for Answer value
	 *
	 * @return a string
	 */
	public function getValue() {
		return $this->value;
	}


	/**
	 * getCorrect
	 * Getter for Answer correct
	 *
	 * @return an integer
	 */
	public function getCorrect() {
		return $this->correct;
	}


	/**
	 * setId
	 * Setter for Answer id
	 *
	 * @param an integer
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * setQuestionId
	 * Setter for Answer question_id
	 *
	 * @param an integer
	 */
	public function setQuestionId($id) {
		$this->question_id = $id;
	}


	/**
	 * setNumber
	 * Setter for Answer number
	 *
	 * @param an integer
	 */
	public function setNumber($id) {
		$this->number = $id;
	}


	/**
	 * setValue
	 * Setter for Answer value
	 *
	 * @param a string
	 */
	public function setValue($value) {
		$this->value = $value;
	}


	/**
	 * setCorrect
	 * Setter for Answer correct
	 *
	 * @param an integer
	 */
	public function setCorrect($correct) {
		$this->correct = $correct;
	}

	/**
	 * getAnswerById
	 * Returns an Answer object that is found using the given db and id
	 *
	 * @param $db --> The PDO database object
	 * @param $id --> The id of the answer
	 */
	public static function getAnswerById($db, $id) {
		$wRequest = $db->prepare("SELECT * FROM Answers WHERE id=:id");
		$wRequest->bindParam(":id", $id);
		$wRequest->execute();
		return $wRequest->fetchObject("Answer");
	}

	/**
	 * getAnswerByNumber
	 * Returns an Answer object that is found using the given db, question_id and number
	 *
	 * @param $db --> The PDO database object
	 * @param $id --> The id of the question's id
	 * @param $number ---> The number of the answer in the question
	 */
	public static function getAnswerByNumber($db, $id, $number) {
		$wRequest = $db->prepare('SELECT * FROM Answers WHERE question_id=:question_id and number=:number');
		$wRequest->bindParam(":question_id", $id);
		$wRequest->bindParam(":number", $number);
		$wRequest->execute();
		return $wRequest->fetchObject("Answer");
	}

	 /**
	 * save
	 * Saves or updates an Answer in the database
	 * 
	 * @param $aDb PDO object db
	 */
	public function save($aDb){
		$wRequest = $aDb->prepare("INSERT INTO Answers (id,question_id,number,value,correct)  
									VALUES (:id,:question_id,:number,:value,:correct)
									ON DUPLICATE KEY UPDATE question_id=:question_id,number=:number,value=:value,correct=:correct");
		$wRequest->bindParam(":id", $this->id,PDO::PARAM_INT);
		$wRequest->bindParam(":question_id", $this->question_id,PDO::PARAM_INT);
		$wRequest->bindParam(":number", $this->number,PDO::PARAM_INT);
		$wRequest->bindParam(":value", $this->value,PDO::PARAM_STR);
		$wRequest->bindParam(":correct", $this->correct,PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * delete
	 * Deletes a Answer in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId an integer id
	 */
	public static function delete($aDb,$aId){
		$wRequest = $aDb->prepare("DELETE FROM Answers WHERE id=:id");
		$wRequest->bindParam(":id",$aId);  
		$wRequest->execute();
	}

	/**
	 * deleteByNumber
	 * Deletes a Answer in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aQuestionId an integer question_id
	 * @param  $aNumber an integer answers number
	 */
	public static function deleteByNumber($aDb,$aQuestionId,$aNumber){
		$wRequest = $aDb->prepare("DELETE FROM Answers WHERE number=:number AND question_id=:question_id");
		$wRequest->bindParam(":number",$aNumber);
		$wRequest->bindParam(":question_id",$aQuestionId);  
		$wRequest->execute();
	}


}

?>
