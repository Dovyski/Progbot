<?php

require_once dirname(__FILE__).'/config.php';


function challengeGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM challenges WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function challengeFindActivesByUser($theUserId) {
	global $gDb;
	
	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT * FROM challenges WHERE id NOT IN (SELECT fk_challenge FROM programs WHERE fk_user = ? AND grade >= 0) AND (fk_group = ? OR fk_group IS NULL)");
	$aUserInfo	= userGetById($theUserId); // TODO: optimize it!
	$aGroupId	= 0;
	
	if ($aUserInfo['fk_group'] != null) {
		$aGroupId = $aUserInfo['fk_group'];
	}
	
	if ($aQuery->execute(array($theUserId, $aGroupId))) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function challengeFindAnsweredByUser($theUserId, $theStart = 0, $theAmount = 10) {
	global $gDb;
	
	$aRet = array();
	// TODO: filter by group?
	$aQuery = $gDb->prepare("SELECT c.id as challenge_id, c.fk_category, c.description, c.name, c.level, p.id as program_id, p.fk_user, p.date, p.last_update, p.grade FROM challenges AS c JOIN programs AS p ON c.id = p.fk_challenge WHERE p.fk_user = ? AND p.grade >= 0");
	
	if ($aQuery->execute(array($theUserId))) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['challenge_id']] = $aRow;
		}
	}
	
	return $aRet;
}

function challengeCanBeViewed($theChallengeId, $theUserInfo) {
	global $gDb;
	
	$aQuery = $gDb->prepare("SELECT id FROM challenges WHERE id = ? AND (fk_group = ? OR fk_group IS NULL)");
	$aQuery->execute(array($theChallengeId, (int)$theUserInfo['fk_group']));
	
	return $aQuery->rowCount() != 0;
}

function challengeCanBeAnswered($theChallengeId, $theUserInfo) {
	global $gDb;
	
	return true; // TODO: fix it. Can be answered if not locked/graded and challengeCanBeViewed().
}

?>