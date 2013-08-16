<?php 
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$aRet = array('status' => false);

header('Content-Type: text/javascript; charset=iso-8859-1');

switch($aAction) {
	case 'savecode':
		$aProgram 	= codeGetById(@$_REQUEST['programId']);
		$aUser		= userGetById($_SESSION['user']['id']);
		$aIsOwner	= $aUser['id'] == $aProgram['fk_user'];
		$aCanEdit	= $aProgram['grade'] < 0 && !$aProgram['locked'];
		
		if($aIsOwner && $aCanEdit && challengeCanBeViewedBy($aProgram['fk_challenge'], $aUser)) {
			$aRet['status'] = codeSave($aUser['id'], $aProgram['id'], @$_REQUEST['code']);
		}
		break;
		
	case 'writereview':
	case 'changegrade':
		$aProgram 	= codeGetById(@$_REQUEST['programId']);
		$aUser		= userGetById($_SESSION['user']['id']);
		
		if(challengeCanBeReviewedBy($aProgram['fk_challenge'], $aUser)) {
			if ($aAction == 'writereview') {
				$aRet['status'] = reviewCreateOrUpdate(@$_REQUEST['id'], $aProgram['id'], $aUser['id'], '0', @$_REQUEST['comment']);
				
			} else {
				codeGrade($aProgram['id'], @$_REQUEST['grade']);
				$aRet['status'] = true;
				$aRet['grade'] = $_REQUEST['grade'];
			}
		}
		break;
		
	case 'build':
		$aProgram 	= codeGetById(@$_REQUEST['programId'], true);
		$aUser		= userGetById($_SESSION['user']['id']);
		
		if ($aProgram != null && challengeCanBeReviewedBy($aProgram['fk_challenge'], $aUser)) {
			$aCode = $aProgram['code'];
			$aFile = 'prog.c';
			$aPath = $aUser['login'] . '-' . $aProgram['id'] . '/';
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