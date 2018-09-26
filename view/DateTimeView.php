<?php

class DateTimeView {


	public function show() {
		date_default_timezone_set('America/Los_Angeles');
		$date = date('l\,');
		$date .= ' the ';
		$date  .= date('jS \of F Y\,');
		$date .= ' The time is ';
		$date .= date('H\:i');

		// $timeString = "$date[weekday], the $date[mday] of $date[month] $date[year], The time is ";
		// $time =  "$date[hours]:$date[minutes]";



		return "<p> $date</p>";
	}
}