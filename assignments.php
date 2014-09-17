<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aUser 				= userGetById($_SESSION['user']['id']);
	$aAssignments 		= assigmentFindByUser($aUser);
	$aChallengeIds 		= array();
	$aChallenges 		= array();

	if (count($aAssignments) > 0) {
		// Find the challenges related to the current assignment 
		foreach($aAssignments as $aAssignmentId => $aAssignmentInfo) {
			$aChallengeId = $aAssignmentInfo['fk_challenge'];
			$aChallengeIds[$aChallengeId] = true;
		}
		
		// Fetch challenge info from db
		$aChallenges = challengeFindByIdBulk(array_keys($aChallengeIds));
		
		foreach($aChallenges as $aChallengeId => $aChallengeInfo) {
			// TODO: improve this (too many queries).
			$aChallenges[$aChallengeId]['hasAnswer'] = codeGetProgramByUser($aUser['id'], $aChallengeId) != null;
		}
	}
	
	View::render('assignments', array(
		'user' 					=> $aUser,
		'isProfessor' 			=> $aUser['type'] == USER_LEVEL_PROFESSOR,
		'assignments' 			=> $aAssignments,
		'challenges' 			=> $aChallenges
	));
?>