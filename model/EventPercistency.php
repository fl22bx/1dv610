<?php
/**
 * 
 */
class EventPercistency
{
	private $_sqlDatabase;
	
	function __construct(DatabaseMySQL $SqlDatabase)
	{
		$this->_sqlDatabase = $SqlDatabase;
	}

	public function setNewUser (Model\Calendar\Event $event) {
		$this->_sqlDatabase->connect();
		$dbConnection = $this->_sqlDatabase->getConnection();
		$day = $event->getDay();
		$month = $event->getMonth();
		$name = $event->getName();
		$place = $event->getPlace();
		$description = $event->getDescription();
		$owner = $event->getOwner();

		$sql = "INSERT INTO Event (day, month, name, place, description, owner)
			VALUES('$event', '$event->getDay', '$event', '$event', '$event')
		";
		$conn = $this->_sqlDatabase->getConnection();
		$conn->query($sql);
		$this->_sqlDatabase->stopDb();
	}
}