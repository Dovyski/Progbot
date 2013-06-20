<?php

require_once dirname(__FILE__).'/config.php';

define('USER_LEVEL_STUDENT', 	1);
define('USER_LEVEL_PROFESSOR', 	2);
define('USER_LEVEL_ADMIN', 		3);

function userGetByLogin($theUserLogin) {
	global $gDb;
	
	$aUser = null;
	$aQuery = $gDb->prepare("SELECT id, name FROM users WHERE login = ?");
	
	if ($aQuery->execute(array($theUserLogin))) {	
		$aUser = $aQuery->fetch();
	}
	
	return $aUser;
}

?>