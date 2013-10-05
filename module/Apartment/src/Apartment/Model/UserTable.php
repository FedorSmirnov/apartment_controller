<?php

namespace Apartment\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable extends TableGateway {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function findUser($name, $password) {
		$rowset = $this->tableGateway->select ( array (
				
				'name' => $name,
				'password' => $password 
		)
		 );
		
		$row = $rowset->current();
		
		if(!$row){
			return false;
		}else{
			
			return $row;
		}
	}
}

?>