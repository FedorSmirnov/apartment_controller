<?php

namespace Apartment\Model;

class Room {
	public $apartment_id;
	public $name;
	public $power_light;
	public $power_temperature;
	public $power_device;
	public $temperature;
	public $temperature_outside;
	public $light;
	public function exchangeArray($data) {
		if (! empty ( $data ['apartment_id'] )) {
			$this->apartment_id = $data ['apartment_id'];
		} else {
			$this->apartment_id = null;
		}
		
		if (! empty ( $data ['name'] )) {
			$this->name = $data ['name'];
		} else {
			$this->name = null;
		}
		
		if (! empty ( $data ['power_light'] )) {
			$this->power_light = $data ['power_light'];
		} else {
			$this->power_light = null;
		}
		
		if (! empty ( $data ['power_temperature'] )) {
			$this->power_temperature = $data ['power_temperature'];
		} else {
			$this->power_temperature = null;
		}
		
		if (! empty ( $data ['power_device'] )) {
			$this->power_device = $data ['power_device'];
		} else {
			$this->power_device = null;
		}
		
		if (! empty ( $data ['temperature'] )) {
			$this->temperature = $data ['temperature'];
		} else {
			$this->temperature = null;
		}
		
		if (! empty ( $data ['light'] )) {
			$this->light = $data ['light'];
		} else {
			$this->light = null;
		}
		if (! empty ( $data ['temperature_outside'] )) {
			$this->temperature_outside = $data ['temperature_outside'];
		} else {
			$this->temperature_outside = null;
		}
	}
}

?>