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
		private $authenticated;





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
				$this->authenticated = $this->authenticator->authenticateUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
			} else if (isset($_POST['LoginView::Logout'])) {
				$this->endSession();
			} else if (isset($_COOKIE['LoginView::CookieName'])) {
				$this->authenticated = $this->authenticator->authenticateUser($_COOKIE['LoginView::CookieName'],$_COOKIE['LoginView::CookiePassword']);
				$this->loggedInWithCookie = $this->authenticated;
			} else if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
				$this->authenticated = $this->authenticator->authenticateUser($_SESSION["username"], $_SESSION["password"]);
			}





			$this->LayoutView->render($this->authenticated, $this->LoginView, $this->DateTimeView,$this->feedbackCreator->getMessage($this->loggedInWithCookie, $this->authenticated) );
						$this->setSessionAuth();
		}

		private function endSession () {
			if (isset($_COOKIE['LoginView::CookieName'])) {
				setcookie('LoginView::CookieName');
				setcookie('LoginView::CookiePassword', "");
			}

			$this->authenticated = false;

		}

		private function sessionHandler () {
			session_start();
			if (!isset($_SESSION["feedback"]))  {
				$_SESSION["feedback"] = '';
			}
			if (!isset($_SESSION["username"]))  {
				$_SESSION["username"] = '';
			}
			if (!isset($_SESSION["password"]))  {
				$_SESSION["password"] = '';
			}

		}

		private function setSessionAuth () {
		if ($this->authenticated && isset($_POST['LoginView::UserName']) && isset($_POST['LoginView::Password'])){
			$_SESSION["username"] = $_POST['LoginView::UserName'];
			$_SESSION["password"] = $_POST['LoginView::Password'];
			} else if ($this->authenticated && isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
			$_SESSION["username"] = $_COOKIE['LoginView::CookieName'];
			$_SESSION["password"] = $_COOKIE['LoginView::CookiePassword'];
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

	
