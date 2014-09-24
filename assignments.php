<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUser 					= userGetById($_SESSION['user']['id']);
	$aAssignments 			= challengeFindAssignmentsByUser($aUser);
	$aActiveAssignments 	= array();
	$aFinishedAssignments 	= array();
	
	foreach($aAssignments as $aIdChallenge => $aChallenge) {
		if (challengeIsAssignmentActive($aChallenge)) {
			$aActiveAssignments[$aIdChallenge] = $aChallenge;
			
		} else {
			$aFinishedAssignments[$aIdChallenge] = $aChallenge;
		}
	}

	View::render('assignments', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR,
		'assignments' 			=> $aAssignments,
		'activeAssignments'		=> $aActiveAssignments,
		'finishedAssignments'	=> $aFinishedAssignments
	));
?>