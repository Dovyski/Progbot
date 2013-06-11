<?php

require_once dirname(__FILE__).'/config.php';


function challengeGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM challenges WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

?>