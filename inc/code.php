<?php

require_once dirname(__FILE__).'/config.php';

function codeSave($theUserId, $theProgramId, $theCode) {
	global $gDb;

	$aQuery = $gDb->prepare("UPDATE programs SET code = ?, last_update = ? WHERE id = ? AND fk_user = ?");
	$aQuery->execute(array($theCode, time(), $theProgramId, $theUserId));
	
	return $aQuery->rowCount() != 0;
}

function codeGrade($theProgramId, $theGrade) {
	global $gDb;

	$aQuery = $gDb->prepare("UPDATE programs SET grade = ? WHERE id = ?");
	$aQuery->execute(array($theGrade, $theProgramId));
	
	return $aQuery->rowCount();
}

function codeGetProgramByUser($theUserId, $theChallengeId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT id, fk_user, date, code, last_update, grade, locked FROM programs WHERE fk_challenge = ? AND fk_user = ?");
	
	if ($aQuery->execute(array($theChallengeId, $theUserId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function codeGetById($theProgramId, $theComplete = false) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT ".($theComplete ? "*" : "id, fk_user, fk_challenge, date, last_update, grade, locked")." FROM programs WHERE id = ?");
	
	if ($aQuery->execute(array($theProgramId))) {
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

function codeCanBeEdited($theProgramInfo, $theChallengeInfo) {
	return (!$theChallengeInfo['assignment'] || challengeIsAssignmentActive($theChallengeInfo)) && ($theProgramInfo == null || $theProgramInfo['grade'] < 0);
}

?>