<?php
namespace Controller;

/**
 * 
 */
class CalenderHandler
{
	private $_calendarView;
	private $_eventView;
	private $_exceptionHandler;

	function __construct($calenderView, $eventView, \ExceptionHandlerView $exceptionHandlerview)
	{
		$this->_calendarView = $calenderView;
		$this->_eventView = $eventView;
		$this->_exceptionHandler = $exceptionHandlerview;
	}

	public function startCalender() {
		$this->registerEvent();
		return $this->_calendarView;
	} 

	private function registerEvent() : void {
		try {
			if($this->_calendarView->wantsToRegisterEvent()) {
				$this->_eventView->setDate($this->_calendarView->getEventMonth(),
							$this->_calendarView->getEventDay());
				$this->_calendarView->registerEvent($this->_eventView->response());

			}
			if($this->_eventView->isEventRegistered()){
				$event = $this->_eventView->getEvent();
			}
		} catch (\Exception $e) {
			$msg = $this->_exceptionHandler->handleErrorRendering($e);
			$this->_calendarView->setMessage($msg);
		}

	}
}
		