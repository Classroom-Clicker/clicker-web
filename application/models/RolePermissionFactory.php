<?php
require_once "User.php";
require_once "PermissionFactory.php";

/**
 * This class is the container of Role factory functions.
 */
Class RolePermissionFactory {

	/**
	 * getRolePermissionsByRoleId
	 * Returns a Permission array that contains every Permission found using the
	 * given Role id and the global PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aRoleId  The id of the role
	 * @return  a Permissions array
	 */
	public static function getRolePermissionsByRoleId($aDb, $aRoleId){

		$wRequest = $aDb->prepare("Select id,name,role_id FROM Permissions P
			JOIN RolesPermissions R ON P.id=R.permission_id WHERE R.role_id=:role_id;");
		$wRequest->bindParam(":role_id", $aRoleId, PDO::PARAM_INT);
		$wRequest->execute();
		$wPermissions = NULL;
		while($wPermission = $wRequest->fetchObject("Permission")){
			$wPermissions[] = $wPermission;
		}
		return $wPermissions;
	}
}
