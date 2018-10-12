<?php 

/**
 * 
 */
class User
{
	private  $_name;
	private  $_password;

	public function GetName () : string {
		return $_name;
	}

	public function GetPassword () : string {
		return $_password;
	}
	
	function __construct(string $name, string $password )
	{
		$this->setName($name);
		$this->setPassword($password) ;// hash

		// validate throw errors
	}

	private function setName (string $name) : void {
		if(strlen($name) >= 3)
			throw new Exception(1);
		if (preg_match('/[<>]/', $name))
			throw new Exception(3);
		
		$this->_name = $name;
	}

	private function setPassword (string $password) : void {
		if(strlen($password) >= 6)
			throw new Exception(2);
		$this->_password = $password;
	}
}