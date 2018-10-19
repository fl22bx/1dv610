<?php
namespace Model\Calendar;
require_once('Day.php');
/**
 * 
 */
class Month
{
	private $_days = [];
	private $_monthIndex;
	private $_firstDayOfMonth;
	
	function __construct(int $month)
	{
		date_default_timezone_set('UTC');
		$julianDay = gregoriantojd(1,$month,date('Y'));
		$this->_firstDayOfMonth = jddayofweek($julianDay,0);

		$this->_monthIndex = $month;
		$numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
		$this->setDays($numberOfDaysInMonth);
	}

	private function setDays (int $numberOfDays) {
		for($i = 0; $i < $numberOfDays; $i++) {
			$day = new Day();
			array_push($this->_days, $day);
		}
	}
}