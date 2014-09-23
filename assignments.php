<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUser 				= userGetById($_SESSION['user']['id']);
	$aAssignments 		= challengeFindAssignmentsByUser($aUser);

	View::render('assignments', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR,
		'assignments' 			=> $aAssignments
	));
?>