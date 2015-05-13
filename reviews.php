<?php
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();

	$aUser = userGetById($_SESSION['user']['id']);

	if (!userIsLevel($aUser, USER_LEVEL_PROFESSOR)) {
		header("Location: restricted.php");
		exit();
	}

	$aData					= array();
	$aChallengeId 			= isset($_GET['challenge']) ? $_GET['challenge'] : 0;
	$aUserInfo				= userGetById($_SESSION['user']['id']);

	if ($aChallengeId != 0) {
		// Showing all answers of a challenge
		$aData['challenge'] = challengeGetById($aChallengeId);
		$aData['answers'] 	= challengeFindAnswersById($aChallengeId);

	} else {
		// Showing all challenges of user's group
		$aData['challenges'] = challengeFindByGroup($aUserInfo['fk_group']);
		$aData['group'] = groupGetById($aUserInfo['fk_group']);
	}

	$aData['challengeId']	= $aChallengeId;
	$aData['user']	 		= $aUserInfo;

	View::render('reviews', $aData);
?>
