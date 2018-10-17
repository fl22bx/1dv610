<?php


class LayoutView {
  
  private $_dtv;
    function __construct(DateTimeView $dtv)
  {
    $this->_dtv =  $dtv;
  }

  public function render($isLoggedIn, IDivHtml $ViewToRender, string $message = "") {
    $ViewToRender->setMessage($message); // gör i controlelr
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $ViewToRender->response($isLoggedIn) . '
              
              ' . $this->_dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
