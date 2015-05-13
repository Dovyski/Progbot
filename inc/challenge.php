<?php

require_once dirname(__FILE__).'/config.php';

define('CHALLENGE_LEVEL_EASY', 		0);
define('CHALLENGE_LEVEL_MEDIUM', 	1);
define('CHALLENGE_LEVEL_HARD', 		2);

$gChallengeLevels = array(
	CHALLENGE_LEVEL_EASY 	=> 'Fácil',
	CHALLENGE_LEVEL_MEDIUM 	=> 'Médio',
	CHALLENGE_LEVEL_HARD 	=> 'Difícil',
);

function challengeLevelToString($theChallengeLevel) {
	global $gChallengeLevels;
	return isset($gChallengeLevels[$theChallengeLevel]) ? $gChallengeLevels[$theChallengeLevel] : 'Level ' . $theChallengeLevel;
}

function challengeLevelToColor($theChallengeLevel) {
	global $gChallengeLevels;
	return isset($gChallengeLevels[$theChallengeLevel]) ? $gChallengeLevels[$theChallengeLevel] : 'Level ' . $theChallengeLevel;
}

function challengeGetById($theId) {
	global $gDb;

	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM challenges WHERE id = ?");

	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}

	return $aRet;
}

function challengeCreateOrUpdate($theChallengeId, $theData) {
	global $gDb;

	$aStartDate				= time();
	$aDeadlineDate			= strtotime('+7 day');
	$aPostDeadlineDate		= 0;

	if (isset($theData['start_date'])) {
		$theData['start_date'] = implode('-', explode('/', $theData['start_date']));
		$aStartDate = strtotime($theData['start_date']);
	}

	if (isset($theData['deadline_date'])) {
		$theData['deadline_date'] = implode('-', explode('/', $theData['deadline_date']));
		$aDeadlineDate = strtotime($theData['deadline_date']);
	}

	if (isset($theData['post_deadline_date']) && $theData['post_deadline_date'] != 0) {
		$aPostDeadlineDate = $aDeadlineDate + $theData['post_deadline_date'] * 24 * 60 * 60;
	}

	$aRet					= false;
	$aId 					= $theChallengeId + 0;
	$aCategoryId 			= isset($theData['fk_category']) 			? $theData['fk_category'] 			: 0;
	$aGroupId 				= isset($theData['fk_group']) 				? $theData['fk_group'] 				: 0;
	$aDate 					= isset($theData['date']) 					? $theData['date'] 					: time();
	$aDescription 			= isset($theData['description']) 			? $theData['description'] 			: '';
	$aName 					= isset($theData['name']) 					? $theData['name'] 					: '';
	$aLevel 				= isset($theData['level']) 					? $theData['level'] 				: 0;
	$aAssignment			= isset($theData['assignment'])				? $theData['assignment']			: 0;
	$aAllowPostDeadline		= isset($theData['allow_post_deadline'])	? $theData['allow_post_deadline']	: $aPostDeadlineDate != 0;

	$aQuery = $gDb->prepare("INSERT INTO challenges
								(id, fk_category, fk_group, date, description, name, level, start_date, assignment, deadline_date, post_deadline_date, allow_post_deadline)
								VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
								ON DUPLICATE KEY UPDATE fk_category = ?, fk_group = ?, date = ?, description = ?, name = ?, level = ?, start_date = ?, assignment = ?, deadline_date = ?, post_deadline_date = ?, allow_post_deadline = ?");

	if(strlen($aName) > 0 && strlen($aDescription) > 0) {
		$aParams = array($aId, $aCategoryId, $aGroupId, $aDate, $aDescription, $aName, $aLevel, $aStartDate, $aAssignment, $aDeadlineDate, $aPostDeadlineDate, $aAllowPostDeadline,
						 $aCategoryId, $aGroupId, $aDate, $aDescription, $aName, $aLevel, $aStartDate, $aAssignment, $aDeadlineDate, $aPostDeadlineDate, $aAllowPostDeadline);

		$aQuery->execute($aParams);
		$aRet = $aQuery->rowCount();
	}

	return $aRet;
}

function challengeFindActivesByUser($theUserId, $thePage, $thePageSize, & $theTotalChallenges, $theCategoryId) {
	global $gDb;

	$aCatComp	= $theCategoryId == 0 ? '>=' : '=';
	$thePage	= (int)$thePage;
	$thePageSize= (int)$thePageSize;
	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT COUNT(*) AS count FROM challenges WHERE fk_category ".$aCatComp." ? AND id NOT IN (SELECT fk_challenge FROM programs WHERE fk_user = ? AND grade >= 0) AND (fk_group = ? OR fk_group IS NULL) AND start_date <= " . time());
	$aUserInfo	= userGetById($theUserId); // TODO: optimize it!
	$aGroupId	= 0;

	if ($aUserInfo['fk_group'] != null) {
		$aGroupId = $aUserInfo['fk_group'];
	}

	$theTotalChallenges = 0;
	$thePage = $thePage * $thePageSize;

	if ($aQuery->execute(array($theCategoryId, $theUserId, $aGroupId))) {
		$aRow = $aQuery->fetch();
		$theTotalChallenges = $aRow['count'];

		$aQuery = $gDb->prepare("SELECT * FROM challenges WHERE fk_category ".$aCatComp." ? AND id NOT IN (SELECT fk_challenge FROM programs WHERE fk_user = ? AND grade >= 0) AND (fk_group = ? OR fk_group IS NULL) LIMIT ".$thePage."," . $thePageSize);

		if ($aQuery->execute(array($theCategoryId, $theUserId, $aGroupId))) {
			while($aRow = $aQuery->fetch()) {
				$aRet[$aRow['id']] = $aRow;
			}
		}
	}

	return $aRet;
}

function challengeFindAssignmentsByUser($theUserInfo) {
	global $gDb;

	$aRet 		= array();
	$aGroupId	= 0;

	if ($theUserInfo['fk_group'] != null) {
		$aGroupId = $theUserInfo['fk_group'];
	}

	$aQuery = $gDb->prepare("SELECT
								c.*, p.id AS program_id
							FROM
								challenges AS c
							LEFT JOIN programs AS p
								ON p.fk_challenge = c.id
							WHERE
								(fk_group = ? OR fk_group IS NULL) AND assignment <> 0 AND ".time()." >= start_date
							");

	if ($aQuery->execute(array($aGroupId))) {
		while($aRow = $aQuery->fetch(PDO::FETCH_ASSOC)) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

function challengeIsAssignmentActive($theChallengeInfo) {
	return time() >= $theChallengeInfo['start_date'] && (time() <= $theChallengeInfo['deadline_date'] || ($theChallengeInfo['allow_post_deadline'] && time() <= $theChallengeInfo['post_deadline_date']));
}

function challengeCountActiveAssignmentsByUser($theUserInfo) {
	global $gDb;

	$aRet 		= 0;
	$aGroupId	= 0;

	if ($theUserInfo['fk_group'] != null) {
		$aGroupId = $theUserInfo['fk_group'];
	}

	if($aGroupId != 0) {
		$aQuery = $gDb->prepare("SELECT COUNT(*) AS info FROM challenges WHERE (fk_group = ? OR fk_group IS NULL) AND assignment <> 0 AND ".time()." >= start_date AND ".time()." <= deadline_date");

		if ($aQuery->execute(array($aGroupId))) {
			$aRow = $aQuery->fetch();
			$aRet = $aRow['info'];
		}
	}

	return $aRet;
}

function challengeFindByGroup($theGroupId, $theIncludePublic = true) {
	global $gDb;

	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT * FROM challenges WHERE fk_group = ?" . ($theIncludePublic ? " OR fk_group IS NULL" : ""));

	if ($aQuery->execute(array($theGroupId))) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

function challengeFindByIdBulk($theChallengeIds) {
	global $gDb;

	$aRet 		= array();
	$aIds		= implode(',', $theChallengeIds); // TODO: sanitize this!
	$aQuery 	= $gDb->prepare("SELECT * FROM challenges WHERE id IN (".$aIds.")");

	if ($aQuery->execute()) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

function challengeFindAnswersById($theChallengeId) {
	global $gDb;

	$aRet 		= array();
	$aQuery 	= $gDb->prepare("SELECT id, fk_user, last_update, grade, locked FROM programs WHERE fk_challenge = ?");

	if ($aQuery->execute(array($theChallengeId))) {
		while($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}

	return $aRet;
}

function challengeFindAnsweredByUser($theUserId, $thePage, $thePageSize, & $theTotalChallenges) {
	global $gDb;

	$thePage		= (int)$thePage;
	$thePageSize	= (int)$thePageSize;
	$aRet 			= array();
	// TODO: filter by group?
	$aQuery = $gDb->prepare("SELECT COUNT(*) AS count FROM challenges AS c JOIN programs AS p ON c.id = p.fk_challenge WHERE p.fk_user = ? AND p.grade >= 0");

	$theTotalChallenges = 0;
	$thePage = $thePage * $thePageSize;

	if ($aQuery->execute(array($theUserId))) {
		$aRow = $aQuery->fetch();
		$theTotalChallenges = $aRow['count'];

		$aQuery = $gDb->prepare("SELECT c.id as challenge_id, c.fk_category, c.description, c.name, c.level, p.id as program_id, p.fk_user, p.date, p.last_update, p.grade FROM challenges AS c JOIN programs AS p ON c.id = p.fk_challenge WHERE p.fk_user = ? AND p.grade >= 0 LIMIT ".$thePage.",".$thePageSize);

		if ($aQuery->execute(array($theUserId))) {
			while($aRow = $aQuery->fetch()) {
				$aRet[$aRow['challenge_id']] = $aRow;
			}
		}
	}

	return $aRet;
}

function challengeCanBeViewedBy($theChallengeId, $theUserInfo) {
	global $gDb;

	$aQuery = $gDb->prepare("SELECT id FROM challenges WHERE id = ? AND (fk_group = ? OR fk_group IS NULL)");
	$aQuery->execute(array($theChallengeId, (int)$theUserInfo['fk_group']));

	return $aQuery->rowCount() != 0;
}

function challengeCanBeReviewedBy($theChallengeId, $theUserInfo) {
	global $gDb;

	$aRet = false;

	if ($theUserInfo['type'] == USER_LEVEL_PROFESSOR) {
		$aQuery = $gDb->prepare("SELECT id FROM challenges WHERE id = ? AND (fk_group = ? OR fk_group IS NULL)");
		$aQuery->execute(array($theChallengeId, (int)$theUserInfo['fk_group']));

		$aRet = $aQuery->rowCount() != 0;
	}

	return $aRet;
}
?>
