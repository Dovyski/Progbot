<?php
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();

	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsProfessor 	= userIsLevel($aUser, USER_LEVEL_PROFESSOR);
	$aCategoryId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

	$aData['user'] 	= $aUser;

	if (!$aIsProfessor) {
		header("Location: restricted.php");
		exit();
	}

	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= categoryCreateOrUpdate($aCategoryId, $_POST);
	}

	$aData['categoryId'] 		= $aCategoryId;
	$aData['categoryInfo'] 		= categoryGetById($aCategoryId);

	View::render('categories-manager', $aData);
?>
