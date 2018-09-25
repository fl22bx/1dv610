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
		private $RegisterView;
		private $authenticator;
		private $feedbackCreator;
		private $loggedInWithCookie;
		private $authenticated;
		private $passwordHash;





	function __construct( $LoginView,  $DateTimeView,  $LayoutView,  UserDbAuthenticator $authenticator, $feedbackCreator, RegisterView $r) {
			$this->DateTimeView = $DateTimeView;
			$this->LoginView = $LoginView;
			$this->LayoutView = $LayoutView;
			$this->authenticator = $authenticator;
			$this->feedbackCreator = $feedbackCreator;
			$this->RegisterView = $r;
			$this->sessionHandler();

			
			
		}

		function logInController () {
			if (isset($_POST['LoginView::Password'])) {
				$this->passwordHash = password_hash($_POST['LoginView::Password'], PASSWORD_DEFAULT);
			}

			if (isset($_POST['LoginView::UserName'])) {
				$this->authenticated = $this->authenticator->authenticateUser($_POST['LoginView::UserName'], $this->passwordHash);
			} else if (isset($_POST['LoginView::Logout'])) {
				$this->endSession();
			} else if (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
				$this->authenticated = $this->authenticator->authenticateUser($_COOKIE['LoginView::CookieName'],$_COOKIE['LoginView::CookiePassword']);
				
			} else if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
				$this->authenticated = $this->authenticator->authenticateUser($_SESSION["username"], $_SESSION["password"]);
			}

			// egen funktion
			if (isset($_COOKIE['LoginView::CookieName'])) {
				$this->loggedInWithCookie = $this->authenticated;
			}



			$this->LayoutView->render($this->authenticated, $this->LoginView, $this->DateTimeView,$this->feedbackCreator->getMessage($this->loggedInWithCookie, $this->authenticated), $this->RegisterView );
						$this->setSessionAuth();
		}

		private function endSession () {
			if (isset($_COOKIE['LoginView::CookieName'])) {
				setcookie('LoginView::CookieName');
				setcookie('LoginView::CookiePassword', "");
			}

			$_SESSION["username"] = '';
			$_SESSION["password"] = '';

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
			$_SESSION["password"] = $this->passwordHash;
			} else if ($this->authenticated && isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
			$_SESSION["username"] = $_COOKIE['LoginView::CookieName'];
			$_SESSION["password"] = $this->passwordHash;
			}
		
		}

	}


	
