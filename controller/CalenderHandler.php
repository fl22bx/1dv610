<?php
namespace Controller;

/**
 * 
 */
class CalenderHandler
{
	private $_calendarView;
	private $_eventView;
	
	function __construct($calenderView, $eventView)
	{
		$this->_calendarView = $calenderView;
		$this->_eventView = $eventView;
		$this->registerEvent();
	}

	public function startCalender() {
		//return $this->_calendarView;
		return $this->_eventView;
	} 

	private function registerEvent() : void {
		// return  eventregister view kanske?
		if($this->_calendarView->wantsToRegisterEvent())
			echo "yes";
	}
}