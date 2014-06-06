<?php
require_once "permission.php";

/**
 * This class is the container of Permission factory functions.
 */
Class PermissionFactory {

	/**
	 * getPermissionsById
	 * Returns a Permission object that is found using the given id and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param $aId The id of the permission
	 * @return a Permissions array
	 */
	public static function getPermissionById($aDb, $aId){

		$wRequest = $aDb->prepare("Select id,name FROM Permissions WHERE id=:id;");
		$wRequest->bindParam(":id", $aId, PDO::PARAM_INT);
		$wRequest->execute();
		$wPermission = $wRequest->fetchObject("Permission");
		return $wPermission;
	}

	/**
	 * getAllPermissions
	 * Returns a Permission object that is found using the given Role id and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aRoleId  The id of the role
	 * @return  a Permissions array
	 */
	public static function getAllPermissions($aDb){

		$wRequest = $aDb->prepare("Select id,name FROM Permissions");
		$wRequest->execute();
		$wPermissions = NULL;
		while($wPermission = $wRequest->fetchObject("Permission")){
			$wPermissions[] = $wPermission;
		}
		return $wPermissions;
	}
}
