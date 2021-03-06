<?php 

/**
 * 
 */
class RegisterView
{
	private static $userName = 'RegisterView::UserName';
	private static $name = 'LoginView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $message = 'RegisterView::Message';
	private static $register = 'DoRegistration';

	function handelView ($inputMessage) {
		return $this->render($inputMessage);

	}

	/*
	Render register form

	*/
	function render($message)
	{
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register a new user</legend>
					<p id="' . self::$message . '">' . $message . '</p>
					
					<label for="' . self::$userName . '">Username :</label>
					<input type="text" id="' . self::$userName . '" name="' . self::$userName . '" value="' . $this->usedUsername($message) .'" />
					<br />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<br />
					<label for="' . self::$passwordRepeat . '">Repeat Password  :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
					<br />
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>

		';
	}

/*
	if error returns wich username

*/
	private function usedUsername ($message) {
		if (!$this->checkPasswordLengthIsMoreThen6()) {
			return $this->getUsername();
		} else if (!$this->isUsernameLongerThenThree()) {
			return $this->getUsername();
		} else if (!$this->checkPasswordLengthIsMoreThen6()) {
			return $this->getUsername();
		} else if (!$this->checkIfPasswordMatches()) {
			return $this->getUsername();
		} else if ($this->checkIfinValidChar()) {
			$username = $this->getUsername();
			return strip_tags($username);
		}else if ($message != '') {
    		return $this->getUsername();
		}
		return '';
		
	}

/*
	new user array

*/
	public function newUserDetailsArray () {
		$newUser = $this->getUsername();
		$newPassword = $this->getPassword(); 
		return  array('username' => $newUser, 'password' => $newPassword);
	}

/*
	password from post

*/
	private function getPassword () {
		if (isset($_POST[self::$password])) {
			return $_POST[self::$password];
		}

	}

	private function getPasswordRepeat () {
		if (isset($_POST[self::$passwordRepeat])) {
			return $_POST[self::$passwordRepeat];
		}
	}

/*
	username from post

*/
		private function getUsername () {
		if (isset($_POST[self::$userName])) {
			return $_POST[self::$userName];
		}
	}

/*
	check input for invalid characters

*/
	private function checkIfinValidChar() {
		$username = $this->getUsername();
		$regExp = '/[<>]/';
		if (isset($username) && preg_match($regExp, $username, $matches)) {
			return true;
		} else {
			return false;
		}

	}

/*
	chackes if password matches

*/

		public function checkIfPasswordMatches() : bool {
		$password = $this->getPassword();
		$passwordRepeat = $this->getPasswordRepeat();

		if (isset($password) && isset($passwordRepeat)) {
			if ($password == $passwordRepeat) {
			return true;
			} else {
			return false;
			}
		}
		return true;
	}

/*
	passwordvalidation

*/
	public function checkPasswordLengthIsMoreThen6() : bool  {
		$password = $this->getPassword();
		if (isset($password)) {
				if(strlen($password) >= 6) {
					return true;
				} else {
					return false;
				}
			}
			return true;
	}

		public function isUsernameLongerThenThree() : bool {
		$username = $this->getUsername();
		if (isset($username)){
				if(strlen($username) >= 3) {
					return true;
				} else {
					return false;
				}
			}

			return true;
	}

/*
	flash dispatcher

*/
	public function registerViewDispatchFeedbackAction () {
		if (!$this->checkIfPasswordMatches()) {
			return 'DOPASSWORDMATCH';
		} else if (!$this->isUsernameLongerThenThree() && !$this->checkPasswordLengthIsMoreThen6()) {
			return 'USERNAMEANDPASSWORDISTOSHORT';
		}else if (!$this->isUsernameLongerThenThree()) {
			return 'USERNAMESHORTERTHENSIX';
		}  else if (!$this->checkPasswordLengthIsMoreThen6()) {
			return "PASSWORDLONGERTHEN6";
		} else if ($this->checkIfinValidChar()) {
			return 'INVALIDCHARACTERS';
		}

		return "";
	}




}