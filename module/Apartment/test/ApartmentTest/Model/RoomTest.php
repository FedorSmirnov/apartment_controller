<?php

namespace ApartmentTest\Model;

use Apartment\Model\Room;

class RoomTest extends \PHPUnit_Framework_TestCase {
	public function testRoomInitialState() {
		$room = new Room ();
		
		$this->assertNull ( $room->apartment_id );
		$this->assertNull ( $room->light );
		$this->assertNull ( $room->name );
		$this->assertNull ( $room->power_device );
		$this->assertNull ( $room->power_light );
		$this->assertNull ( $room->power_temperature );
		$this->assertNull ( $room->temperature );
		$this->assertNull ( $room->temperature_outside );
	}
	public function exchangeArraySetsValuesProperly() {
		$data = $this->buildRoomData ();
		
		$room = new Room ();
		
		$room->exchangeArray ( $data );
		
		$this->assertSame ( $data ['apartment_id'], $room->apartment_id );
		$this->assertSame ( $data ['light'], $room->light );
		$this->assertSame ( $data ['name'], $room->name );
		$this->assertSame ( $data ['power_device'], $room->power_device );
		$this->assertSame ( $data ['power_light'], $room->power_light );
		$this->assertSame ( $data ['power_temperature'], $room->power_temperature );
		$this->assertSame ( $data ['temperature'], $room->temperature );
		$this->assertSame ( $data ['temperature_outside'], $room->temperature_outside );
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$data = $this->buildRoomData ();
		
		$room = new Room ();
		
		$room->exchangeArray ( $data );
		$room->exchangeArray ( array () );
		
		$this->assertNull ( $room->apartment_id );
		$this->assertNull ( $room->light );
		$this->assertNull ( $room->name );
		$this->assertNull ( $room->power_device );
		$this->assertNull ( $room->power_light );
		$this->assertNull ( $room->power_temperature );
		$this->assertNull ( $room->temperature );
		$this->assertNull ( $room->temperature_outside );
	}
	public function testPrepareData() {
		$room = new Room ();
		
		$room->prepareData ();
		
		$this->assertEquals ( 0, $room->power_light );
		$this->assertEquals ( 0, $room->power_device );
		$this->assertEquals ( 0, $room->power_temperature );
		$this->assertEquals ( 0, $room->temperature );
		$this->assertEquals ( 0, $room->temperature_outside );
		$this->assertFalse ( $room->light );
	}
	public function testGetPowerSum() {
		$room = new Room ();
		
		$data = $this->buildRoomData ();
		$room->exchangeArray ( $data );
		
		$sum = $room->power_device + $room->power_light + $room->power_temperature;
		
		$this->assertEquals ( $sum, $room->getPowerSum () );
	}
	private function buildRoomData() {
		$data = array (
				
				'apartment_id' => 1,
				'light' => true,
				'name' => 'Kueche',
				'power_device' => 0,
				'power_light' => 100,
				'power_temperature' => 50,
				'temperature' => 20,
				'temperature_outside' => 15 
		);
		
		return $data;
	}
}

?>