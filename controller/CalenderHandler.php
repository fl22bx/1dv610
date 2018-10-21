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

	function __construct(\View\Calender\CalendarView $calenderView, $eventView, \View\ExceptionHandlerView $exceptionHandlerview, 
		\Model\Calendar\EventPercistency $eventPercistency)
	{
		$this->_calendarView = $calenderView;
		$this->_eventView = $eventView;
		$this->_exceptionHandler = $exceptionHandlerview;
		$this->_eventPercistency = $eventPercistency;
	}

	public function startCalender(string $nameOfloggedInUser, int $month = 13 ) {
		if($month == 13)
			$month = date('n') - 1;


		$userEvents = $this->_eventPercistency->getEvents($nameOfloggedInUser, $month);
		$this->registerEvent($nameOfloggedInUser);
		$this->viewEvent($userEvents);
		$this->_calendarView->setEvents($userEvents);
		return $this->_calendarView;
	} 

	private function registerEvent(string $nameOfloggedInUser) : void {
		try {
			if($this->_calendarView->wantsToRegisterEvent()) {
				$this->_eventView->setDate($this->_calendarView->getEventMonth(),
							$this->_calendarView->getEventDay());
				$this->_calendarView->renderOverlayDiv($this->_eventView->response());

			}
			if($this->_eventView->isEventRegistered()){
				$event = $this->_eventView->getEvent();
				$event->setOwner($nameOfloggedInUser);
				$this->_eventPercistency->setNewEvent($event);
				$msg = "Event Succefull Added";
			}
		} catch (\Exception $e) {
			$msg = $this->_exceptionHandler->handleErrorRendering($e);
			$this->_calendarView->setMessage($msg);
		}

	}

	private function viewEvent(array $userEvents) : void {
		if($this->_calendarView->wantsToViewEvent()) {
			$day = $this->_calendarView->getEventDay();

			$view = new \View\Calender\EventView();
			$this->_calendarView->renderOverlayDiv($view->renderEvent($userEvents, $day));
		}

	}
}
		