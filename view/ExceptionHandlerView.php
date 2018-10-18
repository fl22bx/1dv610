<?php 

/**
 * 
 */
class ExceptionHandlerView 
{

	public function handleErrorRendering (Exception $e) {
		switch ($e->getCode()) {
			case 10:
				return "Username is missing";
				break;
			case 11:
				return "Password is missing";
				break;
			case 12:
				return "name smaller the 3";
				break;
			case 13:
				return "unauth char";
				break;

			case 14:
				return "password size";
				break;
			case 21:
				return "Wrong name or password";
				break;
			case 22:
				return "Wrong name or password" ;
				break;
			case 31:
				return "Wrong information in cookies" ;
				break;
			default:
				# code...
				break;
		}
	}
}