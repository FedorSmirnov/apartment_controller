<?php

namespace Apartment;

use Apartment\Entity\Apartment;
use Apartment\Service\ApartmentTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Apartment\Service\UserTable;
use Apartment\Entity\User;
use Apartment\Service\RoomTable;
use Apartment\Entity\Room;
use Zend\EventManager\Event;
use Zend\Form\Form;
use Zend\Form\Element;

class Module {
	public function getAutoloaderConfig() {
		return array (
				
				'Zend\Loader\ClassMapAutoloader' => array (
						
						__DIR__ . '/autoload_classmap.php' 
				),
				
				'Zend\Loader\StandardAutoloader' => array (
						
						'namespaces' => array (
								
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array (
				
				'factories' => array (
						
						'Apartment\Service\ApartmentTable' => function ($sm) {
							
							$tableGateway = $sm->get ( 'ApartmentTableGateway' );
							$table = new ApartmentTable ( $tableGateway );
							return $table;
						},
						'ApartmentTableGateway' => function ($sm) {
							
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Apartment () );
							return new TableGateway ( 'apartments', $dbAdapter, null, $resultSetPrototype );
						},
						'Apartment\Service\UserTable' => function ($sm) {
							
							$tableGateway = $sm->get ( 'UserTableGateway' );
							$table = new UserTable ( $tableGateway );
							return $table;
						},
						'UserTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new User () );
							return new TableGateway ( 'users', $dbAdapter, null, $resultSetPrototype );
						},
						'Apartment\Service\RoomTable' => function ($sm) {
							$tableGateway = $sm->get ( 'RoomTableGateway' );
							$table = new RoomTable ( $tableGateway );
							return $table;
						},
						'RoomTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Room () );
							return new TableGateway ( 'rooms', $dbAdapter, null, $resultSetPrototype );
						} 
				) 
		);
	}
	
	// This function reacts to the init() of the zfcuser form and is used to alter it
	public function onBootstrap($e) {
		$events = $e->getApplication ()->getEventManager ()->getSharedManager ();
		
		$events->attach ( 'ZfcUser\Form\Login', 'init', function ($e) {
			
			$form = $e->getTarget ();
			
			// Adjust the label of the pw field
			$pwelement = $form->get ( 'credential' );
			$pwelement->setLabel ( 'Passwort' );
			
			// Remove the sign in button
			$form->remove ( 'submit' );
			
			// Add the buttons for the room- and function-based views
			$submitElementFunc = new Element\Button ( 'functional' );
			$submitElementRoom = new Element\Button ( 'room' );
			
			$submitElementFunc->setLabel ( 'Funktionale Sicht' );
			$submitElementFunc->setAttribute ( 'type', 'submit' );
			$submitElementFunc->setAttribute ( 'value', 'functional' );
			
			$submitElementRoom->setLabel ( 'Raumbasierte Sicht' );
			$submitElementRoom->setAttribute ( 'type', 'submit' );
			$submitElementRoom->setAttribute ( 'value', 'room' );
			
			$form->add ( $submitElementFunc );
			$form->add ( $submitElementRoom );
		} );
	}
}

?>