<?php
namespace Model\Calendar;
// sätt i view
/**
 * 
 */
class CalendarSettings
{
	private $_nameOfMonths;
	private $_nameOfWeekDays;
	private $_redDays;
	
	public function englishCalendar() : void {
		$this->_nameOfMonths = ["January", "Februar", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->$_nameOfWeekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
	}

		public function swedishCalendar() : void {
		$this->_nameOfMonths = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
		$this->_nameOfWeekDays = ["Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag"];
	}

	public function getNameOfMonths() : Array {
		return $this->_nameOfMonths;
	}

	public function getNameOfWeekDays() : Array {
		return $this->_nameOfWeekDays;
	}

	public function isRedDay(Day $day) : bool {
		// check if red day
		return false;
	}

	private function setRedDays() : void {
		$this->_redDays = [
			// ej räknat ut påsk,
			// kasnke köra med namn 1 = 1 ?
			"1/1", "5/1", "6/1", "30/4", "1/5", "6/6", "24/12", "25/12", "26/12" 
			// midsommarRörligt datum, fredagen och lördagen mellan 19 juni och 25 juni (fredagen före midsommardagen) 
			// Rörligt datum, fredag mellan 30 oktober och 5 november
		];
	}
}
