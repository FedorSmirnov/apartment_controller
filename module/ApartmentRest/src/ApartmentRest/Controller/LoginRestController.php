<?php

namespace ApartmentRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

// Klasse, damit man sich von der App aus mit Namen und Passwort einloggen kann
class LoginRestController extends AbstractRestfulController {
	protected $userTable;
	
	// Über einen Post Request werden die einggebenen Logindaten gesendet, hier überprüft und man schickt eine positive oder neegative Antwort
	public function create($data) {
		if ($data == null) {
			return;
		}
		
		$name = $data->name;
		$password = $data->password;
		
		$user = $this->getUserTable ()->findUser ( $name, $password );
		
		if ($user && $user->admin == false) {
			return new JsonModel ( array (
					
					'response' => 'positive',
					'apartment' => $user->apartment_id 
			) );
		} else {
			return new JsonModel ( array (
					
					'response' => 'negative' 
			) );
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