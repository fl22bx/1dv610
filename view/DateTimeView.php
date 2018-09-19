<?php

class DateTimeView {


	public function show() {

		$date = getdate();

		$timeString = "$date[weekday], the $date[mday]th of $date[month] $date[year], The Time is $date[hours]:$date[minutes]";
		$time =  '$date[hours]:$date[minutes]';

		return '<p>' . $timeString . '</p>';
	}
}