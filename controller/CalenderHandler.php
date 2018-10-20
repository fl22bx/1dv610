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
	private $_eventPercistency;

	function __construct($calenderView, $eventView, \ExceptionHandlerView $exceptionHandlerview, 
		\EventPercistency $eventPercistency)
	{

		$this->_calendarView = $calenderView;
		$this->_eventView = $eventView;
		$this->_exceptionHandler = $exceptionHandlerview;
		$this->_eventPercistency = $eventPercistency;
	}

	public function startCalender(string $nameOfloggedInUser) {
		$this->registerEvent($nameOfloggedInUser);
		return $this->_calendarView;
	} 

	private function registerEvent(string $nameOfloggedInUser) : void {
		try {
			if($this->_calendarView->wantsToRegisterEvent()) {
				$this->_eventView->setDate($this->_calendarView->getEventMonth(),
							$this->_calendarView->getEventDay());
				$this->_calendarView->registerEvent($this->_eventView->response());

			}
			if($this->_eventView->isEventRegistered()){
				$event = $this->_eventView->getEvent();
				$event->setOwner($nameOfloggedInUser);
				$this->_eventPercistency->setNewUser($event);
				$msg = "Event Succefull Added";
			}
		} catch (\Exception $e) {
			$msg = $this->_exceptionHandler->handleErrorRendering($e);
			$this->_calendarView->setMessage($msg);
		}

	}
}
		