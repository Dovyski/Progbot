<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();
	
	$aData		  = array();
	$aIsReviewing = false;
	$aChallengeId = $_GET['challenge'];	
	$aChallenge   = null;
	$aProgram	  = null;
	$aUserId	  = 0;
	
	if (isset($_GET['user'])) {
		// Someone is trying to review something specific. We must check if
		// the authenticated user has privileges to review that code.
		$aAuthedUserInfo = userGetById($_SESSION['user']['id']);
		
		if(challengeCanBeReviewedBy($aChallengeId, $aAuthedUserInfo)) {
			$aIsReviewing 	= true;
			$aUserId 		= $_GET['user'];
		}
	} else {
		// The page is being access by the answer owner, which is the 
		// currently authenticated user.
		$aUserId = $_SESSION['user']['id'];
	}

	$aUserInfo	= userGetById($aUserId);
	
	if ($aIsReviewing || challengeCanBeViewedBy($aChallengeId, $aUserInfo)) {
		$aChallenge = challengeGetById($aChallengeId);
		$aProgram 	= codeGetProgramByUser($aUserInfo['id'], $aChallengeId);

		if ($aProgram == null && !$aIsReviewing) {
			$aProgram = codeCreate($aUserInfo['id'], $aChallengeId);
		}
	}
	
	// Get information related to assignment for this challenge.
	$aAssignment 	= assigmentGetByChallengeAndGroup($aChallengeId, $aUserInfo['fk_group']);
	$aHasAssignment = !assigmentIsClosed($aAssignment);	
	
	$aData['user'] 				= $aUserInfo;
	$aData['challenge'] 		= $aChallenge;
	$aData['challengeId'] 		= $aChallengeId;
	$aData['program'] 			= $aProgram;
	$aData['reviews'] 			= $aProgram != null ? reviewFindByProgramId($aProgram['id']) : null;
	$aData['isReviewing'] 		= $aIsReviewing;
	$aData['shouldAutosave'] 	= $aProgram != null && $aProgram['grade'] < 0 && !$aIsReviewing;
	$aData['tty'] 				= TESTING_TTY_URL;
	$aData['assignment']		= $aAssignment;
	$aData['hasAssignment']		= $aHasAssignment;
	$aData['tab']				= isset($_GET['tab']) ? (int)$_GET['tab'] : 0;
	
	View::render('code', $aData);
?>