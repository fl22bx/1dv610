<?php

class LayoutView {
  
  private $_loggedInUser;
  private $_dtv;
    private $_navigator;

    function __construct(DateTimeView $dtv)
  {
    $this->_dtv = $dtv;
    //$this->_navigator = $navigator;
  }

  public function startView(IDivHtml $ViewToRender) : void {
    if (isset($this->_loggedInUser))
      $ViewToRender->setUser($this->_loggedInUser);
    $this->render($ViewToRender);
  }

  private function render(IDivHtml $ViewToRender) {

    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>

          ' . $this->renderIsLoggedIn() . '
          
          <div class="container">
              ' . $ViewToRender->response() . '
              
              ' . $this->_dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

/*
  public function showNavigator () : string {
        if($this->userIsLoggedIn())
          return $this->_navigator->show();
        else
          return "";
  }
  */

  // i login View kanske??
  private function renderIsLoggedIn() : string {
    if ($this->userIsLoggedIn()) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  public function setUser(User $user = null) : void {
    $this->_loggedInUser = $user;
  }

  public function userIsLoggedIn() : bool {
    if (isset($this->_loggedInUser))
      return $this->_loggedInUser->isLoggedIn();
    else
      return false;
  }
}
