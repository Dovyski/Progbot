<?php 
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$aRet = false;

header('Content-Type: text/javascript; charset=iso-8859-1');

switch($aAction) {
	case 'savecode':
		// TODO: check privileges and grant saving only if there is no grade.
		$aRet = codeSave($_SESSION['user']['id'], @$_REQUEST['programId'], @$_REQUEST['code']);
		break;
		
	case 'writereview':
		// TODO: check privileges
		codeGrade(@$_REQUEST['programId'], @$_REQUEST['grade']); // TODO: make grade separated from review saving.
		$aRet = reviewSave(@$_REQUEST['programId'], $_SESSION['user']['id'], '0', @$_REQUEST['comment']);
		break;
		
	default:
		echo 'Unknown ajax option: ' + $aAction;
}

echo json_encode(array('status' => $aRet));

?>