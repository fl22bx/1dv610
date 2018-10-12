<?php
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('model/RegisterNewUser.php');
require_once('model/UserDbAuthenticator.php');
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
		private $db;
		private $feedbackFromModel = "";



	function __construct($dataBase, $feedbackCreator) {
			$this->db = $dataBase;
			$this->LoginView = new LoginView();
			$this->DateTimeView = new DateTimeView();
			$this->LayoutView = new LayoutView();
			$this->RegisterView = new RegisterView();
			$this->authenticator = new UserDbAuthenticator($this->db);
			$this->feedbackCreator = $feedbackCreator;
			$this->sessionHandler();

			
			
		}

/*
	main controller

*/

		function logInController () {
			if (isset($_POST['LoginView::Password'])) {
				$this->passwordHash = password_hash($_POST['LoginView::Password'], PASSWORD_DEFAULT);
			}

			if (isset($_POST['LoginView::UserName'])) {
				$this->authenticated = $this->authenticator->authenticateUser($_POST['LoginView::UserName'], $this->passwordHash);
			} else if (isset($_POST['LoginView::Logout'])) {
				$this->endSession();
			} else if (isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
				$cookieAuth = $this->authenticator->authenticateUser($_COOKIE['LoginView::CookieName'],$_COOKIE['LoginView::CookiePassword']);
				if ($cookieAuth) {
					$this->authenticated = true;
				} else {
					$this->authenticated = false;
					$this->feedbackFromModel = 'COOKIEMANIPULATION';
				}

				
			} else if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION['agent'] == $_SERVER['HTTP_USER_AGENT']) {
				$this->authenticated = $this->authenticator->authenticateUser($_SESSION["username"], $_SESSION["password"]);
			} else {
				$this->authenticated = false;
			}

			$this->registerNewUserInDB();

			$_SESSION['loggedIn'] = $this->authenticated;
	
			$feedback = $this->feedbackHandlerer();



			$this->LayoutView->render($this->authenticated, $this->LoginView, $this->DateTimeView, $feedback, $this->RegisterView);

			$this->setSessionAuth();
		}

/*
	destroys session

*/
		private function endSession () {
			if (isset($_COOKIE['LoginView::CookieName'])) {
				setcookie('LoginView::CookieName');
				setcookie('LoginView::CookiePassword', "");
			}

			$_SESSION["username"] = '';
			$_SESSION["password"] = '';
			$_SESSION['loggedIn'] = false;

			$this->authenticated = false;

		}

/*
	saves new user in db

*/
		public function registerNewUserInDB () {
			$tmpNewUserArray = $this->RegisterView->newUserDetailsArray();
			if($this->RegisterView->registerViewDispatchFeedbackAction() == '' && isset($tmpNewUserArray['username'])) {
				$this->feedbackFromModel = RegisterNewUser::setNewUser($tmpNewUserArray, $this->db);
				if($this->feedbackFromModel == '') {
				$this->redirect($tmpNewUserArray['username']);					
				}

			}

		}

/*
	link handler

*/
		private function redirect($username) {
			header("Location:/?username=$username&message=registersucess");
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
			if (!isset($_SESSION['loggedIn']))  {
				$_SESSION['loggedIn'] = false;
			}

			if (!isset($_SESSION['hasBeenLoggedIn']))  {
				$_SESSION['hasBeenLoggedIn'] = false;
			}

			if (!isset($_SESSION['agent']))  {
				$_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
			}


		}

/*
	set session
*/
		private function setSessionAuth () {
		if ($this->authenticated && isset($_POST['LoginView::UserName']) && isset($_POST['LoginView::Password'])){
			$_SESSION["username"] = $_POST['LoginView::UserName'];
			$_SESSION["password"] = $this->passwordHash;
			} else if ($this->authenticated && isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
			$_SESSION["username"] = $_COOKIE['LoginView::CookieName'];
			$_SESSION["password"] = $this->passwordHash;
			}

		
		}

/*
	actions to feedbackcreator

*/
		private function feedbackHandlerer () {
			$feedbackMessage = '';
			$checkFeedbackLogInView = $this->LoginView->feedbackChecker($this->authenticated);
			$checkFeedbackRegisterView = $this->RegisterView->registerViewDispatchFeedbackAction();

			if ($this->feedbackFromModel != '') {
				$feedbackMessage = $this->feedbackFromModel;
			}else if ($checkFeedbackLogInView != '') {
				$feedbackMessage = $checkFeedbackLogInView;
			} else if ($checkFeedbackRegisterView != '') {
				$feedbackMessage = $checkFeedbackRegisterView;
			} 
			
			return $this->feedbackCreator->CreateFeedback($feedbackMessage);
		}

	}


	
