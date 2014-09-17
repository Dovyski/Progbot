<?php

require_once dirname(__FILE__).'/config.php';


function assigmentGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM assignments WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function assigmentGetByChallengeAndGroup($theChallengeId, $theGroupId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM assignments WHERE fk_challenge = ? AND fk_group = ?");
	
	if ($aQuery->execute(array($theChallengeId, $theGroupId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function assigmentFindByUser($theUser) {
	global $gDb;
	
	$aRet 		= array();
	$aGroupId	= 0;

	if ($theUser['fk_group'] != null) {
		$aGroupId = $theUser['fk_group'];
	}
	
	if($aGroupId != 0) {
		$aQuery = $gDb->prepare("SELECT * FROM assignments WHERE fk_group = ?");
		
		if ($aQuery->execute(array($aGroupId))) {
			while($aRow = $aQuery->fetch()) {
				$aRet[$aRow['id']] = $aRow;
			}
		}
	}

	return $aRet;
}

function assigmentIsClosed($theAssignmentInfo) {
	return time() >= $theAssignmentInfo['deadline_date'];
}

function assigmentCountActivesByUser($theUserInfo) {
	global $gDb;
	
	$aRet 		= array();
	$aGroupId	= 0;

	if ($theUserInfo['fk_group'] != null) {
		$aGroupId = $theUserInfo['fk_group'];
	}
	
	if($aGroupId != 0) {
		$aQuery = $gDb->prepare("SELECT COUNT(*) AS info FROM assignments WHERE fk_group = ? AND ".time()." >= start_date AND ".time()." <= deadline_date");
		
		if ($aQuery->execute(array($aGroupId))) {
			while($aRow = $aQuery->fetch()) {
				$aRet = $aRow['info'];
			}
		}
	}

	return $aRet;
}
?>