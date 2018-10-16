<?php 

/**
 * 
 */
class ExceptionHandlerView 
{

	public function handleErrorRendering (Exception $e) {
		switch ($e->getCode()) {
			case 10:
				# user empty name
				break;
			case 11:
				# empty password
				break;
			case 12:
				# name smaller the 3
				break;
			case 13:
				# unauth char
				break;

			case 14:
				# password size
				break;
			case 21:
				# not auth
				break;
			case 22:
				# user dont exist
				break;
			
			default:
				# code...
				break;
		}
	}
}