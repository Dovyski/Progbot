<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();
	
	$aData		  = array();
	$aIsReviewing = false;
	$aChallengeId = $_GET['challenge'];	
	$aChallenge   = null;
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
	
	$aData['user'] 				= $aUserInfo;
	$aData['challenge'] 		= $aChallenge;
	$aData['challengeId'] 		= $aChallengeId;
	$aData['program'] 			= $aProgram;
	$aData['reviews'] 			= reviewFindByProgramId($aProgram['id']);
	$aData['isReviewing'] 		= $aIsReviewing;
	$aData['shouldAutosave'] 	= $aProgram['grade'] < 0 && !$aIsReviewing;;
	
	View::render('code', $aData);
?>