<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUser = userGetById($_SESSION['user']['id']);
	
	View::render('challenges', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR,
		'activeChallenges' 		=> challengeFindActivesByUser($_SESSION['user']['id']),
		'answeredChallenges' 	=> challengeFindAnsweredByUser($_SESSION['user']['id'])
	));
?>