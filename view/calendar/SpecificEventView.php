<?php
namespace View\Calender;

/**
 * 
 */
class ClassName extends AnotherClass
{
	
	public function renderEvent(Model\Calendar\Event $event) : string {
		    	'<div class="registerevent">	
    		    	<a href="?calendar" class="closeevent">X</a>
					<p>Name '.$event->getDay().'</p>
					<p>Name '.$event->getPlace().'</p>
					<p>Name '.$event->getDescription().'</p>
				</div>';
	}
}