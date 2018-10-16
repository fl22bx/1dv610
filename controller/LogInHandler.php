<?php

/**
 * 
 */
class LogInHandler
{
	private $_layoutView;
	private $_logInView;
	private $_logInDb;
	private $_loggedInUser = null;
	private $_exceptionHandlerview;

	
	function __construct(LoginView $logInView, LayoutView $layoutView, LogInPercistency $logInDb, ExceptionHandlerView $exceptionHandlerview)
	{
			$this->_layoutView = $layoutView;
			$this->_logInView = $logInView;
			$this->_exceptionHandlerview = $exceptionHandlerview;
			$this->_logInDb = $logInDb;
	}

	public function startLogInHandler() {
		try {
			$msg = "";
			$this->handleLogOutRequest();
			$this->handleSession();
			$this->handleLogInTry();
			$this->handleKeepMeLoggedIn();

		} catch (exception $e) {
			$msg = $e->getMessage();
		} finally {
			$this->_layoutView->render($this->isLoggedIn(), $this->_logInView, $msg);
		}

	}

	private function handleSession () : void {
		if ($this->_logInDb->isSessionActive())
			$this->_loggedInUser = $this->_logInDb->getSessionUser();
	}

	private function handleLogOutRequest () {
		if ($this->_logInView->wantsToLogOut())
			$this->_logInDb->endSession();
	}

	private function handleLogInTry () : void {
		$isLogInTry = $this->_logInView->isLogInTry();
		if($isLogInTry) {
		$userName = $this->_logInView->getRequestUserName();
		$password = $this->_logInView->getRequestPassword();
		$this->_loggedInUser = $this->_logInDb->getUserFromDB($userName, $password);
		$this->_logInDb->setSession($this->_loggedInUser);
		}
	}

	private function handleKeepMeLoggedIn() : void {
		if ($this->_logInView->wantsToStayLoggedIn()) 
			$this->_logInView->stayLoggedIn($this->_loggedInUser->GetName(),$this->_loggedInUser->GetPassword());

	}

	private function isLoggedIn() : bool {
		return isset($this->_loggedInUser);
	}
}