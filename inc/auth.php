<?php

require_once dirname(__FILE__).'/config.php';


function authIsValidUser($theUser, $thePassword) {
	return true;
}

function authLogin($theUser) {
	$_SESSION['logado'] = true;
	$_SESSION['user'] = array('name' => 'John Doe', 'id' => 1); // TODO: fix this and get real user info.
}

function authAllowNonAuthenticated() {
	if(authIsAuthenticated()) {
		header('Location: ' . (authIsAdmin() ? 'admin.index.php' : 'index.php'));
		exit();
	}
}

function authAllowAdmin() {
	if(!authIsLogado()) {
		header('Location: login.php');
		exit();
		
	} else if(!authIsAdmin()){
		header('Location: restrito.php');
		exit();
	}
}

function authAllowAuthenticated() {
	if(!authIsLogado()) {
		header('Location: login.php');
		exit();
	}
}

function authLogout() {
	unset($_SESSION);
	session_destroy();
}

function authIsAuthenticated() {
	return isset($_SESSION['logado']) && $_SESSION['logado'];
}

function authIsAdmin() {
	return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
}

?>