<?php
require_once "User.php";
require_once "RoleFactory.php";
require_once "SpecialPermissionFactory.php";

/**
 * This class is the container of User factory functions.
 */
Class UserFactory {

	/**
	 * getUserById
	 * Returns a User object that is found using the given id and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aId  The id of the user
	 * @return  a User object
	 */
	public static function getUserById($aDb, $aId){

		$wRequest = $aDb->prepare("Select id,username,email,firstname,lastname FROM Users
			WHERE id=:id;");
		$wRequest->bindParam(":id", $aId, PDO::PARAM_INT);
		$wRequest->execute();
		$wUser = $wRequest->fetchObject("User");
		if($wUser){
			$wUser->setRoles(RoleFactory::getRolesByUserId($aDb, $aId));
			$wUser->setSpecialPermissions(SpecialPermissionFactory::getSpecialPermissionsByUserId($aDb, $aId));    
			return $wUser;
		}
		return $wUser;
	}

	/**
	 * getUserByApiKey
	 * Returns a User object that is found using the given apikey and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aApikey  The apikey of the user
	 * @return  a User object
	 */
	public static function getUserByApiKey($aDb, $aApikey){

		$wRequest = $aDb->prepare("Select id,username,email,firstname,lastname FROM Users U
			JOIN Secrets S ON U.id=S.user_id WHERE apikey=:apikey;");
		$wRequest->bindParam(":apikey", $aApikey, PDO::PARAM_INT);
		$wRequest->execute();
		$wUser = $wRequest->fetchObject("User");
		$wId = $wUser->getId();
		if($wUser){
			$wUser->setRoles(RoleFactory::getRolesByUserId($aDb, $wId));
			$wUser->setSpecialPermissions(SpecialPermissionFactory::getSpecialPermissionsByUserId($aDb, $wId));
			return $wUser;
		}
		return $wUser;
	}

	/**
	 * getUserByUsername
	 * Returns a User object that is found using the given username and the global
	 * PDO object db
	 *
	 * @param $aDb PDO object
	 * @param  $aUsername  The username of the user
	 * @return  a User object
	 */
	public static function getUserbyUsername($aDb, $aUsername){

		$wRequest = $aDb->prepare("Select id,username,email,firstname,lastname FROM Users
			WHERE username=:username;");
		$wRequest->bindParam(":username", $aUsername, PDO::PARAM_STR);
		$wRequest->execute();
		$wUser = $wRequest->fetchObject("User");
		$wId = $wUser->getId();
		if($wUser){
			$wUser->setRoles(RoleFactory::getRolesByUserId($aDb, $wId));
			$wUser->setSpecialPermissions(SpecialPermissionFactory::getSpecialPermissionsByUserId($aDb, $wId));
			return $wUser;
		}
		return $wUser;
	}
}
