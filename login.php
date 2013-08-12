<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowNonAuthenticated();
	$aLoginError = false;
	
	if(count($_POST) > 0) {
		if (isset($_POST['user'], $_POST['password'])) {
			
			// TODO: fix this because the login string might have . and -
			$aCpf = str_replace(array('.', '-', ' '), '', $_POST['user']);
			$aCpf = ltrim($aCpf,  '0');
			
			$aHasAccount = authIsValidUser($aCpf, $_POST['password']);
			$aUser = '';
			
			if ($aHasAccount) {
				$aUser = $aCpf;	

			} else {
				// TODO: it would be nice to have some sort of auth plugins here :)
				$aMoodleInfo = authLoginUsingMoodle($aCpf, $_POST['password']);
				
				if ($aMoodleInfo != null) {
					$aHasAccount = authCreateLocalAccountUsingLoginMoodle($aMoodleInfo, $aCpf, $_POST['password']);
				
					if($aHasAccount) {
						$aUser = $aCpf;
					}
				} else {
					$aLoginError = true;
				}
			}
			
			if($aHasAccount) {
				authLogin($aUser);
				header('Location: challenges.php');
				exit();
			}
		} else {
			$aLoginError = true;
		}
	}
	
	View::render('login', array(
		'loginError' => $aLoginError
	));
?>