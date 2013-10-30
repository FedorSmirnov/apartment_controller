<?php

namespace AlbumRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Album\Form\AlbumForm;
use Album\Model\Album;
use Zend\View\Model\JsonModel;

// Meine Beispielklasse, um zu sehen, wie ein RestfulServer im zf2 Framework aussieht

class AlbumRestController extends AbstractRestfulController {
	protected $albumTable;
	
	// Methode wird aufgerufen, wenn die url ohne id eingegeben wird
	public function getList() {
		$json = new JsonModel ();
		$content = $json->content;
		
		return new JsonModel ( array (
				'daten' => $content 
		) );
	}
	
	// Das Gleiche, nur eben mit id
	public function get($id) {
		// $album = $this->getAlbumTable ()->getAlbum ( $id );
		$result = 'blabla ' . $id;
		return new JsonModel ( array (
				'daten' => $result 
		) );
	}
	
	// Aufgerufen bei einem httppost request
	public function create($data) {
		$string = $data ['content'];
		
		return new JsonModel ( array (
				"content" => $string 
		) );
	}
	
	// Aufgerufen bei einem httpput request
	public function update($id, $data) {
	}
	public function delete($id) {
	}
	public function getAlbumTable() {
		if (! $this->albumTable) {
			$sm = $this->getServiceLocator ();
			$this->albumTable = $sm->get ( 'Album\Model\AlbumTable' );
		}
		return $this->albumTable;
	}
}

?>