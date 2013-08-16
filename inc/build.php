<?php

function buildSendRequest($theURL, $theCode, $theFile, $thePath, $theHash) {
	$aCh = curl_init();

	curl_setopt($aCh, CURLOPT_URL, $theURL);
	curl_setopt($aCh, CURLOPT_POST, 1);
	curl_setopt($aCh, CURLOPT_POSTFIELDS, http_build_query(array('code' => $theCode, 'file' => $theFile, 'path' => $thePath, 'hash' => $theHash)));
	curl_setopt($aCh, CURLOPT_RETURNTRANSFER, true);

	$aRet = curl_exec($aCh);
	curl_close($aCh);

	return $aRet;
}

?>