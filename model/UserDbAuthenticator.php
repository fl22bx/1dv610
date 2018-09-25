<?php
class UserDbAuthenticator {
	private $LoggedInUser;
	private $dbName;
	private $dbConnection;
	private $dbTableUser = 'User';

	function __construct ($dbName,$dbConnection) {
		$this->dbName = $dbName;
		$this->dbConnection = $dbConnection;
	}

	public function authenticateUser ($username, $password) : bool {
		$dbUser = $this->queryDatabaseForUser($username);
		if (isset($dbUser['name'])) {
			$bool = password_verify($dbUser['password'] , $password);
			return $bool;
		}

		
		return false;

	}



	private function queryDatabaseForUser ($username) {

				$sql = " SELECT * from $this->dbTableUser 
				WHERE name = '$username';
				";
				$result = mysqli_query($this->dbConnection, $sql);
		
				return mysqli_fetch_assoc($result);
			

		}
}