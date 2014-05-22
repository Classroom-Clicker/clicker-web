<?php
require_once "Permission.php";

/**
 * This class is the model used to handle Role Permissions.
 */
Class RolePermission extends Permission {

	private $role_id;

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
		$var['role_id'] = (int)$this->getRoleId();

		return json_encode($var);
	}

	/**
	 * save
	 * save the Role object in the database
	 *
	 * @param $aDb PDO object
	 */
	public function save($aDb){

		$wRequest = $aDb->prepare("INSERT IGNORE INTO RolesPermissions(role_id,permission_id)
			VALUES(:role_id,:permission_id);");
		$wRequest->bindParam(":role_id", $this->getRoleId(), PDO::PARAM_INT);
		$wRequest->bindParam(":permission_id", $this->getId(), PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * delete
	 * delete the Role object from the database
	 *
	 * @param $aDb PDO object
	 * @param $aPermissionId int id of RolePermission to delete
	 * @param $aRoleId int role_id of RolePermission to delete
	 */
	public static function delete($aDb, $aPermissionId, $aRoleId){

		$wRequest = $aDb->prepare("DELETE FROM RolesPermissions WHERE
			role_id=:role_id AND permission_id=:permission_id;");
		$wRequest->bindParam(":role_id", $aRoleId, PDO::PARAM_INT);
		$wRequest->bindParam(":permission_id", $aPermissionId, PDO::PARAM_INT);
		$wRequest->execute();
	}

	/**
	 * getRoleId
	 * getter of SpecialPermission role_id
	 *
	 * @return a integer
	 */
	public function getRoleId(){
		return $this->role_id;
	}

	/**
	 * setRoleId
	 * setter of SpecialPermission role_id
	 *
	 * @param a integer
	 */
	public function setRoleId($aRoleId){
		$this->role_id = $aRoleId;
	}
}
