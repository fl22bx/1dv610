<?php 

/**
 *  save new user
 */
class RegisterNewUser
{

	public static function setNewUser (array $arrayWithInformation, $db) {
			$db->connect();
			$dbConnection = $db->getConnection();
			$username = $arrayWithInformation["username"];
			$password = $arrayWithInformation["password"];

			$isDuplicate = self::isUserDuplicate($dbConnection,$username);

			$sql = "INSERT INTO User (name, password)
					VALUES('$username', '$password')
			";

			if (!$isDuplicate) {
				$dbConnection->query($sql);

			} else {
				$db->stopDb();				
				return 'USERISADUPLICATE';
			}
				$db->stopDb();
				return '';

	}

			private static function isUserDuplicate($dbConnection, $username) {

				$sql = " SELECT * from User
					WHERE name = '$username';
					";
				$result = mysqli_query($dbConnection, $sql);
		
				$tmp = mysqli_fetch_assoc($result);

				return isset($tmp["name"]);

			}
}