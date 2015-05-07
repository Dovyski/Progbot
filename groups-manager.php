<?php
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();

	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= userIsLevel($aUser, USER_LEVEL_PROFESSOR);
	$aGroupId 		= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

	$aData['user'] 	= $aUser;

	if (!$aIsProfessor) {
		header("Location: restricted.php");
		exit();
	}

	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= groupCreateOrUpdate($aGroupId, $_POST);
	}

	$aData['group'] = null;
	$aData['groups'] = null;

	if($aGroupId != 0) {
		$aData['group'] = groupGetById($aGroupId);

	} else {
		$aData['groups'] = groupFindAll();
	}

	View::render('groups-manager', $aData);
?>
