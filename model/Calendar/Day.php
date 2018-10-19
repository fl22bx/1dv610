<?php
namespace Model\Calendar;
/**
 * 
 */
class Day
{
	private $_dayIndex;
	private $_isRed;
	private $_hollidayName = "";
	
	function __construct()
	{

	}

	public function setHollidayStatus () : void {
		$this->_isRed = $isRed;
		$this->_hollidayName = $specialName;
	}

	public function getHollidayName() : string {
		return $this->_hollidayName;
	}

	public function isRed() : bool {
		return $this->_isRed;
	}

	public function getDayIndex() : string {
		return $this->_dayName;
	}
}