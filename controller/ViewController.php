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
		private $loggedInBoolian = false;




	function __construct( $LoginView,  $DateTimeView,  $LayoutView,  UserDbAuthenticator $authenticator) {
			$this->DateTimeView = $DateTimeView;
			$this->LoginView = $LoginView;
			$this->LayoutView = $LayoutView;
			$this->authenticator = $authenticator;
		}

		function logInController () {
			if (isset($_POST['LoginView::UserName'])) {
				$this->loggedInBoolian = $this->authenticator->authenticateUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
			}

			$this->LayoutView->render($this->loggedInBoolian, $this->LoginView, $this->DateTimeView, $this->setMessage());
		}

		private function setMessage () {
			if (isset($_POST['LoginView::UserName'])) {
				if($_POST['LoginView::UserName'] == '') {
					return "Username is missing";
				} else if ($_POST['LoginView::Password'] == '') {
					return "Password is missing";
				} else if ($this->loggedInBoolian == false && $_POST['LoginView::UserName'] != '' && $_POST['LoginView::Password'] != '') {
					return "Username or Passwrod is wrong";
				}
			}
			
		}
	}	