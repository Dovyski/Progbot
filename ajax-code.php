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
		
		if($aIsOwner && challengeCanBeViewedBy($aProgram['fk_challenge'], $aUser)) {
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
		
	default:
		echo 'Unknown ajax option: ' + $aAction;
}

echo json_encode($aRet);

?>