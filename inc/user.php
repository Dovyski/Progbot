<?php

require_once dirname(__FILE__).'/config.php';

define('USER_LEVEL_STUDENT', 	1);
define('USER_LEVEL_PROFESSOR', 	2);
define('USER_LEVEL_ADMIN', 		3);

function userGetById($theUserId) {
	global $gDb;
	
	$aUser = null;
	$aQuery = $gDb->prepare("SELECT id, fk_group, login, name, email, type FROM users WHERE id = ?");
	
	if ($aQuery->execute(array($theUserId))) {	
		$aUser = $aQuery->fetch();
	}
	
	return $aUser;
}

?>