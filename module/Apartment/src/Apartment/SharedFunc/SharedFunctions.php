<?php

namespace Apartment\SharedFunc;

use Zend\Session\Container;
use ZfcUser\Controller\UserController;

class SharedFunctions {
	public function logOut($controller) {
		
		// Die Session Variablen zuruecksetzen und zurueck zum Login Bildschirm
		$user_session = new Container ( 'user_status' );
		$user_session->getManager ()->getStorage ()->clear ( 'user_status' );
		
		$controller->redirect ()->toRoute ( 'login' );
	}
	public function logOutZfcUser($controller) {
		
		// clear the session container
		$session = new Container ( 'session_data' );
		$session->getManager ()->getStorage ()->clear ( 'session_data' );
		
		// logout using the zfcUser function
		$controller->redirect ()->toRoute ( 'zfcuser/logout' );
	}
	public function checkUserLogin($controller) {
		return $controller->zfcUserAuthentication ()->hasIdentity ();
	}
	public function checkAdminUserLogin($controller) {
		$user = $controller->zfcUserAuthentication ()->getIdentity ();
		$state = $user->getState ();
		if ($state == 2) {
			return true;
		} else {
			return false;
		}
	}
}

?>