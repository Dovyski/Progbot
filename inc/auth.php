<?php

require_once dirname(__FILE__).'/config.php';


function authIsValidUser($theUserLogin, $thePassword) {
	global $gDb;
	
	$aQuery = $gDb->prepare("SELECT id FROM users WHERE login = ? AND password = ?");
	$aRet = false;
	
	if ($aQuery->execute(array($theUserLogin, $thePassword))) { // TODO: password hash!
		$aRet = true;
	}
	
	return $aRet;
}

function authLogin($theUserLogin) {
	global $gDb;
	
	$aQuery = $gDb->prepare("SELECT id, name, type FROM users WHERE login = ?");
	
	if ($aQuery->execute(array($theUserLogin))) {	
		$aUser = $aQuery->fetch();
		
		$_SESSION['authenticaded'] = true;
		$_SESSION['user'] = array('name' => $aUser['name'], 'id' => $aUser['id'], 'type' => $aUser['type']);
	}
}

function authAllowNonAuthenticated() {
	if(authIsAuthenticated()) {
		header('Location: ' . (authIsAdmin() ? 'admin.index.php' : 'index.php'));
		exit();
	}
}

function authAllowAdmin() {
	if(!authIsAuthenticated()) {
		header('Location: login.php');
		exit();
		
	} else if(!authIsAdmin()){
		header('Location: restricted.php');
		exit();
	}
}

function authAllowAuthenticated() {
	if(!authIsAuthenticated()) {
		header('Location: login.php');
		exit();
	}
}

function authLogout() {
	unset($_SESSION);
	session_destroy();
}

function authIsAuthenticated() {
	return isset($_SESSION['authenticaded']) && $_SESSION['authenticaded'];
}

function authIsAdmin() {
	return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
}

?>