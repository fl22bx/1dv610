<?php

class NavigatorView {
	private static $calendar = "calendar";

	public function show() {
		

		return '
			<a href="?' . self::$calendar . '">Calendar</a>
		';
	}

	public function wantsToViewCalendar() : bool {
		return isset($_GET[self::$calendar]);
	}
}