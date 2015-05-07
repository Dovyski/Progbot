<?php
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();

	$aUserId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user']['id'];

	// Get user info
	$aUser = userGetById($aUserId);

	// Get authenticated user info
	$aAuthUser 		= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= $aAuthUser['type'] == USER_LEVEL_PROFESSOR;
	$aGroups		= array();

	if($aIsProfessor) {
		$aGroups = array();
	}

	View::render('user', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR
	));
?>
