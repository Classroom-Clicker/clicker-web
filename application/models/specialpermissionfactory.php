<?php
require_once "specialpermission.php";

/**
 * This class is the container of SpecialPermission factory functions.
 */
Class SpecialPermissionFactory {

	/**
	 * getSpecialPermissionsByUserId
	 * Returns a Permission array that is created SpecialPermissionusing the found using the given
	 * id and the global PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aId  The id of the user
	 * @return  a Permissions array
	 */
	public static function getSpecialPermissionsByUserId($aDb, $aUserId){

		$wRequest = $aDb->prepare("Select id,name,object_id,user_id FROM Permissions P
			JOIN SpecialsPermissions S ON P.id=S.permission_id WHERE S.user_id=:user_id;");
		$wRequest->bindParam(":user_id", $aUserId, PDO::PARAM_INT);
		$wRequest->execute();
		$wPermissions = NULL;
		while($wPermission = $wRequest->fetchObject("SpecialPermission")){
			$wPermissions[] = $wPermission;
		}
		return $wPermissions;
	}
}
