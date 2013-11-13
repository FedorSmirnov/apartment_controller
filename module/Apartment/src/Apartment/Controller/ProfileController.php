<?php

namespace Apartment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Apartment\SharedFunc\SharedFunctions;

class ProfileController extends AbstractActionController {
	private $apartmentTable;
	public function indexAction() {
		
		// Checking the login data
		$sf = new SharedFunctions ();
		
		if (! $sf->checkUserLogin ( $this )) {
			$this->redirect ()->toRoute ( 'zfcuser' );
		}
		
		// Later, the user will have to define the id of his apartment during the registration process and
		// the id will be stored in the user data table
		
		$id = 28;
		
		$apartment = $this->getApartmentTable ()->getApartment ( $id );
		
		$vars = array (
				
				'user' => $sf->getUser ( $this ),
				'apartment' => $apartment 
		);
		
		return new ViewModel ( $vars );
	}
	public function getApartmentTable() {
		if (! $this->apartmentTable) {
			$sm = $this->getServiceLocator ();
			$this->apartmentTable = $sm->get ( 'Apartment\Service\ApartmentTable' );
		}
		return $this->apartmentTable;
	}
}

?>