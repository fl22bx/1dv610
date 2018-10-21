<?php
namespace View\Calender;

/**
 * 
 */
class CalendarView implements \View\IDivHtml
{

	private static $_eventMonth = "Event::Month";
	private static $_eventDay = "Event::Day";
	private $_calendar;
	private $_calenderSettings;
	private $_registerForm;
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
		'.$this->_registerForm.'
			<ul class="weekdays">
				' . $this->calenderHeader() . '
	
			</ul>
			<ul class="days">
				' . $this->daysInCalender(0) . '
			</ul>


		</div>
		';
	 }

	 public function registerEvent(string $registerForm) {
	 	$this->_registerForm = $registerForm;
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

	 private function daysInCalender(int $monthToViewInRelation) : string {
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
				<div class="add"><a href="?calendar&'.Self::$_eventDay.'='.$day->getDate().'&'.Self::$_eventMonth.'='.$monthToView.'">+</a></div>
				
				<p class="event" > '.$this->events($day->getDate()).'</p>

				</li>
				';
		}


	 	return $result;
	 }

	 private function events(int $day) : string {
	 	$name = "";
	 	$place = "";
	 	$description = "";
	 	foreach ($this->_events as $event) {
	 		if($event->getDay() == $day) {
	 			$name = $event->getName();
	 			$place = $event->getPlace();
	 			$description = $event->getDescription();
	 		}
	 	}
	 	return '
	 	<p class="eventdet">'.$name.'</p>
	 	<p class="eventdet">'.$place.'</p>
	 	<p class="eventdet">'.$description.'</p>
	 	';
	 }

	 public function setEvents(array $userEvents) : void {
	 	$this->_events = $userEvents;
	 }


	public function setMessage (string $message) : void {
		$this->_message = $message;
	}

    public function wantsToRegisterEvent() : bool {
    	if(isset($_GET[Self::$_eventDay]) || isset($_GET[Self::$_eventMonth]))
    		return true;
    	else
    		return false;
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