<?php

require_once dirname(__FILE__).'/config.php';

function categoryGetById($theId) {
	global $gDb;

	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM categories WHERE id = ?");

	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}

	return $aRet;
}

function categoryCreateOrUpdate($theCategoryId, $theData) {
	global $gDb;

	$aRet					= false;
	$aId 					= $theCategoryId + 0;
	$aName 					= isset($theData['name']) 					? $theData['name'] 					: '';
	$aDescription 			= isset($theData['description']) 			? $theData['description'] 			: '';

	$aQuery = $gDb->prepare("INSERT INTO categories	(id, name, description)
								VALUES (?, ?, ?)
								ON DUPLICATE KEY UPDATE name = ?, description = ?");

	if(strlen($aName) > 0 && strlen($aDescription) > 0) {
		$aParams = array($aId, $aName, $aDescription, $aName, $aDescription);

		$aQuery->execute($aParams);
		$aRet = $aQuery->rowCount();
	}

	return $aRet;
}

function categoryFindAll() {
	global $gDb;

	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT id, name FROM categories WHERE 1");

	if ($aQuery->execute()) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

?>
