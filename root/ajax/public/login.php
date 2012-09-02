<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/AjaxScript.php");
require_once("$root/../lib/auth/UserAuth.php");
require_once("$root/../lib/user/User.php");

class Login extends AjaxScript {
  protected function getResponse() {
    $user_auth = new UserAuth();

    if (!$user_auth->emailExists($this->data['email']) {
      return 'error username';
    }

    $user = $user_auth->login($this->data['email'], $this->data['password']);

    if ($user !== null) {
      return 'success';
    } else {
      return 'error password';
    }
  }
}

$login_script = new Login();
$login_script->execute(array('email', 'password'));

?>
