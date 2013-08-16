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
	
	if ($aHash == $aExpectedHash || IGNORE_HASH) {
		if ($aPath != '' && $aFile != '') {
			$aPath 			= $aPath[strlen($aPath) - 1] != '/' ? $aPath . '/' : $aPath;
			$aRet['path'] 	= DEPLOY_DIR . $aPath;
			$aRet['status'] = true;
			$aRet['file'] 	= $aFile;
			
			$aPath = dirname(__FILE__) . '/tmp/' . $aPath;
			
			system('mkdir ' . $aPath);
			file_put_contents($aPath . $aFile, $aCode);
			system('sudo ' . dirname(__FILE__) . '/mv.php');
			
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

echo serialize($aRet);
?>
