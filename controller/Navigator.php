<?php
namespace Controller;

/**
 * 
 */
class Navigator
{
	private $_layoutView;
	private $_logInHandler;
	private $_calenderHandler;

	function __construct(\LayoutView $layoutView, \LogInHandler $logInHandler)
	{
		$this->_layoutView = $layoutView;
		$this->_logInHandler = $logInHandler;
		$this->_calenderHandler = $calenderHandler;

	}

	public function Navigate () : void {
		$viewToRender = $this->_logInHandler->startLogInHandler();
		//$this->_layoutView->startView($viewToRender);
		}


	}
