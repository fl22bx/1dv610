<?php


class LayoutView {
  
  /*
  LayoutView

  */
  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, $inputMessage, RegisterView $r) {
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
              ' . $v->response($inputMessage, $isLoggedIn, $r) . '
              
              ' . $dtv->show() . '
         </div>
         </body>
      </html>
    ';
  }
  
  /*
  Logged in header

  */
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
