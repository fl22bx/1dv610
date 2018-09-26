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
	private $succesfulRegistrationmessage = "Registered new user.";
	private $remembermemessage = "Welcome and you will be remembered";
	private $passwordMatchFeedback = "Passwords do not match.";
	private $passwordLengthMessage = "Password has too few characters, at least 6 characters.";
	private $userNameLenghtMessage = "Username has too few characters, at least 3 characters.";
	private $invalidCharactersMessage = 'Username contains invalid characters.';
	private $usserandpassshortmess ="Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.";
	private $userDuplicateMessage = "User exists, pick another username.";
	private $cookieManupulationMessage = "Wrong information in cookies";

	// Messageconditionals
	private $loggedOutCondition = 'LOGGEDOUT';
	private $loggedInCondition = 'LOGGEDIN';
	private $wrongCredentialsCondition = 'WRONGCREDENTIALS';
	private $missingUsernameCondition = 'MISSINGUSERNAME';
	private $missingPasswordCondition = 'MISSINGPASSWORD';
	private $authWithCookieCondition = 'LOGGEDINWITHCOOKIE';
	private $succesfulRegistration = 'registersucess';
	private $rememberMe = 'REMEMBERME';
	private $passwordMatch = 'DOPASSWORDMATCH';
	private $passwordLength = "PASSWORDLONGERTHEN6";
	private $userNameLenght = 'USERNAMESHORTERTHENSIX';
	private $invalidCharacters = 'INVALIDCHARACTERS';
	private $usserandpassshort ='USERNAMEANDPASSWORDISTOSHORT';
	private $dbUserIsDuplicated = 'USERISADUPLICATE';
	private $cookieManipulation = 'COOKIEMANIPULATION';
	
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
				if ($_SESSION['feedback'] != $this->welcome && $_SESSION['feedback'] != $this->remembermemessage) {
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
					if ($_SESSION['feedback'] != $this->cookieWelcome && $_SESSION['feedback'] != $this->welcome&& $_SESSION['feedback'] != $this->remembermemessage) {
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

			case $this->dbUserIsDuplicated:
					return $this->userDuplicateMessage;
					break;																		

			case $this->invalidCharacters:
					return $this->invalidCharactersMessage;
					break;	

			case $this->succesfulRegistration:
				if ($_SESSION['feedback'] != $this->succesfulRegistrationmessage) {
					$_SESSION['feedback'] = $this->succesfulRegistrationmessage;
					return $this->succesfulRegistrationmessage;
					}
					break;	

			case $this->usserandpassshort:
					return $this->usserandpassshortmess;
					break;				
			
			case $this->cookieManipulation:
					return $this->cookieManupulationMessage;
					break;				
			
			case $this->rememberMe:
					return $this->remembermemessage;
					break;			

			default:
					return '';
					break;
		}
	}
}