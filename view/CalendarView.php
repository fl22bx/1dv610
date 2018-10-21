<?php
namespace View\Calender;

/**
 * 
 */
class CalendarView implements \View\IDivHtml
{

	private static $_eventMonth = "Event::Month";
	private static $_eventDay = "Event::Day";
	private static $_add = "Event::Add";
	private static $_view = "Event::View";
	private $_calendar;
	private $_calenderSettings;
	private $_divOverlay;
	private $_message = "";
	private $_user;
	private $_events;


	function __construct(\Model\Calendar\Calendar $calendar, \model\Calendar\CalendarSettings $calSetting)
		 {
		    $this->_calendar = $calendar;
		    $this->_calenderSettings = $calSetting;
		 }


	public function response() : string {	
		return '
		<div class="calendar">
		<p>'.$this->_message.'</p>
		'.$this->_divOverlay.'
			<ul class="weekdays">
				' . $this->calenderHeader() . '
	
			</ul>
			<ul class="days">
				' . $this->daysInCalender(0) . '
			</ul>


		</div>
		';
	 }

	 public function renderOverlayDiv(string $divOverlay) {
	 	$this->_divOverlay = $divOverlay;
	 }

	 private function calenderHeader() : string {
	 	$this->_calenderSettings->swedishCalendar();
	 	$weekdays = $this->_calenderSettings->getNameOfWeekDays();
	 	$header = "";
	 	foreach ($weekdays as $weekday) {
	 		$header .= '	
	 		<li class="dayName li">	
					'.$weekday.'
			</li>';
	 	}
	 	return $header;
	 }

	 private function daysInCalender(int $monthToViewInRelation = 0) : string {
	 	$date = date('n');
	 	$monthToView = $date - 1 + $monthToViewInRelation;
	 	$Month = $this->_calendar->getMonth($monthToView);
	 	$firstWeekDay = $Month->getFirstDay();
	 	$days = $Month->getDays();

		$result = "";
		for($i = 1; $i < $firstWeekDay; $i++) {
				$result .= '
				<li class="li day shadowed">	
				</li>
				';
		}

		foreach ($days as $day) {
			$result .=  '
				<li class="li day">	
				<p class="dateNumber">' . $day->getDate() .' </p>
				<div class="add"><a href="?calendar&'.Self::$_add.'&'.Self::$_eventDay.'='.$day->getDate().'&'.Self::$_eventMonth.'='.$monthToView.'">+</a></div>
				
				<p class="event" > '.$this->events($day->getDate(), $monthToView).'</p>

				</li>
				';
		}


	 	return $result;
	 }

	 private function events(int $day, int $month) : string {
	 	$eventsCalc = 0;
	 	foreach ($this->_events as $event) {
	 		if($event->getDay() == $day) {
	 			$eventsCalc++;
	 		}
	 	}
	 	return '
	 	<a href="?calendar&'.Self::$_view.'&'.Self::$_eventMonth.'='.$month.'&
	 	'.Self::$_eventDay.'='.$day.'" class="eventCalc">Events('.$eventsCalc.')</a>
	 	';
	 }

	 public function setEvents(array $userEvents) : void {
	 	$this->_events = $userEvents;
	 }

	 public function wantsToViewEvent() : bool {
	 	return isset($_GET[Self::$_view]);
	 }


	public function setMessage (string $message) : void {
		$this->_message = $message;
	}

    public function wantsToRegisterEvent() : bool {
    	return isset($_GET[Self::$_add]);

    }

    public function setUser(\Model\LogInModel\User $user = null) : void {
    	$this->_user = $user;
    }

    public function getEventDay() : string {
    	return $_GET[Self::$_eventDay];
    }

    public function getEventMonth() : string {
    	return $_GET[Self::$_eventMonth];
    }

}