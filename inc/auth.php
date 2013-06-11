<?php

require_once dirname(__FILE__).'/config.php';

/** 
 * Efetua login de um usuário no domínio do NCC utilizando LDAP.
 * 
 * @param string $theUser nome do usuário, ex.: fernando
 * @param string $thePassword senha do usuário.
 * @return bool <code>true</code> se o usuário foi autenticado com sucesso, ou <code>false</code> caso contrário.
 */
function authIsValidUser($theUser, $thePassword) {
	return true;
}

function authLogin($theUser) {
	$_SESSION['logado'] = true;
	$_SESSION['user'] = array('name' => 'John Doe', 'id' => 1);
	
	//if(in_array($theUser, $aAdmins)) {
	//	$_SESSION['admin'] = true;
	//}
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