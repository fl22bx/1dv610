<?php
class UserDbAuthenticator {
	private $LoggedInUser;
	private $dbName;
	private $dbConnection;
	private $dbTableUser = 'User';
	private $db;

	function __construct ($db) {
		$this->db = $db;
	}

	public function authenticateUser ($username, $password) : bool {
		$this->db->connect();

		$dbUser = $this->queryDatabaseForUser($username);
		if (isset($dbUser['name'])) {
			$bool = password_verify($dbUser['password'] , $password);
			return $bool;
		}

		$this->db->stopDb();
		return false;

	}



	private function queryDatabaseForUser ($username) {
				$dbConnection = $this->db->getConnection();
				$sql = " SELECT * from $this->dbTableUser 
				WHERE name = '$username';
				";
				// $result = mysqli_query($this->dbConnection, $sql);
				$result = mysqli_query($dbConnection, $sql);
		
				return mysqli_fetch_assoc($result);
			

		}
}