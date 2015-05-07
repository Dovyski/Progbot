<?php

require_once dirname(__FILE__).'/config.php';

define('USER_LEVEL_STUDENT', 	1);
define('USER_LEVEL_PROFESSOR', 	2);
define('USER_LEVEL_ADMIN', 		3);

function userGetById($theUserId) {
	global $gDb;

	$aUser = null;
	$aQuery = $gDb->prepare("SELECT id, fk_group, login, name, email, type FROM users WHERE id = ?");

	if ($aQuery->execute(array($theUserId))) {
		$aUser = $aQuery->fetch();
	}

	return $aUser;
}

function userFindByGroupId($theGroupId) {
	global $gDb;

	$aRet = array();
	$aQuery = $gDb->prepare("SELECT id, fk_group, login, name, email, type FROM users WHERE fk_group = ?");

	if ($aQuery->execute(array($theGroupId))) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

function userChangeGroup($theUserId, $theGroupId) {
	global $gDb;

	$aQuery = $gDb->prepare("UPDATE users SET fk_group = ? WHERE id = ?");
	$aQuery->execute(array($theGroupId, $theUserId));

	return $aQuery->rowCount() != 0;
}

function userIsLevel($theUserInfo, $theLevel) {
	return $theUserInfo['type'] == $theLevel;
}

function userLoginfyName($theName) {
	$aParts = explode(' ', strtolower($theName));
	$aName  = '';

	for ($i = 0; $i < count($aParts) - 1; $i++) {
		$aName .= strlen($aParts[$i]) >= 1 ? $aParts[$i][0] : '';
	}

	$aName .= $aParts[$i];
	return $aName;
}

?>
