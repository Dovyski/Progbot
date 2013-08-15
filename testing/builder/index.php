<?php

@include_once dirname(__FILE__).'/config.local.php';
@require_once dirname(__FILE__).'/config.php';

header('Content-Type: text/javascript; charset=iso-8859-1');

$aRet = array('status' => false);
// 9179692b526796c34b4e06257a6afa05
// ?code=dsdskd&file=test.c&path=/home/aluno/d12/&hash=9179692b526796c34b4e06257a6afa05

if (isset($_REQUEST['hash']) && $_REQUEST['hash']) {
	$aCode    = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
	$aFile    = isset($_REQUEST['file']) ? $_REQUEST['file'] : '';
	$aPath    = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
	$aHash	  = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : '';
	
	$aContent 		= $aCode . $aFile . $aPath;
	$aExpectedHash 	= md5($aContent . PASSWORD);
	
	if ($aHash == $aExpectedHash) {
		if ($aPath != '' && $aFile != '') {
			$aPath = $aPath[strlen($aPath) - 1] != '/' ? $aPath . '/' : $aPath;
			//system('mkdir ' . $aPath);
			echo 'mkdir ' . $aPath;
			echo $aPath . $aFile;
			//file_put_contents($aPath . $aFile, $aCode);
			//system('chown '.TEST_USER.':'.TEST_USER_GROUP.' ' . $aPath);
			echo 'chown '.TEST_USER.':'.TEST_USER_GROUP.' ' . $aPath;
			
			$aRet['status'] = true;
			$aRet['file'] = $aFile;
			$aRet['path'] = $aPath;
			
		} else {
			$aRet['msg'] = 'Invalid value for file name or path (file='.$aFile.', path='.$aPath.').';
			$aRet['error'] = 3;
		}
	} else {
		$aRet['msg'] = 'Request hash does not match.';
		$aRet['error'] = 2;
	}
} else {
	$aRet['msg'] = 'Password was not provided';
	$aRet['error'] = 1;
}

echo json_encode($aRet);
?>