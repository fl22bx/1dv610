<?php
class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $loggedIn = false;

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($inputMessage, $loggedInBool, RegisterView $r) {
		$this->loggedIn = $loggedInBool;

		$UsernameUsed = $this->usedUsername();;
		$message = $inputMessage;
		$response = $this->generateRegisterLink();

		if ($this->isRegisterLinkSet()) {
			$response .= $r->handelView($inputMessage);
		} else {
			$response .= $this->generateLoginFormHTML($message, $UsernameUsed);
		}

		if ($loggedInBool) {
			 $response = $this->generateLogoutButtonHTML($message);
		}

		$this->generateCoockie();
		
		return $response;
	}


	public function generateCoockie () {

		if (isset($_POST[self::$keep]) && $this->loggedInl = true ) {
			$passwordHash = password_hash($_POST['LoginView::Password'], PASSWORD_DEFAULT);
			setcookie(self::$cookieName, $_POST['LoginView::UserName'], time() - 3600);
			setcookie(self::$cookiePassword, $passwordHash, time() - 3600);
		} 
		
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {

		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $UsernameUsed) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $UsernameUsed . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>

		';
	}

	function generateRegisterLink() {
		if ($this->isRegisterLinkSet()) {
			$_SESSION['feedback'] = '';
			return' <a href="/">Back to login</a>';
		} else {
			return' <a href="?register">Register a new user</a>';
		}

	}

	private function usedUsername () {
		if (isset($_GET['username'])){
			return $_GET['username'];
		}else if (!$this->loggedIn) {
			return $this->getRequestUserName();
		} else {
			$UsernameUsed = '';
		}
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		if (isset($_POST['LoginView::UserName'])) {
			return $_POST['LoginView::UserName'];
		} else {
			return '';
		}
	}

	private function getRequestPasswod() {
		if (isset($_POST[self::$password])) {
			return $_POST[self::$password];
		} else {
			return '';
		}
	}




	private function isRegisterLinkSet() : bool {
		return isset($_GET['register']);
	}


	
	//feedbackpart
	private function isLoggedOutSet($authenticated) : bool {
		return isset($_POST[self::$logout]);
	}

	private function isLoggedInSet($authenticated) : bool {
		return $authenticated;
	}

	private function wrongCredentials() : bool {
		if(!$this->loggedIn && $this->getRequestUserName() != '' && $this->getRequestPasswod() != '') {
			return true;
		} else {
			return false;
		}
	}

	private function missingUsername() : bool {
	if(isset($_POST['LoginView::UserName']) && $this->getRequestUserName() == '') {
		return true;
		} else {
			return false;
		}
	}

		private function missingPassword() : bool {
	if(isset($_POST['LoginView::UserName']) && $this->getRequestPasswod() == '') {
		return true;
		} else {
			return false;
		}
	}

	private function loggedInWithCookie() : bool {
		if(isset($_COOKIE['LoginView::CookieName'])) {
		return true;
		} else {
			return false;
		}
	}

	private function getMessageFromGet () {
		if(isset($_GET['message'])) {
			return $_GET['message'];
		}
		return '';
	}

	public function feedbackChecker ($authenticated) {
	 if ($this->isLoggedOutSet(!$authenticated)) {
			return 'LOGGEDOUT';

		} else if ($this->loggedInWithCookie()) {
			return 'LOGGEDINWITHCOOKIE';

		} else if ($this->isLoggedInSet($authenticated)) {
			return 'LOGGEDIN';

		} else if ($this->wrongCredentials()) {
			return 'WRONGCREDENTIALS';

		} else if ($this->missingUsername()) {
			return 'MISSINGUSERNAME';

		} else if ($this->missingPassword()) {
			return 'MISSINGPASSWORD';

		} else if ($this->getMessageFromGet() != '') {
			return $this->getMessageFromGet();

		} else {
			return '';
		}
	}
	
}