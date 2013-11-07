<?php

namespace Apartment\Controller;

use ZfcUser\Controller\UserController;
use Zend\Session\Container;
use Zend\View\Helper\ViewModel;

class Login2Controller extends UserController {
	public function indexAction() {
		if ($this->zfcUserAuthentication ()->hasIdentity ()) {
			
			$user = $this->zfcUserAuthentication ()->getIdentity ();
			$state = $user->getState ();
			if ($state == 2) {
				// State 2 means admin state
				return $this->redirect ()->toRoute ( 'apartment' );
			} else {
				
				$session = new Container ( 'session_data' );
				
				if ($session->type == 'functional') {
					
					$this->redirect ()->toRoute ( 'enter', array (
							'id' => 26 
					) );
				} elseif ($session->type == 'room') {
					
					$this->redirect ()->toRoute ( 'enter-loc', array (
							'id' => 26 
					) );
				}
			}
		} else {
			
			return $this->redirect ()->toRoute ( static::ROUTE_LOGIN );
		}
	}
	public function loginAction() {
		if ($this->zfcUserAuthentication ()->getAuthService ()->hasIdentity () && $this->zfcUserAuthenticate ()->getIdentity ()->getState () == 1) {
			
			return $this->redirect ()->toRoute ( $this->getOptions ()->getLoginRedirectRoute () );
		}
		
		$request = $this->getRequest ();
		$form = $this->getLoginForm ();
		
		if ($this->getOptions ()->getUseRedirectParameterIfPresent () && $request->getQuery ()->get ( 'redirect' )) {
			$redirect = $request->getQuery ()->get ( 'redirect' );
		} else {
			$redirect = false;
		}
		
		if (! $request->isPost ()) {
			
			return array (
					'loginForm' => $form,
					'redirect' => $redirect,
					'enableRegistration' => $this->getOptions ()->getEnableRegistration () 
			);
		}
		
		$form->setData ( $request->getPost () );
		
		if (! $form->isValid ()) {
			$this->flashMessenger ()->setNamespace ( 'zfcuser-login-form' )->addMessage ( $this->failedLoginMessage );
			return $this->redirect ()->toUrl ( $this->url ()->fromRoute ( static::ROUTE_LOGIN ) . ($redirect ? '?redirect=' . $redirect : '') );
		}
		
		// clear adapters
		$this->zfcUserAuthentication ()->getAuthAdapter ()->resetAdapters ();
		$this->zfcUserAuthentication ()->getAuthService ()->clearIdentity ();
		
		// set the view type in session
		$subname1 = $request->getPost ( 'functional' );
		$subname2 = $request->getPost ( 'room' );
		
		if ($subname1 == 'functional') {
			// function based view
			
			$session = new Container ( 'session_data' );
			$session->type = 'functional';
		} elseif ($subname2 == 'room') {
			
			// room based view
			$session = new Container ( 'session_data' );
			$session->type = 'room';
		}
		
		return $this->forward ()->dispatch ( static::CONTROLLER_NAME, array (
				'action' => 'authenticate' 
		) );
	}
}

?>