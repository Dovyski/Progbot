<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUserId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user']['id'];
	
	// Get user info
	$aUser = userGetById($aUserId);
	
	View::render('user', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR
	));
?>