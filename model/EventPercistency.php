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
		$day = $event->getDay();
		$month = $event->getMonth();
		$name = $event->getName();
		$place = $event->getPlace();
		$description = $event->getDescription();
		$owner = $event->getOwner();

		$sql = "INSERT INTO Events (day, month, name, place, description, owner)
			VALUES('$day', '$month', '$name', '$place', '$description', '$owner')
		";
		$conn = $this->_sqlDatabase->getConnection();
		$conn->query($sql);
		$this->_sqlDatabase->stopDb();
	}

	public function getEvents(string $userName) {
		$sql = "SELECT * from Events WHERE owner = "$userName""

		$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
		$ResultInAssArray = mysqli_fetch_assoc($result);

		return $ResultInAssArray;
	}
}