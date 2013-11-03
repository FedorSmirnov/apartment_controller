<?php

namespace ApartmentTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;
use Apartment\Model\User;

class LoginControllerTest extends AbstractHttpControllerTestCase {
	protected $traceError = true;
	public function setUp() {
		$this->setApplicationConfig ( include __DIR__ . '\..\..\..\..\..\config\application.config.php' );
		parent::setUp ();
	}
	public function testIndexActionCanBeAccessed() {
		$this->dispatch ( 'http://zf2-tutorial.localhost/login' );
		$this->assertResponseStatusCode ( 200 );
		
		$this->assertModuleName ( 'Apartment' );
		$this->assertControllerName ( 'Apartment\Controller\Login' );
		$this->assertControllerClass ( 'LoginController' );
		$this->assertMatchedRouteName ( 'login' );
	}
	public function testFalseInputHandling() {
		
		// Erstellen einer Mock User Table, die auf eine Anfrage hin false zurückgibt
		$this->getMockTable ( 'Apartment\Model\UserTable', false, 'findUser' );
		
		// Test mit falschen Eingabedaten
		$postData = array (
				
				'name' => 'Fedor',
				'password' => 'bekannt',
				'login' => 'Funktionale Sicht' 
		);
		
		$this->dispatch ( 'http://zf2-tutorial.localhost/login', 'POST', $postData );
		
		$user_session = new Container ( 'user_status' );
		$this->assertFalse ( $user_session->__isset ( 'logged' ) );
		$this->assertFalse ( $user_session->__isset ( 'admin' ) );
		
		$this->assertEquals ( 'Falscher Name und/oder Passwort. Bitte ueberpruefen Sie Ihre Eingaben.', $_SESSION ['errors'] );
		
		$this->assertNotRedirect ();
		
		// Test mit leeren Eingabedaten
		$postData = array (
				
				'name' => '',
				'password' => '',
				'login' => 'Funktionale Sicht' 
		);
		
		$this->dispatch ( 'http://zf2-tutorial.localhost/login', 'POST', $postData );
		
		$user_session = new Container ( 'user_status' );
		$this->assertFalse ( $user_session->__isset ( 'logged' ) );
		$this->assertFalse ( $user_session->__isset ( 'admin' ) );
		
		$this->assertEquals ( "Bitte geben Sie Ihren Nutzernamen und Ihr Passwort ein.", $_SESSION ['errors'] );
		
		$this->assertNotRedirect ();
	}
	public function testRightInputFuncHandling() {
		
		// Erstellen einer Mock User Table, die was anderes zurückgibt
		$user = new User ();
		$user->admin = false;
		$user->apartment_id = 1;
		$user->name = 'Name';
		$user->password = 'Passwort';
		
		$this->getMockTable ( 'Apartment\Model\UserTable', $user, 'findUser' );
		
		// Eingabe der Daten
		
		$postData = array (
				
				'name' => 'Name',
				'password' => 'Passwort',
				'login' => 'Funktionale Sicht' 
		);
		
		$this->dispatch ( 'http://zf2-tutorial.localhost/login', 'POST', $postData );
		
		$user_session = new Container ( 'user_status' );
		
		$this->assertEquals ( 'funktional', $user_session->logged );
		$this->assertEquals ( 'false', $user_session->admin );
		
		$this->assertRedirectTo ( '/enter/' . $user->apartment_id );
	}
	public function testRightInputRoomHandling() {
		$user = new User ();
		$user->admin = false;
		$user->apartment_id = 1;
		$user->name = 'Name';
		$user->password = 'Passwort';
		
		$this->getMockTable ( 'Apartment\Model\UserTable', $user, 'findUser' );
		// Druck auf den anderen Schalter
		$postData = array (
				
				'name' => 'Name',
				'password' => 'Passwort',
				'login' => 'Zimmer Sicht' 
		);
		
		$this->dispatch ( 'http://zf2-tutorial.localhost/login', 'POST', $postData );
		
		$user_session = new Container ( 'user_status' );
		
		$this->assertEquals ( 'zimmerbasiert', $user_session->logged );
		$this->assertEquals ( 'false', $user_session->admin );
		
		$this->assertRedirectTo ( '/enter-loc/' . $user->apartment_id );
	}
	public function testAdminLogin() {
		$user = new User ();
		$user->admin = true;
		
		$user->name = 'Name';
		$user->password = 'Passwort';
		
		$this->getMockTable ( 'Apartment\Model\UserTable', $user, 'findUser' );
		
		$postData = array (
				
				'name' => 'Name',
				'password' => 'Passwort',
				'login' => 'Zimmer Sicht' 
		);
		
		$this->dispatch ( 'http://zf2-tutorial.localhost/login', 'POST', $postData );
		
		$user_session = new Container ( 'user_status' );
		
		$this->assertEquals ( 'true', $user_session->logged );
		$this->assertEquals ( 'true', $user_session->admin );
		
		$this->assertRedirectTo ( '/apartment/' );
	}
	private function getMockTable($original, $returnValue, $method) {
		$mock = $this->getMockBuilder ( $original )->disableOriginalConstructor ()->getMock ();
		$mock->expects ( $this->once () )->method ( $method )->will ( $this->returnValue ( $returnValue ) );
		
		$serviceManager = $this->getApplicationServiceLocator ();
		$serviceManager->setAllowOverride ( true );
		$serviceManager->setService ( $original, $mock );
	}
}

?>