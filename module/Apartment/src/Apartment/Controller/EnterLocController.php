<?php

namespace Apartment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Config\Config;
use Apartment\SharedFunc\SharedFunctions;

class EnterLocController extends AbstractActionController {
	protected $apartmentTable;
	protected $roomTable;
	public function indexAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		
		$sf = new SharedFunctions();
		
		if (! $sf->checkUserLogin($this)) {
			$this->redirect ()->toRoute ( 'zfcuser' );
		}
		
		// // Holen und Ueberpruefen der Session Variablen
		// $user_session = new Container ( 'user_status' );
		// $logged = $user_session->logged;
		// $admin = $user_session->admin;
		
		// // Rausschmeissen wenn nicht eingeloggt
		// if ($logged != "zimmerbasiert") {
		// $this->redirect ()->toRoute ( 'login' );
		// }
		
		// // Wenn nicht admin und in der falschen Wohnung auch raus
		// if ($admin != "true") {
		// $apartment_id = $user_session->apartment_id;
		// if ($apartment_id != $id) {
		// $this->redirect ()->toRoute ( 'login' );
		// }
		// }
		
		$apartment = $this->getApartmentTable ()->getApartment ( $id );
		$rooms = $this->getRoomTable ()->getApartmentRooms ( $apartment->id );
		
		$vars = array (
				
				'apartment' => $apartment,
				'rooms' => $rooms,
				
		);
		
		return new ViewModel ( $vars );
	}
	public function logoutAction() {
		$sf = new SharedFunctions ();
		
		$sf->logOutZfcUser ( $this );
	}
	public function getApartmentTable() {
		if (! $this->apartmentTable) {
			$sm = $this->getServiceLocator ();
			$this->apartmentTable = $sm->get ( 'Apartment\Service\ApartmentTable' );
		}
		
		return $this->apartmentTable;
	}
	public function getRoomTable() {
		if (! $this->roomTable) {
			
			$sm = $this->getServiceLocator ();
			$this->roomTable = $sm->get ( 'Apartment\Service\RoomTable' );
		}
		
		return $this->roomTable;
	}
}

?>
