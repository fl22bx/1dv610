<?php 

/**
 * 
 */
class User
{
	private  $_name;
	private  $_password;
	private $_authenticated = false;

	public function GetName () : string {
		return $this->_name;
	}

	public function GetPassword () : string {
		return $this->_password;
	}

	public function isLoggedIn() : bool {
		return $this->_authenticated;
	}
	
	function __construct(string $name, string $password )
	{

		#if($name == "")
		#	throw new Exception("name_missing", 10);
		#if($password == "")
		#	throw new Exception("password_missing", 11); // sätt i vie är view logic inte model
		$this->setName($name);
		$this->setPassword($password) ;// hash
	}

	private function setName (string $name) : void {
		if(strlen($name) <= 3)
			throw new Exception("name_to_short", 12);
		if (preg_match('/[<>]/', $name))
			throw new Exception("invalid_char", 13);
		
		$this->_name = $name;
	}

	private function setPassword (string $password) : void {
		if(strlen($password) < 6)
			throw new Exception("password_to_short", 14);
		$this->_password = $password;
	}

	public function authenticate(bool $authenticated) : void{
		$this->_authenticated = $authenticated;
	}
}