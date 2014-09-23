<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();
	
	$aData		  = array();
	$aIsReviewing = false;
	$aChallengeId = $_GET['challenge'];	
	$aChallenge   = null;	
	$aUserId 	  = $_SESSION['user']['id'];
	$aProgram	  = null;

	$aUserInfo	= userGetById($aUserId);
	
	if (challengeCanBeViewedBy($aChallengeId, $aUserInfo)) {
		$aChallenge = challengeGetById($aChallengeId);
		$aProgram 	= codeGetProgramByUser($aUserInfo['id'], $aChallengeId);

		if ($aChallenge != null && $aProgram == null) {
			$aProgram = codeCreate($aUserInfo['id'], $aChallengeId);
		}
	}
	
	if ($aChallenge == null) {
		header('Location: restricted.php');
		exit();
	}
	
	$aData['user'] 				= $aUserInfo;
	$aData['challenge'] 		= $aChallenge;
	$aData['challengeId'] 		= $aChallengeId;
	$aData['isAssignment'] 		= $aChallenge['assignment'] != 0;
	$aData['program'] 			= $aProgram;
	$aData['canEdit'] 			= true || $aProgram != null && @$aProgram['grade'] < 0 && (!$aData['isAssignment'] || !challengeIsAssignmentClosed($aChallenge));
	
	View::render('ide/index', $aData);
?>