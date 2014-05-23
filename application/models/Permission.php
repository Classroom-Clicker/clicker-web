<?php

/**
 * This class is the model used to handle Permissions.
 */
Class Permission {

	private $id;
	private $name;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->getId();
		$var['name'] = (String)$this->getName();

		return json_encode($var);
	}

	/**
	 * save
	 * save the Permission object in the database
	 *
	 * @param $aDb PDO object
	 */
	public function save($aDb){

		$wRequest = $aDb->prepare("INSERT INTO Permissions(id,name) VALUES(:id,:name)
			ON DUPLICATE KEY UPDATE name=:name;");
		$wRequest->bindParam(":id", $this->getId(), PDO::PARAM_INT);
		$wRequest->bindParam(":name", $this->getName(), PDO::PARAM_STR);
		$wRequest->execute();
	}

	/**
	 * delete
	 * delete the Permission from the database
	 *
	 * @param $aDb PDO object
	 * @param $aId int id of Permission to delete
	 */
	public static function delete($aDb, $aId){

		$wRequest = $aDb->prepare("DELETE FROM Permissions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId, PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * getId
	 * getter of Permission id
	 *
	 * @return a integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getName
	 * getter of Permission name
	 *
	 * @return a integer
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * setUserId
	 * setter of Permission id
	 *
	 * @param a integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * getName
	 * getter of Permission name
	 *
	 * @param a integer
	 */
	public function setName($aName){
		$this->name = $aName;
	}
}
