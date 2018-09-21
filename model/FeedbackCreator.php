<?php

/**
 * 
 */
class FeedbackCreator
{
	private $welcome = 'Welcome';
	private $missingUsername = "Username is missing";
	private $missingPassword = "Password is missing";
	private $wronCredentials = "Wrong name or password";
	private $cookieWelcome = "Welcome back with cookie";
	private $byeMessage = "Bye bye!";
	
	function __construct()
	{
		# code...
	}

	public function getMessage ($loggedInWithCookie) {
		// var_dump($_SESSION);
		$tmpMessage = $this->generateFeedback();

		if ($loggedInWithCookie) {
			return $this->cookieWelcome;
		}

		if ($_SESSION['feedback'] == $this->welcome  && $tmpMessage == $this->welcome) {;
			return '';
		}
		if ($_SESSION['feedback'] == $this->byeMessage  && $tmpMessage == $this->byeMessage) {;
			return '';
		}

		$_SESSION['feedback'] = $tmpMessage;



		return $_SESSION['feedback'];
	}

	private function generateFeedback () {
			if (isset($_POST['LoginView::UserName'])) {
				if($_POST['LoginView::UserName'] == '') {
					return $this->missingUsername;

				} else if ($_POST['LoginView::Password'] == '') {
					return $this->missingPassword;

				} else if ($_SESSION["loggedInBoolian"] == false && $_POST['LoginView::UserName'] != '' && $_POST['LoginView::Password'] != '') {
					return $this->wronCredentials;

				} 	else if ($_SESSION["loggedInBoolian"]) {
					return $this->welcome;
				}
			} 

			if (isset($_POST['LoginView::Logout'])) {
				return $this->byeMessage;
			}
	}

} 


