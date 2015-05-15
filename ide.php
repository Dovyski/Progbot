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
		echo 'Desafio invalido!';
		exit();
	}

	$aParams = '';
	$aParams .= 'challenge=' 	. $aChallengeId . '&';
	$aParams .= 'program=' 		. $aProgram['id'] . '&';
	$aParams .= 'assignment=' 	. ($aChallenge['assignment'] != 0 ? 'true' : 'false') . '&';
	$aParams .= 'canEdit=' 		. (codeCanBeEdited($aProgram, $aChallenge) ? 'true' : 'false');

	header('Location: view/html/ide/codebot/?' . $aParams);
	exit();
?>
