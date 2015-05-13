<?php
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$aRet = array('status' => false);

header('Content-Type: text/javascript; charset=iso-8859-1');

switch($aAction) {
	case 'savecode':
		$aChallenge = challengeGetById(@$_REQUEST['challenge']);

		if($aChallenge != null) {
			$aProgram 	= codeGetById(@$_REQUEST['programId']);
			$aUser		= userGetById($_SESSION['user']['id']);

			if ($aProgram == null) {
				$aProgram = codeCreate($aUser['id'], $aChallenge['id']);
			}

			$aIsOwner	= $aUser['id'] == $aProgram['fk_user'];
			$aCanEdit	= codeCanBeEdited($aProgram, $aChallenge);

			if ($aIsOwner && $aCanEdit && challengeCanBeViewedBy($aProgram['fk_challenge'], $aUser)) {
				$aRet['status'] = codeSave($aUser['id'], $aProgram['id'], @$_REQUEST['code']);
			}
		}
		break;

	case 'writecomment':
	case 'changegrade':
		$aProgram 	= codeGetById(@$_REQUEST['programId']);
		$aUser		= userGetById($_SESSION['user']['id']);

		if ($aAction == 'writecomment') {
			if(challengeCanBeViewedBy($aProgram['fk_challenge'], $aUser)) {
				$aRet['status'] = reviewCreateOrUpdate(@$_REQUEST['id'], $aProgram['id'], $aUser['id'], '0', @$_REQUEST['comment']);
			} else {
				$aRet['msg'] = 'Você não tem permissão para comentar esse desafio';
			}

		} else if($aAction == 'changegrade') {
			if(challengeCanBeReviewedBy($aProgram['fk_challenge'], $aUser)) {
				codeGrade($aProgram['id'], @$_REQUEST['grade']);
				$aRet['status'] = true;
				$aRet['grade'] = $_REQUEST['grade'];

			} else {
				$aRet['msg'] = 'Você não tem permissão para alterar a nota desse desafio';
			}
		}
		break;

	case 'build':
		$aProgram 	= codeGetById(@$_REQUEST['programId'], true);
		$aUser		= userGetById($_SESSION['user']['id']);

		if ($aProgram != null && challengeCanBeReviewedBy($aProgram['fk_challenge'], $aUser)) {
			$aCode = $aProgram['code'];
			$aFile = 'prog.c';
			$aPath = userLoginfyName($aUser['name']) . '/' . $aProgram['id'] . '/';
			$aHash = md5($aCode . $aFile . $aPath . TESTING_TTY_PASSWORD);

			$aRet = buildSendRequest(TESTING_TTY_DEPLOY_URL, $aCode, $aFile, $aPath, $aHash);
			$aRet = @unserialize($aRet);
		}
		break;

	default:
		echo 'Unknown ajax option: ' + $aAction;
}

echo json_encode($aRet);

?>
