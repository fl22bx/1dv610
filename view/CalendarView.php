<?php
require_once('view/IDivHtml.php');

/**
 * 
 */
class CalendarView implements IDivHtml
{
	private $_calendar;
	private $_calenderSettings;


	function __construct(Model\Calendar\Calendar $calendar, model\Calendar\CalendarSettings $calSetting)
		 {
		    $this->_calendar = $calendar;
		    $this->_calenderSettings = $calSetting;
		 }


	public function response() : string {
		return '
		<div class="calendar">	
			<ul class="weekdays">
				' . $this->calenderHeader() . '
	
			</ul>
			<ul class="days">
				' . $this->daysInCalender(0) . '
			</ul>


		</div>
		';
	 }

	 private function calenderHeader() : string {
	 	$this->_calenderSettings->swedishCalendar();
	 	$weekdays = $this->_calenderSettings->getNameOfWeekDays();
	 	$header = "";
	 	foreach ($weekdays as $weekday) {
	 		$header .= '	
	 		<li class=" li">	
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
				' . $day->getDate() .'
				</li>
				';
		}


	 	return $result;
	 }

    public function setMessage(string $message) {
    	//
    }

    public function setUser(User $user = null) : void {
    	//
    }
}