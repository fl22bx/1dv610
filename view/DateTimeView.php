<?php

class DateTimeView {


	public function show() {

		$date = getdate();

		$timeString = "$date[weekday], the $date[mday]th of $date[month] $date[year], The time is ";
		$time =  '$date[hours]:$date[minutes]';

		$timeString2 = 'Wednesday, the 19th of September 2018, The time is ';

		return '<p>' . $timeString . '</p>';
	}
}