<?php

namespace ApartmentRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ApartmentRestController extends AbstractRestfulController {
	public function getList() {
		return new JsonModel ( array (
				
				'inhalt' => 'hallo' 
		)
		 );
	}
	public function get($id) {
	}
	public function create($data) {
	}
	public function update($id, $data) {
	}
	public function delete($id) {
	}
}