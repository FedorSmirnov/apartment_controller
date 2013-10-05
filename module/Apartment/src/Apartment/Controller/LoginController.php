<?php

namespace Apartment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {
	protected $userTable;
	public function indexAction() {
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			
			$name = $request->getPost ( 'name', null );
			$password = $request->getPost ( 'password', null );
			
			if ($name != null && $password != null) {
				
				$user = $this->getUserTable ()->findUser ( $name, $password );
				
				if ($user && $user->admin == true) {
					
					return $this->redirect ()->toRoute ( 'apartment' );
				} else if ($user) {
					
					$apartment_id = ( int ) $user->apartment_id;
					
					return $this->redirect ()->toRoute ( 'enter', array (
							
							'id' => $apartment_id 
					)
					 );
				} else {
					
					$_SESSION ['errors'] = "Falscher Name und/oder Passwort. Bitte ueberpruefen Sie Ihre Eingaben.";
				}
			} else {
				$_SESSION ['errors'] = "Bitte geben Sie Ihren Nutzernamen und Ihr Passwort ein.";
			}
		}
	}
	public function getUserTable() {
		if (! $this->userTable) {
			
			$sm = $this->getServiceLocator ();
			$this->userTable = $sm->get ( 'Apartment\Model\UserTable' );
		}
		
		return $this->userTable;
	}
}

?>