<?php

class DateTimeView {


	public function show() {
		date_default_timezone_set('America/Los_Angeles');
		$date = getdate();

		$timeString = "$date[weekday], the $date[mday]th of $date[month] $date[year], The time is ";
		$time =  "$date[hours]:$date[minutes]";



		return "<p> $timeString $time</p>";
	}
}