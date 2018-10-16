<?php
require_once('view/IDivHtml.php');

class LoginView implements IDivHtml {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $_message;

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response(bool $isLoggedIn) {
		if($isLoggedIn) {
			$this->setWelcomeMessage();
			$response = $this->generateLogoutButtonHTML();
		} else {
			$response = $this->generateLoginFormHTML();
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->_message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML() {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->_message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function isLogInTry() : bool {
		$logInTrytUsername = isset($_POST[self::$name]);
		$logInTrytPassword = isset($_POST[self::$password]);
		if ($logInTrytUsername || $logInTrytPassword)
			return true;
		else
			return false;
	}

	public function setMessage (string $message) : void {
		$this->_message .= $message;
	}

	public function setWelcomeMessage () : void {
		// check if session maby?
		$this->setMessage("welcome");
	}

	public function setByeMessage () : void {
		// check if session maby or loged in before? not exist dont render
		$this->setMessage("ByeBye");
	}

	public function getRequestUserName() : string {
		return $_POST[self::$name];
	}

	public function getRequestPassword() : string {
		return $_POST[self::$password];
	}

	public function wantsToLogOut() : bool {
		$logOutBool = isset($_POST[self::$logout]);
		if($logOutBool)
			$this->setByeMessage();
		return $logOutBool;
	}

	public function wantsToStayLoggedIn () : bool {
		return isset($_POST[self::$keep]);
	}

	public function stayLoggedIn (string $username, string $password) : void {
		setcookie(self::$cookieName, $username, time()+60);
		setcookie(self::$cookiePassword, $password, time()+60);
	}
	
}