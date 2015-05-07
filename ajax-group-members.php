<?php
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();

	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= userIsLevel($aUser, USER_LEVEL_PROFESSOR);

	if (!$aIsProfessor) {
		header("Location: restricted.php");
		exit();
	}

	$aAction	= isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	$aGroup 	= groupGetById(isset($_REQUEST['group']) ? $_REQUEST['group'] : 0);
	$aMembers	= array();

	if($aGroup != null) {
		$aUser = @$_REQUEST['user'];
		userChangeGroup($aUser, $aAction == 'add' ? $aGroup['id'] : null);

		$aMembers = userFindByGroupId($aGroup['id']);
	}

	View::render('ajax-group-members', array(
		'group' 		=> $aGroup,
		'members' 		=> $aMembers,
		'isProfessor' 	=> $aIsProfessor,
	));
?>
