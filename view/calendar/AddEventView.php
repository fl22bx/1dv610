<?php
namespace View\Calender;

/**
 * 
 */
class AddEventView implements \IDivHtml // ta bort, rendera ovanför kalender
{
	private static $eventName = "Event::Name";
		private static $eventPlace = "Event::Place";
			private static $eventDescription = "Event::Description";
	private $_day;
	private $_month;
	
	function response()
	{
		return $this->createForm();
	}

    public function setMessage(string $message) : void {
    	//
    }

    private function createForm () : string {
    	return '
    	<div>	
	    	<fieldset>
	    		<legend>Register a new Event</legend>
				<form action="/?calendar" method="post">
					<label for="'.Self::$eventName.'">Event Name</label>
										<br />
					<input type="text" id='.Self::$eventName.'>
										<br />
					<label for="'.Self::$eventPlace.'">Event Place</label>
										<br />
					<input type="text" id='.Self::$eventPlace.'>
										<br />
					<label for="'.Self::$eventDescription.'">Event Description</label>
															<br />
					<textarea rows="4" cols="50" id='.Self::$eventDescription.'> </textarea>
				</form>
			</fieldset>	
		</div>';
    }

    public function setDate(int $momth, int $day) : void {
    	//
    }

        public function setUser(\User $user = null) { 
    	// ska bort
    }

}