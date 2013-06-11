<?php

require_once dirname(__FILE__).'/config.php';

function codeSave($theUserId, $theProgramId, $theCode) {
	global $gDb;

	$aQuery = $gDb->prepare("UPDATE programs SET code = ?, last_update = ? WHERE id = ? AND fk_user = ?");
	$aRet   = false;
	
	$aQuery->execute(array($theCode, time(), $theProgramId, $theUserId));
	
	if ($aQuery->rowCount()) {
		$aRet = true;
	}
	
	return $aRet;
}

function codeGetProgramByUser($theUserId, $theChallengeId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT id, date, code, last_update, grade, locked FROM programs WHERE fk_challenge = ? AND fk_user = ?");
	
	if ($aQuery->execute(array($theChallengeId, $theUserId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function codeCreate($theUserId, $theChallengeId) {
	global $gDb;

	$aQuery = $gDb->prepare("INSERT INTO programs (id, fk_user, fk_challenge, date, code, code_history, last_update, grade, locked) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
	$aRet   = null;
	
	if($aQuery->execute(array($theUserId, $theChallengeId, time(), '', '', time(), -1, 0))) {	
		$aRet = codeGetProgramByUser($theUserId, $theChallengeId);
	}
	
	return $aRet;
}

?>