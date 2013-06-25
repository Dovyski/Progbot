<?php

require_once dirname(__FILE__).'/config.php';

function reviewFindByProgramId($theProgramId) {
	global $gDb;
	
	$aReviews = null;
	$aQuery = $gDb->prepare("SELECT * FROM reviews WHERE fk_program = ?");
	
	if ($aQuery->execute(array($theProgramId))) {	
		while ($aRow = $aQuery->fetch()) {
			$aReviews[] = $aRow;
		}
	}
	
	return $aReviews;
}

function reviewCreateOrUpdate($theReviewId, $theProgramId, $theUserId, $theMeta, $theComment) {
	global $gDb;
	
	$aQuery = $gDb->prepare("INSERT INTO reviews (id, fk_program, fk_user, meta, comment) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE fk_program = ?, fk_user = ?, meta = ?, comment = ?");
	$aQuery->execute(array((int)$theReviewId, $theProgramId, $theUserId, $theMeta, $theComment, $theProgramId, $theUserId, $theMeta, $theComment));
	
	return $aQuery->rowCount();
}

?>