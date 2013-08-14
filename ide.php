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

		if ($aProgram == null) {
			$aProgram = codeCreate($aUserInfo['id'], $aChallengeId);
		}
	}
	
	$aData['user'] 				= $aUserInfo;
	$aData['challenge'] 		= $aChallenge;
	$aData['challengeId'] 		= $aChallengeId;
	$aData['program'] 			= $aProgram;
	$aData['shouldAutosave'] 	= $aProgram != null && @$aProgram['grade'] < 0;
	
	View::render('ide', $aData);
?>