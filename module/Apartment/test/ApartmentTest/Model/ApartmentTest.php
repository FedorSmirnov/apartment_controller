<?php

namespace ApartmentTest\Model;

use Apartment\Model\Apartment;

class ApartmentTest extends \PHPUnit_Framework_TestCase {
	public function testApartmentInitialState() {
		$apartment = new Apartment ();
		
		$this->assertNull ( $apartment->adress );
		$this->assertNull ( $apartment->floor );
		$this->assertNull ( $apartment->id );
		$this->assertNull ( $apartment->power );
		$this->assertNull ( $apartment->room_num );
	}
	public function testExchangeArraySetTheValuesProperly() {
		$apartment = new Apartment ();
		
		$data = $this->buildApartmentData ();
		
		$apartment->exchangeArray ( $data );
		
		$this->assertSame ( $data ['adress'], $apartment->adress );
		$this->assertSame ( $data ['floor'], $apartment->floor );
		$this->assertSame ( $data ['id'], $apartment->id );
		$this->assertSame ( $data ['power'], $apartment->power );
		$this->assertSame ( $data ['room_num'], $apartment->room_num );
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$apartment = new Apartment ();
		$data = $this->buildApartmentData ();
		
		$apartment->exchangeArray ( $data );
		$apartment->exchangeArray ( array () );
		
		$this->assertNull ( $apartment->adress );
		$this->assertNull ( $apartment->floor );
		$this->assertNull ( $apartment->id );
		$this->assertNull ( $apartment->power );
		$this->assertNull ( $apartment->room_num );
	}
	public function testGetArrayCopyReturnsAnArrayWithPropertyValues() {
		$data = $this->buildApartmentData ();
		$apartment = new Apartment ();
		$apartment->exchangeArray ( $data );
		$copyArray = $apartment->getArrayCopy ();
		
		$this->assertSame ( $data ['adress'], $copyArray ['adress'] );
		$this->assertSame ( $data ['floor'], $copyArray ['floor'] );
		$this->assertSame ( $data ['id'], $copyArray ['id'] );
		$this->assertSame ( $data ['power'], $copyArray ['power'] );
		$this->assertSame ( $data ['room_num'], $copyArray ['room_num'] );
	}
	public function testInputFiltersAreSetCorrectly() {
		$apartment = new Apartment ();
		
		$inputFilter = $apartment->getInputFilter ();
		
		$this->assertEquals ( 4, $inputFilter->count () );
		$this->assertTrue ( $inputFilter->has ( 'id' ) );
		$this->assertTrue ( $inputFilter->has ( 'adress' ) );
		$this->assertTrue ( $inputFilter->has ( 'room_num' ) );
		$this->assertTrue ( $inputFilter->has ( 'floor' ) );
	}
	private function buildApartmentData() {
		$data = array (
				
				'adress' => 'Praterstrasse 3',
				'room_num' => 1,
				'id' => 1,
				'power' => 100,
				'floor' => 1 
		);
		
		return $data;
	}
}
?>
