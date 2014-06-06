<?php

/**
 * This class is the model used to handle Users.
 */
Class User {

	private $id;
	private $username;
	private $email;
	private $firstname;
	private $lastname;
	private $roles;
	private $specialPermissions;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->getId();
		$var['username'] = (String)$this->getUsername();
		$var['email'] = (String)$this->getEmail();
		$var['firstname'] = (String)$this->getFirstName();
		$var['lastname'] = (String)$this->getLastName();

		return json_encode($var);
	}

	/**
	 * save
	 * save the User object in the database
	 *
	 * @param $aDb PDO object
	 */
	public function save($aDb){

		$wRequest = $aDb->prepare("INSERT INTO Users(id,username,email,firstname,lastname)
			VALUES(:id, :username, :email, :firstname, :lastname)
			ON DUPLICATE KEY UPDATE email=:email, username=:username, firstname = :firstname,
			lastname=:lastname;");
		$wRequest->bindParam(":id", $this->getId(), PDO::PARAM_INT);
		$wRequest->bindParam(":username", $this->getUsername(), PDO::PARAM_STR);
		$wRequest->bindParam(":email", $this->getEmail(), PDO::PARAM_STR);
		$wRequest->bindParam(":firstname", $this->getFirstName(), PDO::PARAM_STR);
		$wRequest->bindParam(":lastname", $this->getLastName(), PDO::PARAM_STR);
		$wRequest->execute();
	}

	/**
	 * delete
	 * delete the User object from the database
	 *
	 * @param $aDb PDO object
	 * @param $aId int id of User to delete
	 */
	public static function delete($aDb, $aId){

		$wRequest = $aDb->prepare("DELETE FROM Users WHERE id=:id;");
		$wRequest->bindParam(":id", $aId, PDO::PARAM_INT);
		$wRequest->execute();
	}

	public function isAllowed(){
		//TODO
		// the function will use the permissions in roles
		// if nothing allowing found in roles, will look in specialPermissions
	}

	/**
	 * getId
	 * getter of User id
	 *
	 * @return a integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getUsername
	 * getter of User username
	 *
	 * @return a String
	 */
	public function getUsername(){
		return $this->username;
	}

	/**
	 * getEmail
	 * getter of User email
	 *
	 * @return a String
	 */
	public function getEmail(){
		return $this->email;
	}

	/**
	 * getFirstName
	 * getter of User firstname
	 *
	 * @return a String
	 */
	public function getFirstName(){
		return $this->firstname;
	}

	/**
	 * getLastName
	 * getter of User lastname
	 *
	 * @return a String
	 */
	public function getLastName(){
		return $this->lastname;
	}

	/**
	 * getRoles
	 * getter of User Roles
	 *
	 * @return a Role array
	 */
	public function getRoles(){
		return $this->roles;
	}

	/**
	 * setSpecialPermissions
	 * getter of User SpecialPermissions
	 *
	 * @return a SpecialPermission array
	 */
	public function getSpecialPermissions(){
		return $this->specialPermissions;
	}

	/**
	 * setId
	 * setter of User id
	 *
	 * @param a integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setUsername
	 * setter of User username
	 *
	 * @param a String
	 */
	public function setUsername($aUsername){
		$this->username = $aUsername;
	}

	/**
	 * setEmail
	 * setter of User email
	 *
	 * @param a String
	 */
	public function setEmail($aEmail){
		$this->email = $aEmail;
	}

	/**
	 * setFirstName
	 * setter of User firstname
	 *
	 * @param a String
	 */
	public function setFirstName($aFirstName){
		$this->firstname = $aFirstName;
	}

	/**
	 * setLastName
	 * setter of User lastname
	 *
	 * @param a String
	 */
	public function setLastName($aLastName){
		$this->lastname = $aLastName;
	}

	/**
	 * setRoles
	 * setter of User Roles
	 *
	 * @param a Role array
	 */
	public function setRoles($aRoles){
		$this->roles = $aRoles;
	}

	/**
	 * setSpecialPermissions
	 * setter of User SpecialPermissions
	 *
	 * @param a SpecialPermission array
	 */
	public function setSpecialPermissions($aSpecialPermissions){
		$this->specialPermissions = $aSpecialPermissions;
	}

}
