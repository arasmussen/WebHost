<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/../lib/PrivatePage.php");

class Dashboard extends PrivatePage {

  protected function getPageContent() {
    return '<p>Hello world! Userid: ' . $this->getUser()->getUserID() . '</p>';
  }

  protected function getPageTitle() {
    return 'Logged in dashboard';
  }
}

$page = new Dashboard();
$page->render();

?>
