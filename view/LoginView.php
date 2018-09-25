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

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($inputMessage, $loggedInBool) {

		// $message = '';
		if (!$loggedInBool && isset($_POST['LoginView::UserName'])) {
			$UsernameUsed = $_POST['LoginView::UserName'];
		} else {
			$UsernameUsed = '';
		}

		$message = $inputMessage;
		$response = $this->generateLoginFormHTML($message, $UsernameUsed);
		if ($loggedInBool) {
			// $response .= $this->generateLogoutButtonHTML($message);
			$response = $this->generateLogoutButtonHTML($message);
		}

		$this->generateCoockie($loggedInBool);
		
		return $response;
	}

	public function generateCoockie ($loggedInBool) {

		if (isset($_POST[self::$keep]) && $loggedInBool = true ) {
			$passwordHash = password_hash($_POST['LoginView::Password'], PASSWORD_DEFAULT);
			setcookie(self::$cookieName, $_POST['LoginView::UserName']);
			setcookie(self::$cookiePassword, $passwordHash);
		} else if (isset($_COOKIE[self::$cookiePassword])) {
			// rehash
			// setcookie(self::$cookiePassword, $passwordHash);
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
				'. $this->rndHiddenKey() .'
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
					'. $this->rndHiddenKey() .'
				</fieldset>
			</form>

		';
	}

	private function rndHiddenKey () {
		$rndHiddenKey = rand(1000000, 9999999999);
		return '<input type="hidden" name="hiddenKey" value="'. $rndHiddenKey .'" />';
		 
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		echo 'hello etRequestUserName' ;
	}
	
}