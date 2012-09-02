<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/template/Page.php");
require_once("$root/../lib/auth/UserAuth.php");

abstract class PrivatePage extends Page {

  private
    $user = null;

  final protected function authorizeUser() {
    $user_auth = new UserAuth();
    $user = $user_auth->authUser();

    if ($user === null) {
      return false;
    }

    $this->user = $user;
    return true;
  }

  final protected function getUser() {
    return $this->user;
  }

  final protected function getHeaderContent() {
    return
      '<ul>' .
        '<li>' .
          '<a href="/dashboard.php">Dashboard</a>' .
        '</li>' .
        '<li>' .
          '<a href="/logout.php">Logout</a>' .
        '</li>' .
      '</ul>';
  }

  final protected function getFooterContent() {
    return '';
  }

  protected function getPageScripts() {
    return '';
  }

  protected function getPageStyles() {
    return '';
  }

  final protected function getPageType() {
    return 'private';
  }
}
