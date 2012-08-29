<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/../lib/template/PrivatePage.php");

class Dashboard extends PrivatePage {

  protected function getPageContent() {
    return
      '<p>Hello world!</p>' .
      '<p>Userid: ' . $this->getUser()->getUserID() . '</p>' .
      '<p>Username: ' . $this->getUser()->getUsername() . '</p>';
  }

  protected function getPageTitle() {
    return 'Logged in dashboard';
  }
}

$page = new Dashboard();
$page->render();

?>
