<?php
namespace Model\Calendar;
require_once('Month.php');
/**
 * 
 */
class Calendar
{
	private $_months = [];

	
	function __construct()
	{
		for($i = 1; $i <= 12; $i++ ) {
			$month = new Month($i);
			array_push($this->_months, $month);
		}
		
	}

}