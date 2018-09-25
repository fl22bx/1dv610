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
	

	public function getMessage ($loggedInWithCookie, $authenticated) {
		// var_dump($_SESSION);
		$tmpMessage = $this->generateFeedback($authenticated);

		if ($loggedInWithCookie && $_SESSION['feedback'] != $this->cookieWelcome) {
			$tmpMessage = $this->cookieWelcome;
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

	private function generateFeedback ($authenticated) {
			if (isset($_POST['LoginView::UserName'])) {
				if($_POST['LoginView::UserName'] == '') {
					return $this->missingUsername;

				} else if ($_POST['LoginView::Password'] == '') {
					return $this->missingPassword;

				} else if ($authenticated == false && $_POST['LoginView::UserName'] != '' && $_POST['LoginView::Password'] != '') {
					return $this->wronCredentials;

				} 	else if ($authenticated) {
					return $this->welcome;
				}
			} 

			if (isset($_POST['LoginView::Logout'])) {
				return $this->byeMessage;
			}
	}

} 


