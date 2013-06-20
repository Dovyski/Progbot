<?php 
require_once dirname(__FILE__).'/inc/globals.php';

$aAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$aRet = false;

header('Content-Type: text/javascript; charset=iso-8859-1');

switch($aAction) {
	case 'savecode':
		// TODO: check privileges
		$aRet = codeSave($_SESSION['user']['id'], @$_REQUEST['programId'], @$_REQUEST['code']);
		break;
		
	default:
		echo 'Unknown ajax option: ' + $aAction;
}

echo json_encode(array('status' => $aRet));

?>