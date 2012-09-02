<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/auth/UserAuth.php");

abstract class AjaxScript {

  protected
    $data = array(),
    $user = null;

  public function execute($keys) {
    if ($this->requiresAuth()) {
      if (!$this->isUserLoggedIn()) {
        echo "not logged in";
        exit();
      }
    }
    if ($this->processKeys($keys)) {
      $response = $this->getResponse();
    } else {
      $response = 'missing data';
    }
    echo $response;
  }

  private function processKeys($keys) {
    foreach ($keys as $key) {
      if (array_key_exists($key, $_POST)) {
        $this->data[$key] = $_POST[$key];
      } else {
        return false;
      }
    }
    return true;
  }

  private function isUserLoggedIn() {
    $user_auth = new UserAuth();
    $this->user = $user_auth->authUser();

    if ($this->user !== null) {
      return true;
    } else {
      return false;
    }
  }

  protected function requiresAuth() {
    return false;
  }

  abstract protected function getResponse();
}

?>
