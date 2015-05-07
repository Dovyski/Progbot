<?php

require_once dirname(__FILE__).'/config.php';

function groupGetById($theId) {
	global $gDb;

	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM groups WHERE id = ?");

	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}

	return $aRet;
}

function groupCreateOrUpdate($theGroupId, $theData) {
	global $gDb;

	$aRet					= false;
	$aId 					= $theGroupId + 0;
	$aName 					= isset($theData['name']) ? $theData['name'] : '';

	$aQuery = $gDb->prepare("INSERT INTO groups	(id, name)
								VALUES (?, ?)
								ON DUPLICATE KEY UPDATE name = ?");

	if(strlen($aName) > 0) {
		$aParams = array($aId, $aName, $aName);

		$aQuery->execute($aParams);
		$aRet = $aQuery->rowCount();
	}

	return $aRet;
}

function groupFindAll() {
	global $gDb;

	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT id, name FROM groups WHERE 1");

	if ($aQuery->execute()) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

?>
