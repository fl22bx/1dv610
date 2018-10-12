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

/*
	connects to db

*/
		public function connect () {
			$this->dbConnection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

			if($this->dbConnection == false)
			{
			   die(mysqli_connect_error());
			}

		}

/*
	stops db

*/
		public function stopDb () {
			$this->dbConnection->close();
		}


		public function getdbName () {
			return $this->dbName;
		}

		public function getConnection () {
			return $this->dbConnection;
		}

		private function displayErrors () {
			if ($conn->connect_error) {
    		echo "Failed to connect to database: " . mysqli_connect_error(); // view
			} 
		}

	}
