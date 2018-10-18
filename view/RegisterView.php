<?php 

/**
 * 
 */
class RegisterView implements IDivHtml
{
	private static $userName = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $message = 'RegisterView::Message';
	private static $register = 'DoRegistration';

	private $_message = "";
	private $_loggedInUser;
	
		function response() : string {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register a new user</legend>
					<p id="' . self::$message . '">' . $this->_message . '</p>
					
					<label for="' . self::$userName . '">Username :</label>
					<input type="text" id="' . self::$userName . '" name="' . self::$userName . '" value="' . $this->usedUsername() .'" />
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

			<a href="/">Back to login</a>

		';
	}

	private function usedUsername() : string {
		if (isset($this->_loggedInUser))
			return $this->_loggedInUser->GetName();
		else if (isset($_POST[self::$userName]))
			return $_POST[self::$userName];
		 else 
    		return "";
	}
	public function sucess() : bool {
		return isset($_GET[username]);
	}

	 public function setUser(User $user = null) : void {
    	$this->_loggedInUser = $user;
  	}	

	public function setMessage (string $message) : void {
		$this->_message .= $message;
	}

	public function wantsToCreateNewUser() : bool {
		if(isset($_POST[self::$userName]) || isset($_POST[self::$password]))
			return true;
		else 
			return false;
	}

	public function newUser() : User {
		if($_POST[self::$password] != $_POST[self::$passwordRepeat])
			throw new Exception("password_match", 42);
			
		return new User($_POST[self::$userName], $_POST[self::$password]);
	}
}