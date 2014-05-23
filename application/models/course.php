<?php

// look at the db diagram to find out what needs to be in it.
// write function save (that does update as well) and delete
// write factory function to retrieve courses (look at API routes to find out which)

/**
 * This class is the model used to handle Courses. The class contains the factory
 * functions needed to create Courses.
 */

Class Course extends CI_Model{

	private $id;
	private $name;
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
		$var['user_id'] = (int)$this->user_id;

		return json_encode($var);
	}

	/**
	 * getId 
	 * getter of User id
	 *
	 * @return an integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getName 
	 * getter of Course name
	 *
	 * @return a String
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * getUserId
	 * getter of Course user_id
	 *
	 * @return an integer
	 */
	public function getUserId(){
		return $this->user_id;
	}

	/**
	 * setId 
	 * setter of Course id
	 *
	 * @param an integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setName 
	 * setter of Course name
	 *
	 * @param a String
	 */
	public function setName($aName){
		$this->name = $aName;
	}

	/**
	 * setUserId
	 * setter of Course user_id
	 *
	 * @param an integer
	 */
	public function setUserId($aUserId){
		$this->user_id = $aUserId;
	}


	/**
	 * getCourseById
	 * Returns a Course object that is found using the given id and the global
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId  The id of the course
	 * @return  a Course object
	 */
	public static function getCourseById($aDb,$aId){
		$wRequest = $aDb->prepare("Select id,name,user_id FROM Courses WHERE id=:id;");
		$wRequest->bindParam(":id", $aId);
		$wRequest->execute();
		$wCourse = $wRequest->fetchObject("Course");
		return $wCourse;
	}


	/**
	 * getCourseByUserId
	 * Returns a Course object that is found using the given UserId and the global
	 * 
	 * @param $aDb PDO object db
	 * @param  $aUserId  The id of the user
	 * @return  a Course object
	 */
	public static function getCourseByUserId($aDb,$aUserId){
		$wRequest = $aDb->prepare("Select id,name,user_id FROM Courses WHERE user_id=:user_id;");
		$wRequest->bindParam(":user_id", $aUserId);
		$wRequest->execute();
		$wUser = $wRequest->fetchObject("Course");
		return $wUser;
	}

	/**
	 * saveCourse
	 * Saves or updates a Course in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aCourse  a Course object
	 */
	public static function saveCourse($aDb,$aCourse){
		$wRequest = $aDb->prepare("INSERT INTO Courses (id,name,user_id)  
									VALUES (:id,:name,:user_id)
									ON DUPLICATE KEY UPDATE name=:name, user_id=:user_id");
		$wRequest->bindParam(":id", $aCourse->getId(),PDO::PARAM_INT);
		$wRequest->bindParam(":name", $aCourse->getName(),PDO::PARAM_STR);
		$wRequest->bindParam(":user_id", $aCourse->getUserId(),PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * delCourse
	 * Deletes a Course in the database
	 * 
	 * @param $aDb PDO object db
	 * @param  $aId an integer id
	 */
	public static function delCourse($aDb,$aId){
		$wRequest = $aDb->prepare("DELETE FROM Courses WHERE id=:id");
		$wRequest->bindParam(":id",$aId);  
		$wRequest->execute();
	}
}?>