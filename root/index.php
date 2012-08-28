<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/template/PublicPage.php");

class Homepage extends PublicPage {
  public function getPageContent() {
    return
      '<div id="register">' .
        '<form method="post" action="javascript:void(0)">' .
          '<div id="registerUsername">' .
            '<label>Username</label>' .
            '<input type="text" name="email" />' .
          '</div>' .
          '<div id="registerEmail">' .
            '<label>Email</label>' .
            '<input type="text" name="email" />' .
          '</div>' .
          '<div id="registerPassword">' .
            '<label>Password</label>' .
            '<input type="password" name="password" />' .
          '</div>' .
          '<div id="registerStudentButton">' .
            '<input type="submit" value="Register" />' .
          '</div>' .
        '</form>' .
      '</div>';
  }

  public function getPageTitle() {
    return 'Web Hoster';
  }
}

$page = new Homepage;
$page->render();

?>
