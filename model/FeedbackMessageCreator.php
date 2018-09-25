<?php 

/**
 * 
 */
class FeedbackMessageCreator 
{
	// messages
	private $welcome = 'Welcome';
	private $missingUsername = "Username is missing";
	private $missingPassword = "Password is missing";
	private $wronCredentials = "Wrong name or password";
	private $cookieWelcome = "Welcome back with cookie";
	private $byeMessage = "Bye bye!";

	private $passwordMatchFeedback = "Passwords do not match.";
	private $passwordLengthMessage = "Password has too few characters, at least 6 characters.";
	private $userNameLenghtMessage = "Username has too few characters, at least 3 characters.";

	// Messageconditionals
	private $loggedOutCondition = 'LOGGEDOUT';
	private $loggedInCondition = 'LOGGEDIN';
	private $wrongCredentialsCondition = 'WRONGCREDENTIALS';
	private $missingUsernameCondition = 'MISSINGUSERNAME';
	private $missingPasswordCondition = 'MISSINGPASSWORD';
	private $authWithCookieCondition = 'LOGGEDINWITHCOOKIE';

	private $passwordMatch = 'DOPASSWORDMATCH';
	private $passwordLength = "PASSWORDLONGERTHEN6";
	private $userNameLenght = 'USERNAMESHORTERTHENSIX';
	
	function CreateFeedback($conditional)
	{

		switch ($conditional) {
			case $this->passwordMatch:
				return $this->passwordMatchFeedback;
				break;
			case $this->loggedOutCondition:
				if ($_SESSION['feedback'] != $this->byeMessage) {
					$_SESSION['feedback'] = $this->byeMessage;
					return $this->byeMessage;
					}
				break;
			case $this->loggedInCondition:
					if ($_SESSION['feedback'] != $this->welcome) {
					$_SESSION['feedback'] = $this->welcome;
					return $this->welcome;
					}
				break;							
			case $this->wrongCredentialsCondition:
				return $this->wronCredentials;
				break;
			case $this->missingUsernameCondition:
				return $this->missingUsername;
				break;
			case $this->missingPasswordCondition:
				return $this->missingPassword;
				break;
			case $this->authWithCookieCondition:
					if ($_SESSION['feedback'] != $this->cookieWelcome) {
					$_SESSION['feedback'] = $this->cookieWelcome;
					return $this->cookieWelcome;
					}
				break;
			case $this->passwordLength:
				return $this->passwordLengthMessage;
				break;
			case $this->userNameLenght:
				return $this->userNameLenghtMessage;
				break;																							
			default:
				return '';
				break;
		}
	}
}