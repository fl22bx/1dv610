<?php
class UserDbAuthenticator {
	private $LoggedInUser;
	private $dbName;
	private $dbConnection;

	function __construct ($dbName,$dbConnection) {
		$this->dbName = $dbName;
		$this->dbConnection = $dbConnection;
	}

	public function authenticateUser ($input) {
		$this->queryDatabaseForUser($input);
	}



	private function queryDatabaseForUser ($username) {
		$sql = " SELECT * from $this->dbName 
		WHERE name = '$username';
		";
		$result = mysqli_query($this->dbConnection, $sql);

		$row = mysqli_fetch_assoc($result);

				echo $row[name];

		}
}