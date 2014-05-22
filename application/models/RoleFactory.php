<?php
require_once "Role.php";
require_once "RolePermissionFactory.php";

/**
 * This class is the container of Role factory functions.
 */
Class RoleFactory {

	/**
	 * getRoleById
	 * Returns a Role object that is found using the given id and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aId  The id of the role
	 * @return  a Role object
	 */
	public static function getRoleById($aDb, $aId){

		$wRequest = $aDb->prepare("Select id,name FROM Roles WHERE id=:id;");
		$wRequest->bindParam(":id", $aId, PDO::PARAM_INT);
		$wRequest->execute();
		$wRole = $wRequest->fetchObject("Role");
		if($wRole){
			$wRole->setPermissions(RolePermissionFactory::getRolePermissionsByRoleId($aDb, $aId));
			return $wRole;	
		}
		return $wRole;
	}

	/**
	 * getRolesByUserId
	 * Returns a Role array containig Roles foundu sing the given user id and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aId  The id of the role
	 * @return  a Role object
	 */
	public static function getRolesByUserId($aDb, $aUserId){

		$wRequest = $aDb->prepare("Select id,name FROM Roles R
			JOIN UsersRoles U ON R.id=U.role_id WHERE U.user_id=:user_id;");
		$wRequest->bindParam(":user_id", $aUserId, PDO::PARAM_INT);
		$wRequest->execute();
		$wRoles = NULL;
		while($wRole = $wRequest->fetchObject("Role")){
			$wRole->setPermissions(RolePermissionFactory::getRolePermissionsByRoleId($aDb, $wRole->getId()));
			$wRoles[] = $wRole;
		}
		return $wRoles;
	}
}
