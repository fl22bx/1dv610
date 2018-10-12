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
		public function connect () : void {
			$this->dbConnection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

			if($this->dbConnection == false)
			{
			   die(mysqli_connect_error());
			}

		}
			public function setNewUser (User $user) : void {
			$db->connect();
			$isDuplicate = $this->isUserDuplicate($this->dbConnection,$username);
			if($isDuplicate)
				throw new Exception();

			$sql = "INSERT INTO User (name, password)
					VALUES('$username', '$password')
			";

			$dbConnection->query($sql);
			$db->stopDb();

	}

			private function isUserDuplicate(string $dbConnection, string $username) : bool {

				$sql = " SELECT * from User
					WHERE name = '$username';
					";
				$result = mysqli_query($dbConnection, $sql);
		
				$tmp = mysqli_fetch_assoc($result);

				return isset($tmp["name"]);

			}

/*
	stops db

*/
		public function stopDb () {
			$this->dbConnection->close();
		}


		private function displayErrors () {
			if ($conn->connect_error) {
    		throw new Exception();
			} 
		}

	}
