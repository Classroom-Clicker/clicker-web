<?php

/**
 * This class is the model used to handle Roles.
 */
Class Role {

	private $id;
	private $name;
	private $permissions;

	/**
	 * getJson
	 *
	 * Returns a string that is the JSON representation of the object.
	 *
	 * @return a String
	 */
	function getJson(){
		$var['id'] = (int)$this->getId();
		$var['name'] = (int)$this->getName();

		return json_encode($var);
	}

	/**
	 * save
	 * save the Role object in the database
	 *
	 * @param $aDb PDO object
	 */
	public function save($aDb){

		$wRequest = $aDb->prepare("INSERT INTO Roles(id,name) VALUES(:id, :name)
			ON DUPLICATE KEY UPDATE name=:name;");
		$wRequest->bindParam(":id", $this->getId(), PDO::PARAM_INT);
		$wRequest->bindParam(":name", $this->getName(), PDO::PARAM_STR);
		$wRequest->execute();
		//remove all the linked permissions
		$wRequest = $aDb->prepare("DELETE FROM RolesPermissions WHERE role_id=:role_id;");
		$wRequest->bindParam(":role_id", $this->getId(), PDO::PARAM_INT);
		$wRequest->execute();
		foreach ($this->getPermissions() as $wPermission) {
			$wPermission->save(); // and create them again
		}
	}

	/**
	 * delete
	 * delete the Role object from the database
	 *
	 * @param $aDb PDO object
	 * @param $aId int id of Role to delete
	 */
	public static function delete($aDb, $aId){

		$wRequest = $aDb->prepare("DELETE FROM Roles WHERE id=:id;");
		$wRequest->bindParam(":id", $aId(), PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * getId
	 * getter of Role id
	 *
	 * @return a integer
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * getName
	 * getter of Role name
	 *
	 * @return a String
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * getPermissions
	 * getter of Role Permissions
	 *
	 * @return an Array of Permission
	 */
	public function getPermissions(){
		return $this->permissions;
	}

	/**
	 * setId
	 * setter of Role id
	 *
	 * @param a integer
	 */
	public function setId($aId){
		$this->id = $aId;
	}

	/**
	 * setName
	 * setter of Role name
	 *
	 * @param a String
	 */
	public function setName($aName){
		$this->name = $aName;
	}

	/**
	 * setPermissions
	 * setter of Role Permissions
	 *
	 * @param an Array of Permission
	 */
	public function setPermissions($aPermissions){
		$this->permissions = $aPermissions;
	}

}
