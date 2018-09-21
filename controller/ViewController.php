<?php
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

/**
	 * 
	 */
	class ViewController
	{
		private $DateTimeView;
		private $LoginView;
		private $LayoutView;
		private $authenticator;
		private $feedbackCreator;
		private $loggedInWithCookie;





	function __construct( $LoginView,  $DateTimeView,  $LayoutView,  UserDbAuthenticator $authenticator, $feedbackCreator) {
			$this->DateTimeView = $DateTimeView;
			$this->LoginView = $LoginView;
			$this->LayoutView = $LayoutView;
			$this->authenticator = $authenticator;
			$this->feedbackCreator = $feedbackCreator;
			$this->sessionHandler();

			
			
		}

		function logInController () {
			if (isset($_POST['LoginView::UserName'])) {
				$_SESSION["loggedInBoolian"] = $this->authenticator->authenticateUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
			} else if (isset($_POST['LoginView::Logout'])) {
				$this->endSession();
			} else if (isset($_COOKIE['LoginView::CookieName'])) {
				
				$authenticated = $this->authenticator->authenticateUser($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword']);
				$_SESSION["loggedInBoolian"] = $authenticated;
				$this->loggedInWithCookie = $authenticated;

				// spara username och password i seassion istället, nu kan man komma rnt inloggning
			}

			$this->LayoutView->render($_SESSION["loggedInBoolian"], $this->LoginView, $this->DateTimeView,$this->feedbackCreator->getMessage($this->loggedInWithCookie) );
		}

		private function endSession () {
			if (isset($_COOKIE['LoginView::CookieName'])) {
				setcookie('LoginView::CookieName');
				setcookie('LoginView::CookiePassword', "");
			}

			$_SESSION["loggedInBoolian"] = false;

		}

		private function sessionHandler () {
			session_start();
			if (!isset($_SESSION["loggedInBoolian"]))  {
				$_SESSION["loggedInBoolian"] = false;
			}

						if (!isset($_SESSION["feedback"]))  {
				$_SESSION["feedback"] = '';
			}
		}


		
		}

 /*
		private function setMessage () {
			if (isset($_POST['LoginView::UserName'])) {
				if($_POST['LoginView::UserName'] == '') {
					return "Username is missing";
				} else if ($_POST['LoginView::Password'] == '') {
					return "Password is missing";
				} else if ($_SESSION["loggedInBoolian"] == false && $_POST['LoginView::UserName'] != '' && $_POST['LoginView::Password'] != '') {
					return "Wrong name or password";
				} 	else if ($_SESSION["loggedInBoolian"] && $this->handleKeySession()) {
					return "Welcome";
				}
			} 

			if ($this->loggedInWithCookie) {
				return "Welcome back with cookie";
			}

			if (isset($_POST['LoginView::Logout']) && $this->handleKeySession()) {
				return "Bye bye!";
			}
			
		}

		// testerna sparar inte seesion så fungerar ej, kom på annan lösning
		private function createKeySession() {
			if (isset($_POST["hiddenKey"])) {
				$_SESSION["hiddenKey"] = $_POST["hiddenKey"];
			}
		}

		private function handleKeySession () : bool {
			if (isset($_SESSION["hiddenKey"]) && isset($_POST["hiddenKey"]) && $_SESSION["hiddenKey"] == $_POST["hiddenKey"]) {
				return false;
			} else {
				return true;
			}
			
		}
		*/

	
