<?php

/**
 * 
 */
class LogInPercistency
{

	private static $userName = "Session::User";
	private static $password = "Session::Password";
	private $_sqlDatabase;
	private $SQLTableForUsers = 'User';
	
	function __construct(DatabaseMySQL $SqlDatabase)
	{
		$this->_sqlDatabase = $SqlDatabase;
	}

	private function isUserDuplicate(string $username) : bool {

		$sql = " SELECT * from User
				WHERE name = '$username';
					";
		$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
		
			$tmp = mysqli_fetch_assoc($result);

			return isset($tmp["name"]);

	}


		public function getUserFromDB(string $username, string $password) : user {
			$this->_sqlDatabase->connect();
			$userFromDatabase = $this->queryDatabaseForUser($username);
			$isAuthenticated = $this->authenticateUser($password, $userFromDatabase['password']);
			$this->_sqlDatabase->stopDb();

			if(!$isAuthenticated)
				throw new Exception("not_auth", 21);
			$user = new User($userFromDatabase['name'], $userFromDatabase['password']);
			return $user;
				
		}

		private function authenticateUser (string $Inputpassword, string $Dbpassword) : bool {
		// isnt hashed yet, this part unhashes
		// $bool = password_verify($Inputpassword , $Dbpassword);
		// return $bool;

			return ($Inputpassword == $Dbpassword) ? true : false;

		}

		private function queryDatabaseForUser (string $username) {
				$sql = " SELECT * from $this->SQLTableForUsers 
				WHERE name = '$username';
				";

				$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
				$ResultInAssArray = mysqli_fetch_assoc($result);
				if (!isset($ResultInAssArray))
					throw new Exception("user_dont_exist", 22);

				return $ResultInAssArray;

		}

		public function setSession(User $user) : void {
			$_SESSION[self::$userName] = $user->GetName();
			$_SESSION[self::$password] = $user->GetPassword();

		}

		public function endSession() : void {
			unset($_SESSION[self::$userName]);
			unset($_SESSION[self::$password]);	
			 
		}

		public function isSessionActive () : bool {
			$bool = isset($_SESSION["Session::User"]);
			return $bool;
		}

		public function getSessionUser() : User {
			$user = new User($_SESSION[self::$userName], $_SESSION[self::$password]);
			return $user;
		}



}