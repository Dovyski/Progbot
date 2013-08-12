<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= userIsLevel($aUser, USER_LEVEL_PROFESSOR);
	$aChallengeId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	
	$aData['user'] 	= $aUser;
	
	if (!$aIsProfessor || ($aChallengeId != 0 && !challengeCanBeReviewedBy($aChallengeId, $aUser))) {
		header("Location: restricted.php");
		exit();
	}
	
	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= challengeCreateOrUpdate($aChallengeId, $_POST);
	}
	
	$aData['challengeId'] 		= $aChallengeId;
	$aData['challengeInfo'] 	= challengeGetById($aChallengeId);
	$aData['challengeLevels'] 	= $gChallengeLevels;
	
	View::render('challenges-manager', $aData);
?>