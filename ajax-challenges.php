<?php
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aChallenges 		= array();
$aMaxPages 			= 0;
$aPageSize 			= 10;
$aPage 				= isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$aType				= isset($_REQUEST['type']) ? $_REQUEST['type'] : 'actives';
$aCategory			= isset($_REQUEST['fk_category']) ? $_REQUEST['fk_category'] : 0;
$aTotalChallenges	= 0;

if($aType == 'actives') {
	// Active challenges
	$aChallenges = challengeFindActivesByUser($_SESSION['user']['id'], $aPage, $aPageSize, $aTotalChallenges, $aCategory);
} else {
	// Answered challenges
	$aChallenges = challengeFindAnsweredByUser($_SESSION['user']['id'], $aPage, $aPageSize, $aTotalChallenges);
}

$aMaxPages 	= ceil($aTotalChallenges / $aPageSize);
$aUser 		= userGetById($_SESSION['user']['id']);

View::render('ajax-challenges', array(
	'user' 					=> $aUser,
	'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR,
	'challenges' 			=> $aChallenges,
	'type' 					=> $aType,
	'page' 					=> $aPage,
	'maxPages' 				=> $aMaxPages,
	'pageSize' 				=> $aPageSize
));
?>
