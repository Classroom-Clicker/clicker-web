<?php

/**
 * This class is the model used to handle UserAnswers.  The class contains the
 * functions needed to create UserAnswers.
 */


Class UserAnswer {

    private $id;
    private $userquestion_id;
    private $answer_id;

    /**
     * getJson
     *
     * Returns a string that is the JSON representation of the object.
     *
     * @return a String
     */
    function getJson(){
        $var['id'] = (int)$this->id;
        $var['userquestion_id'] = (String)$this->userquestion_id;
        $var['answer_id'] = (int)$this->answer_id;
        return json_encode($var);
    }

    /**
     * getId
     * Getter of UserAnswer id
     *
     * @return an integer
     */
    public function getId() {
        return $this->id;
    }


    /**
     * getUserQuestionId
     * Getter for UserAnswer userquestion_id
     *
     * @return an integer
     */
    public function getUserQuestionId() {
        return $this->userquestion_id;
    }


    /**
     * getAnswerId
     * Getter for UserAnswer answer_id
     *
     * @return an integer
     */
    public function getAnswerId() {
        return $this->answer_id;
    }


    /**
     * setId
     * Setter for UserAnswer id
     *
     * @param an integer
     */
    public function setId($id) {
        $this->id = $id;
    }


    /**
     * setUserQuestionId
     * Setter for UserAnswer userquestion_id
     *
     * @param an integer
     */
    public function setUserQuestionId($id) {
        $this->userquestion_id = $id;
    }


    /**
     * setAnswerId
     * Setter for UserAnswer answer_id
     *
     * @param an integer
     */
    public function setAnswerId($id) {
        $this->answer_id = $id;
    }


    /**
     * getUserAnswerById
     * Returns a UserAnswer object that is found using the given db and id
     *
     * @param $db --> The PDO database object
     * @param $id --> The id of the UserAnswer
     */
    public static function getUserAnswerById($db, $id) {
        $wRequest = $db->prepare("SELECT * FROM UserAnswers WHERE id=:id");
        $wRequest->bindParam(":id", $id);
        $wRequest->execute();

        return $wRequest->fetchObject("UserAnswer");
    }

    /**
     * save
     * Saves or updates a UserAnswer in the database
     * 
     * @param $aDb PDO object db
     * @param  $aUserAnswer  a UserAnswer object
     */
    public static function save($aDb,$aUserAnswer){
        $wRequest = $aDb->prepare("INSERT INTO UserAnswers (id,userquestion_id,answer_id)  
                                    VALUES (:id,:userquestion_id,:answer_id)
                                    ON DUPLICATE KEY UPDATE userquestion_id=:userquestion_id, answer_id=:answer_id");
        $wRequest->bindParam(":id", $aUserAnswer->getId(),PDO::PARAM_INT);
        $wRequest->bindParam(":userquestion_id", $aUserAnswer->getUserQuestionId(),PDO::PARAM_INT);
        $wRequest->bindParam(":answer_id", $aUserAnswer->getAnswerId(),PDO::PARAM_INT);
        $wRequest->execute();
    }

    /**
     * delete
     * Deletes a UserAnswer in the database
     * 
     * @param $aDb PDO object db
     * @param  $aId an integer id
     */
    public function delete($aDb,$aId){
        $wRequest = $aDb->prepare("DELETE FROM UserAnswers WHERE id=:id");
        $wRequest->bindParam(":id",$aId);  
        $wRequest->execute();
    }

}

?>
