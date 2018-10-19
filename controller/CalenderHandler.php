<?php
namespace Controller\Calender;

/**
 * 
 */
class CalenderHandler
{
	private $_calendarHandler;
	
	function __construct($calenderView)
	{
		$this->_calendarHandler = $calenderView;
	}

	public function startCalender() {
		// return $this->_calendarHandler;
	} 
}