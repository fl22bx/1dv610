<?php
namespace Controller;

/**
 * 
 */
class CalenderHandler
{
	private $_calendarView;
	
	function __construct($calenderView)
	{
		$this->_calendarView = $calenderView;
	}

	public function startCalender() {
		return $this->_calendarView;
	} 
}