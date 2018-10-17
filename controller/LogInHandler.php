<?php

/**
 * 
 */
class LogInHandler
{
	private $_layoutView;
	private $_logInView;
	private $_registerView;
	private $_logInDb;
	private $_loggedInUser;
	private $_exceptionHandlerview;


	
	function __construct(LoginView $logInView, LayoutView $layoutView, LogInPercistency $logInDb, ExceptionHandlerView $exceptionHandlerview, RegisterView $registerView)
	{
			$this->_layoutView = $layoutView;
			$this->_logInView = $logInView;
			$this->_registerView = $registerView;
			$this->_exceptionHandlerview = $exceptionHandlerview;
			$this->_logInDb = $logInDb;
	}

	public function startLogInHandler() {
		try {
			$msg = "";
			$this->handleLogOutRequest();
			$this->handleCookiesLogIn();
			$this->handleSession();
			$this->handleLogInTry();
			$this->handleKeepMeLoggedIn();

		} catch (exception $e) {
			$msg = $this->_exceptionHandlerview->handleErrorRendering($e);
		} finally {
			$this->setLogedInUserToView();
			$viewToRender = $this->navigateLogInView();
			$this->_layoutView->startView($viewToRender, $msg);
		}

	}

	private function setLogedInUserToView() : void {
		if(isset($this->_loggedInUser))
			$this->_layoutView->setUser($this->_loggedInUser);
	}

	private function navigateLogInView () : IDivHtml {
		if ($this->_logInView->wantsToRegister())
			return $this->_registerView;
		else 
			return $this->_logInView;

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
		$this->_loggedInUser = new User($userName, $password);
		$authenticated = $this->_logInDb->isAuthenticated($this->_loggedInUser);
		$this->_loggedInUser->setAuthenticated($authenticated);

		if (!$authenticated)
			throw new Exception("not_auth", 21);
			
		$this->_logInDb->setSession($this->_loggedInUser);
		}
	}

	private function handleKeepMeLoggedIn() : void {
		if ($this->_logInView->wantsToStayLoggedIn()) 
			$this->_logInView->stayLoggedIn($this->_loggedInUser->GetName(),$this->_loggedInUser->GetPassword());

	}

	private function isLoggedIn() : bool {
		if(isset($this->_loggedInUser))
			return $this->_loggedInUser->isLoggedIn();
		else
			return false;
	}

	private function handleCookiesLogIn() : void {
		if($this->_logInView->isCookieSet()) {
			$this->_loggedInUser = new User($this->_logInView->getCookieUsername(), $this->_logInView->getCookiePassword());
			$this->_logInView->setCookieMessage();
		} 
	}
}