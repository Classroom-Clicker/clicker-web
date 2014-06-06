<?php
require_once "permission.php";

/**
 * This class is the model used to handle Special Permissions.
 */
Class SpecialPermission extends Permission {

	private $object_id;
	private $user_id;

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
		$var['object_id'] = (int)$this->getObjectId();
		$var['user_id'] = (int)$this->getUserId();

		return json_encode($var);
	}

	/**
	 * save
	 * save the Role object in the database
	 *
	 * @param $aDb PDO object
	 */
	public function save($aDb){

		$wRequest = $aDb->prepare("INSERT IGNORE INTO SpecialsPermissions(user_id,permission_id,object_id)
			VALUES(:user_id,:permission_id,:object_id)");
		$wRequest->bindParam(":user_id", $this->getUserId(), PDO::PARAM_INT);
		$wRequest->bindParam(":permission_id", $this->getId(), PDO::PARAM_INT);
		$wRequest->bindParam(":object_id", $this->getObjectId(), PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * delete
	 * delete the Role object from the database
	 *
	 * @param $aDb PDO object
	 * @param $aPermissionId int id of SpecialPermission to delete
	 * @param $aUserId int user_id of SpecialPermission to delete
	 * @param $aObjectId int object_id of SpecialPermission to delete
	 */
	public static function delete($aDb, $aPermissionId, $aUserId, $aObjectId){

		$wRequest = $aDb->prepare("DELETE FROM SpecialsPermissions WHERE
			user_id=:user_id AND permission_id=:permission_id AND object_id=:object_id ;");
		$wRequest->bindParam(":user_id", $aUserId, PDO::PARAM_INT);
		$wRequest->bindParam(":permission_id", $aPermissionId, PDO::PARAM_INT);
		$wRequest->bindParam(":object_id", $aObjectId, PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * getObjectId
	 * getter of SpecialPermission object_id
	 *
	 * @return a integer
	 */
	public function getObjectId(){
		return $this->object_id;
	}

	/**
	 * getUserId
	 * getter of SpecialPermission user_id
	 *
	 * @return a integer
	 */
	public function getUserId(){
		return $this->user_id;
	}

	/**
	 * setObjectId
	 * setter of SpecialPermission object_id
	 *
	 * @param a integer
	 */
	public function setObjectId($aObjectId){
		$this->object_id = $aObjectId;
	}

	/**
	 * setUserId
	 * setter of SpecialPermission user_id
	 *
	 * @param a integer
	 */
	public function setUserId($aUserId){
		$this->user_id = $aUserId;
	}


}
