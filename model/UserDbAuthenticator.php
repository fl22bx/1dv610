<?php
class UserDbAuthenticator {
	private $LoggedInUser;
	private $dbName;
	private $dbConnection;

	function __construct ($dbName,$dbConnection) {
		$this->dbName = $dbName;
		$this->dbConnection = $dbConnection;
	}

	public function authenticateUser ($username, $password) : bool {
		$dbUser = $this->queryDatabaseForUser($username);
		if (isset($dbUser['name'])) {
			if ($dbUser['password'] == $password) {
			return true;
		}

		}
		return false;

	}



	private function queryDatabaseForUser ($username) {

				$sql = " SELECT * from $this->dbName 
				WHERE name = '$username';
				";
				$result = mysqli_query($this->dbConnection, $sql);
		
				return mysqli_fetch_assoc($result);
			

		}
}