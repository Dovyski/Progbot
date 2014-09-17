<?php

require_once dirname(__FILE__).'/config.php';


function assigmentGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM challenges WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function assigmentFindByUser($theUser) {
	global $gDb;
	
	$aRet 		= array();
	$aGroupId	= 0;

	if ($theUser['fk_group'] != null) {
		$aGroupId = $theUser['fk_group'];
	}
	
	if($aGroupId != 0) {
		$aQuery = $gDb->prepare("SELECT * FROM assignments WHERE fk_group = ?");
		
		if ($aQuery->execute(array($aGroupId))) {
			while($aRow = $aQuery->fetch()) {
				$aRet[$aRow['id']] = $aRow;
			}
		}
	}

	return $aRet;
}

function assigmentIsClosed($theAssignmentInfo) {
	return time() >= $theAssignmentInfo['deadline_date'];
}

function assigmentCountActivesByUserId($theUserId) {
	// TODO: implement this!
	return 1;
}
?>