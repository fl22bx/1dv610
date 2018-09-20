<?php 
	class DatabaseMySQL {
		private $servername;
		private $username;
		private $password;
		private $dbName;
		private $dbConnection;

		 function __construct ($Servername, $Username,$password, $DbName){

			$this->servername = $Servername;
			$this->username = $Username;
			$this->password = $password;
			$this->dbName = $DbName;
		} 

		public function connect () {
			echo $this->servername;
			$this->dbConnection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

				$sql = " SELECT * from User 
				WHERE name = 'fredrik';
				";
				$result = mysqli_query($this->dbConnection, $sql);
		
				 $t = mysqli_fetch_assoc($result);

				 echo $t[name];

		}

		public function getdbName () {
			return $this->dbName;
		}

		public function getConnection () {
			return $this->dbConnection;
		}

		private function displayErrors () {
			if ($conn->connect_error) {
    		echo "Failed to connect to database: " . mysqli_connect_error();
			} 
		}

	}

/*
function queryUser ($user) {

// query string
$sql = "SELECT $user from user;";
// query
$result = mysqli_query($conn, $sql);
// query to array
$row = mysqli_fetch_assoc($result);
}
*/

//$sql = "INSERT INTO User (name, password)
//VALUES ('fredrik', 'test')";